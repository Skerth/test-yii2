<?php

use app\models\Clients;
use app\models\ClientsTask;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ClientsTaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать задачу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'id',
                'options' => ['width' => '70']
            ],
            [
                'attribute'=>'archive',
                'format' => 'raw',
                'options' => ['width' => '70'],
                'value' => function ($model) {
                    return $model->archive ? '<span class="text-danger">Архив</span>' : '<span class="text-success">Активно</span>';
                },
                'filter' => [0 => 'Активно', 1 => 'В архиве'],
            ],
            [
                'attribute' => 'client_id',
                'format' => 'raw',
                'value' => function ($model) {
                    $client = Clients::find()->where('id = ' . $model->client_id)->one();
                    return Html::a($client->name, Url::toRoute(['clients/view', 'id' => $client->id]));;
                },
                'filter' => ArrayHelper::map(Clients::find()->orderBy('id')->all(), 'id', 'name'),
            ],
            [
                'attribute' => 'service',
                'format' => 'raw',
                'value' => function ($model) {
                    return ClientsTask::servicesArr[$model->service];
                },
                'filter' => ClientsTask::servicesArr,
            ],
            'price',
            [
                'attribute' => 'check_date',
                'value' => function ($model) {
                    return date('d.m.Y', strtotime($model->check_date));
                },
            ],
            //'note:ntext',
            [
                'options' => ['width' => '80'],
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ClientsTask $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
