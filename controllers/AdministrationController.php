<?php

namespace app\controllers;

use app\helpers\AuthHelper;
use app\models\RegistrationForm;
use app\models\search\RegistrationFormSearch;
use app\models\User;
use app\models\UserProfile;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class AdministrationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'clear-filter', 'view', 'update', 'activate', 'deactivate', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['rl_admin_security', 'rl_admin_system', 'rl_admin'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all RegistrationForm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistrationFormSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $roles = new AuthHelper();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'controller' => 'administration',
            'roles' => $roles,
        ]);
    }

    /**
     * Creates a new User.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegistrationForm();
        $model->scenario = RegistrationForm::SCENARIO_REGISTER;
        $model->load(Yii::$app->request->post());
        $roles = $this->getRoles();
        $model->status = User::STATUS_ACTIVE;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $model->scenario = 'insert';

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->register()) {
            $url = $this->getCurrentUrl();

            \Yii::$app->session->setFlash('minnesota_message', '    
                <div class="alert alert-success" role="alert">
                    Новый пользователь успешно добавлен!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ');

            return $this->redirect($url);
        }
        $this->setCurrentUrl();

        if (Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'roles' => $roles,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'roles' => $roles,
            ]);
        }
    }

    /**
     * Displays a single RegistrationForm model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $role = $this->getUserRoles($id);
        $roles = $this->getRolesTranslate();
        if (Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
                'userProfile' => $this->findProfile($id),
                'roles' => $this->getUserRolesTranslate($role, $roles),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
                'userProfile' => $this->findProfile($id),
                'roles' => $this->getUserRolesTranslate($role, $roles),
            ]);
        }
    }

    /**
     * Updates an existing RegistrationForm model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
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
            return $this->renderAjax('update', [
                'model' => $model,
                'roles' => $roles,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'roles' => $roles,
            ]);
        }
    }

    /**
     * Clear filter.
     * @return mixed
     */
    public function actionClearFilter()
    {
        $session = Yii::$app->session;
        if ($session->has('RegistrationFormSearch')) {
            $session->remove('RegistrationFormSearch');
        }
        if ($session->has('RegistrationFormSearchSort')) {
            $session->remove('RegistrationFormSearchSort');
        }

        return $this->redirect('index');
    }

    /**
     * Activate user
     * @param string $id
     * @return array
     */
    public function actionActivate($id)
    {
        $model = $this->findModelByUserId($id);
        $this->setCurrentUrl();
        if ($model->activateUser()) {
            \Yii::$app->session->setFlash('minnesota_message', '    
                <div class="alert alert-success" role="alert">
                    Пользователь успешно активирован 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ');
        }
        $url = $this->getCurrentUrl();
        return $this->redirect($url);
    }

    /**
     * Deactivate user
     * @param string $id
     * @return array
     */
    public function actionDeactivate($id)
    {
        $model = $this->findModelByUserId($id);
        $this->setCurrentUrl();
        if ($model->deactivateUser()) {
            \Yii::$app->session->setFlash('minnesota_message', '    
                <div class="alert alert-success" role="alert">
                    Пользователь успешно деактивирован 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ');
        }
        $url = $this->getCurrentUrl();
        return $this->redirect($url);
    }

    /**
     * Deletes an existing RegistrationForm model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModelByUserId($id);
        $this->setCurrentUrl();

        try {
            $model->deleteRegisteredUser();
            \Yii::$app->session->setFlash('minnesota_message', '    
                <div class="alert alert-success" role="alert">
                    Пользователь успешно удален 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ');
        } catch (\Exception $e) {
            \Yii::$app->session->setFlash('minnesota_message', '    
                <div class="alert alert-error" role="alert">
                    <?= $e->getMessage() ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ');
        } catch (\Throwable $e) {
            \Yii::$app->session->setFlash('minnesota_message', '    
                <div class="alert alert-error" role="alert">
                    <?= $e->getMessage() ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ');
        }

        $url = $this->getCurrentUrl();
        return $this->redirect($url);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
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
        $roles = AuthHelper::getRoles();
        return $roles;
    }

    /**
     * List of roles available to the user
     * @param string $id
     * @return array
     */
    public function getUserRoles($id)
    {
        $roles = AuthHelper::getUserRoles($id);
        return $roles;
    }

    /**
     * List of roles available to the user
     * @return array
     */
    public function getRolesTranslate()
    {
        $roles = AuthHelper::getRolesTranslate();
        return $roles;
    }

    /**
     * List of roles available to the user
     * @param string $role
     * @param string $roles
     * @return array
     */
    public function getUserRolesTranslate($role, $roles)
    {
        $roles = AuthHelper::getUserRolesTranslate($role, $roles);
        return $roles;
    }

    /**
     * Finds the RegistrationForm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    private function findModelByUserId($id)
    {
        $model = RegistrationForm::findByUserId($id);
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('app', 'Пользователь не найден'));
        }
        return $model;
    }
}