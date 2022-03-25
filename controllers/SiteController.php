<?php

namespace app\controllers;

use app\helpers\AuthHelper;
use app\models\ChangePassword;
use app\models\RegistrationForm;
use app\models\User;
use app\models\UserProfile;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'password', 'modify', 'about', 'contact'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'password',
                            'modify',
                            'about',
                        ],
                        'allow' => true,
                        'roles' => [
                            'rl_admin',
                            'rl_admin_system',
                            'rl_admin_security',
                            'rl_operator_electricity',
                            'rl_operator_warm',
                            'rl_operator_water',
                            'rl_applicant',
                            'rl_provider_electricity',
                        ],
                    ],
                    [
                        'actions' => ['contact'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'controller' => 'site',
        ]);
    }

    /**
     * Login action for form in modal window.
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $model->scenario = 'insert';

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $url = $this->getCurrentUrl();
            return $this->redirect($url);
        }

        $this->setCurrentUrl();

        if (Yii::$app->request->isAjax){
            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about profile page in modal window.
     * @param string $id
     * @return string
     */
    public function actionAbout($id)
    {
        $model = $this->findModel($id);
        $userProfile = $this->findProfile($id);
        $model->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax){
            return $this->renderAjax('about', [
                'model' => $model,
                'userProfile' => $userProfile,
            ]);
        } else {
            return $this->render('about', [
                'model' => $model,
                'userProfile' => $userProfile,
            ]);
        }
    }

    /**
     * Displays modify user profile page in modal window.
     * @param string $id
     * @return string
     */
    public function actionModify($id)
    {
        $model = RegistrationForm::findByUserId($id);
        $model->scenario = RegistrationForm::SCENARIO_UPDATE;
        $model->load(Yii::$app->request->post());
        $roles = $this->getRoles();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $model->scenario = 'insert';

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->updateProfile()) {
            $url = $this->getCurrentUrl();

            \Yii::$app->session->setFlash('minnesota_message', '    
                <div class="alert alert-success" role="alert">
                    Профиль пользователя успешно изменен!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ');

            return $this->redirect($url);
        }
        $this->setCurrentUrl();

        if (Yii::$app->request->isAjax){
            return $this->renderAjax('modify', [
                'model' => $model,
                'roles' => $roles,
            ]);
        } else {
            return $this->render('modify', [
                'model' => $model,
                'roles' => $roles,
            ]);
        }
    }

    /**
     * Registration action for form in modal window.
     * @return Response|string
     */
    public function actionRegistration()
    {
        $model = new RegistrationForm();
        $model->scenario = RegistrationForm::SCENARIO_REGISTER;
        $model->role = 'rl_applicant';
        $model->status = User::STATUS_ACTIVE;
        $model->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $model->scenario = 'insert';

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->register()) {
            $url = $this->getCurrentUrl();

            \Yii::$app->session->setFlash('minnesota_message', '    
                <div class="alert alert-success" role="alert">
                    Пользователь успешно зарегистрирован!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ');

            return $this->redirect($url);
        }

        $this->setCurrentUrl();

        if (Yii::$app->request->isAjax){
            return $this->renderAjax('registration', [
                'model' => $model,
            ]);
        } else {
            return $this->render('registration', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Change password action in modal window.
     * @return Response|string
     */
    public function actionPassword()
    {
        $model = new ChangePassword();
        $user = Yii::$app->user;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $model->scenario = 'insert';

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
            Yii::$app->user->login($user->identity, 3600 * 24 * 30);

            \Yii::$app->session->setFlash('minnesota_message', '    
                <div class="alert alert-success" role="alert">
                    Пароль успешно изменен!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ');

            return $this->redirect('index');
        }

        if (Yii::$app->request->isAjax){
            return $this->renderAjax('password', [
                'model' => $model,
            ]);
        } else {
            return $this->render('password', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Setter URI.
     * @return mixed
     */
    public function setCurrentUrl()
    {
        $session = Yii::$app->session;
        $session->set('Login', Yii::$app->request->referrer);
    }

    /**
     * Getter URI.
     * @return mixed
     */
    public function getCurrentUrl()
    {
        $session = Yii::$app->session;
        if ($session['Login'])
            return $session['Login'];
        return 'index';
    }

    /**
     * List of roles available to the user
     * @return array
     */
    public function getRoles()
    {
        $user = Yii::$app->user;
        $roles = AuthHelper::getRoles();
        return $roles;
    }

    /**
     * Finds the user model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the user profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProfile($id)
    {
        if (($model = UserProfile::find()->where(['user_id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
