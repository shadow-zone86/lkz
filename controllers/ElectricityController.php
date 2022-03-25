<?php

namespace app\controllers;

use app\models\search\ElectricitySearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\Electricity;
use app\models\Help;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ElectricityController extends Controller
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
                        'actions' => ['index', 'help', 'document', 'create', 'clear-filter', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
     * Page electricity network.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Electricity();
        $searchModel = new ElectricitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'electricity' => $model->getElectricity(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'connection' => $model->getConnection(),
            'management' => $model->getManagement(),
            'applicant' => $model->getApplicant(),
            'status' => $model->getStatus(),
            'controller' => 'electricity',
        ]);
    }

    /**
     * Page create applicant electricity (modal window).
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Electricity();
        $model->status = 100;
        $model->user_last = Yii::$app->user->identity->username;
        $model->user_first = Yii::$app->user->identity->username;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->register()) {
            $url = $this->getCurrentUrl();

            \Yii::$app->session->setFlash('minnesota_message', '    
                <div class="alert alert-success" role="alert">
                    Новая заявка успешно добавлена!
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
                'connection' => $model->getConnection(),
                'management' => $model->getManagement(),
                'applicant' => $model->getApplicant(),
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'connection' => $model->getConnection(),
                'management' => $model->getManagement(),
                'applicant' => $model->getApplicant(),
            ]);
        }
    }

    /**
     * Page helper (modal window).
     * @return mixed
     */
    public function actionHelp()
    {
        $help = new Help();
        if (Yii::$app->request->isAjax){
            return $this->renderAjax('help', [
                'help' => $help,
                'typeConnect' => $help->getTypeConnect(),
            ]);
        } else {
            return $this->render('help', [
                'help' => $help,
                'typeConnect' => $help->getTypeConnect(),
            ]);
        }
    }

    /**
     * Page document information (modal window).
     * @param integer $id
     * @return mixed
     */
    public function actionDocument($id)
    {
        if (Yii::$app->request->isAjax){
            return $this->renderAjax('document', [
                'id' => $id,
            ]);
        } else {
            return $this->render('document', [
                'id' => $id,
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
        if ($session->has('ElectricitySearch')) {
            $session->remove('ElectricitySearch');
        }
        if ($session->has('ElectricitySearchSort')) {
            $session->remove('ElectricitySearchSort');
        }

        return $this->redirect('index');
    }

    /**
     * Displays a single RegistrationForm model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
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
        $session->set('Electricity', Yii::$app->request->referrer);
    }

    /**
     * Getter URI.
     * @return mixed
     */
    public function getCurrentUrl()
    {
        $session = Yii::$app->session;
        if ($session['Electricity'])
            return $session['Electricity'];
        return 'index';
    }

    /**
     * Finds the Electricity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Electricity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Electricity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}