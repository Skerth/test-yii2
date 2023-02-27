<?php

namespace app\controllers;

use Yii;
use app\models\Clients;
use app\models\ClientsSearch;
use app\models\ClientsPhones;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\base\Model;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

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
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clients model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
       $client = Clients::findOne($id);

        return $this->render('view', [
            'model' => $client,
            'phones' => $client->phones
        ]);
    }

    /**
     * Creates a new Clients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $client = new Clients;
        $phones = [new ClientsPhones];
        Yii::info("Приступаем к созданию клиента");

        if ($client->load(Yii::$app->request->post()))
        {
            $phones = Model::createMultiple(ClientsPhones::classname());
            ClientsPhones::loadMultiple($phones, Yii::$app->request->post());

            Yii::info("Количество телефонов: " . count($phones));

            // ajax validation
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($phones),
                    ActiveForm::validate($client)
                );
            }

            // validate all models
            $valid = $client->validate();
            $valid = Model::validateMultiple($phones) && $valid;
            $flag = false;

            if ($valid)
            {
                $transaction = Yii::$app->db->beginTransaction();

                try
                {
                    if ($client->save(false))
                    {
                        Yii::info("Клиент сохранен");

                        foreach ($phones as $phone)
                        {
                            $phone->client_id = $client->id;
                            Yii::info("Сохраняю телефон: " . $phone->phone);

                            if (! ($flag = $phone->save(false)))
                            {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        if ($flag)
                        {
                            Yii::info("Транзакция выполнена");
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $client->id]);
                        }
                    }
                } catch (\Exception $e) {
                    Yii::info("Исключение: " . $e);
                    $transaction->rollBack();
                }
            }
        }

        Yii::info("Вывод формы создания");
        return $this->render('create', [
            'client' => $client,
            'phones' => (empty($phones)) ? [new ClientsPhones] : $phones,
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
        /*
        $model = Clients::findOne($id);
        //$phones = ClientsPhones::find()->where(['client_id' => $id])->all();
        $phones = $model->phones;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()
            && Model::loadMultiple($phones, Yii::$app->request->post()) && Model::validateMultiple($phones)) {

            foreach ($phones as $phone) {
                $phone->save(false);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        */

        $client = $this->findModel($id);
        $phones = $client->phones;

        if ($client->load(Yii::$app->request->post()))
        {
            $oldIDs = ArrayHelper::map($phones, 'id', 'id');
            Yii::info("Старые ID: " . json_encode($oldIDs));
            $phones = Model::createMultiple(ClientsPhones::className(), $phones);
            ClientsPhones::loadMultiple($phones, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($phones, 'id', 'id')));
            Yii::info("Удаленные ID: " . json_encode($deletedIDs));

            // ajax validation
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($phones),
                    ActiveForm::validate($client)
                );
            }

            // validate all models
            $valid = $client->validate();
            $valid = Model::validateMultiple($phones) && $valid;
            $flag = false;

            Yii::info("Валидация: " . $valid);

            if ($valid)
            {
                $transaction = Yii::$app->db->beginTransaction();
                Yii::info("Начало транзакции");

                try
                {
                    if ($client->save(false))
                    {
                        if (! empty($deletedIDs))
                        {
                            ClientsPhones::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($phones as $phone)
                        {
                            $phone->client_id = $client->id;
                            Yii::info("Сохраняю телефон: " . $phone->phone);

                            if (! ($flag = $phone->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        Yii::info("Начало транзакции");
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $client->id]);
                    }
                } catch (\Exception $e) {
                    Yii::info("Исключение: " . $e);
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'client' => $client,
            'phones' => (empty($phones)) ? [new ClientsPhones] : $phones,
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
