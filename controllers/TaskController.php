<?php

namespace app\controllers;

use app\models\Clients;
use app\models\ClientsTask;
use app\models\ClientsTaskSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for ClientsTask model.
 */
class TaskController extends Controller
{
    private array $servicesArr = [0 => 'Хостинг', 1 => 'Техническая поддержка'];

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
            ]
        );
    }

    /**
     * Lists all ClientsTask models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClientsTaskSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientsTask model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ClientsTask model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $modelClientsTask = new ClientsTask;
        $modelClientsTask->check_date = date('Y-m-d');

        if ($this->request->isPost) {
            if ($modelClientsTask->load($this->request->post()) && $modelClientsTask->save()) {
                return $this->redirect(['view', 'id' => $modelClientsTask->id]);
            }
        } else {
            $modelClientsTask->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $modelClientsTask,
            'clients' => $this->getClientsArray(),
            'services' => $this->servicesArr,
        ]);
    }

    /**
     * Updates an existing ClientsTask model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelClientsTask = $this->findModel($id);
        $modelClientsTask->check_date = date('Y-m-d', strtotime($modelClientsTask->check_date));

        if ($this->request->isPost && $modelClientsTask->load($this->request->post()) && $modelClientsTask->save()) {
            return $this->redirect(['view', 'id' => $modelClientsTask->id]);
        }

        return $this->render('update', [
            'model' => $modelClientsTask,
            'clients' => $this->getClientsArray(),
            'services' => $this->servicesArr,
        ]);
    }

    /**
     * Deletes an existing ClientsTask model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ClientsTask model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ClientsTask the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientsTask::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function getClientsArray()
    {
        $modelClients = Clients::find()->orderBy('id')->all();
        return ArrayHelper::map($modelClients, 'id', 'name');
    }
}
