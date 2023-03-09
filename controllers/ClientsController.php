<?php

namespace app\controllers;

use Yii;
use app\models\Clients;
use app\models\ClientsSearch;
use app\models\ClientsContact;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\base\Model;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * ClientsController implements the CRUD actions for Clients model.
 */
class ClientsController extends Controller
{
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
     * Lists all Clients models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClientsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 10);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clients model.
     * @param int $id ID
     * @return string
     */
    public function actionView($id)
    {
       $client = Clients::findOne($id);

        return $this->render('view', [
            'model' => $client,
            'contacts' => $client->contacts,
            'tasks' => $client->tasks,
        ]);
    }

    /**
     * Creates a new Clients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $flag = false;
        $modelClient = new Clients;
        $modelContacts = [new ClientsContact];

        if ($modelClient->load(Yii::$app->request->post()))
        {
            $modelContacts = Model::createMultiple(ClientsContact::classname());
            ClientsContact::loadMultiple($modelContacts, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelContacts),
                    ActiveForm::validate($modelClient)
                );
            }

            if ($modelClient->validate() && Model::validateMultiple($modelContacts))
            {
                $transaction = Yii::$app->db->beginTransaction();
                try
                {
                    if ($modelClient->save(false))
                    {
                        foreach ($modelContacts as $contact)
                        {
                            $contact->client_id = $modelClient->id;

                            if (! ($flag = $contact->save(false)))
                            {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        if ($flag)
                        {
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $modelClient->id]);
                        }
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'client' => $modelClient,
            'contacts' => (empty($modelContacts)) ? [new $modelContacts] : $modelContacts,
        ]);
    }

    /**
     * Updates an existing Clients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $flag = false;
        $modelClient = $this->findModel($id);
        $modelContacts = $modelClient->contacts;

        if ($modelClient->load(Yii::$app->request->post()))
        {
            $oldIDs = ArrayHelper::map($modelContacts, 'id', 'id');
            $modelContacts = Model::createMultiple(ClientsContact::className(), $modelContacts);
            ClientsContact::loadMultiple($modelContacts, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelContacts, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelContacts),
                    ActiveForm::validate($modelClient)
                );
            }

            if ($modelClient->validate() && Model::validateMultiple($modelContacts))
            {
                $transaction = Yii::$app->db->beginTransaction();

                try
                {
                    if ($modelClient->save(false))
                    {
                        if (! empty($deletedIDs))
                        {
                            ClientsContact::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelContacts as $contact)
                        {
                            $contact->client_id = $modelClient->id;

                            if (! ($flag = $contact->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelClient->id]);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'client' => $modelClient,
            'contacts' => (empty($modelContacts)) ? [new ClientsContact()] : $modelContacts,
        ]);
    }

    /**
     * Deletes an existing Clients model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Clients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Clients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clients::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
