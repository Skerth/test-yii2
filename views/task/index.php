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

    <div class="row">
        <h1 class="col h3 mb-0"><?= Html::encode($this->title) ?></h1>

        <div class="col-auto btn-group btn-group-sm">
            <?= Html::a('<i class="fa fa-plus"></i> Добавить задачу', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'grid-view mt-3'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'id',
                'options' => ['width' => '70']
            ],
            [
                'attribute'=>'archive',
                'format' => 'html',
                'options' => ['width' => '70'],
                'value' => function ($model) {
                    return $model->archive ? '<span class="text-danger">Архив</span>' : '<span class="text-success">Активно</span>';
                },
                'filter' => [0 => 'Активно', 1 => 'В архиве'],
            ],
            [
                'attribute' => 'client_id',
                'format' => 'html',
                'value' => function ($model) {
                    $client = Clients::find()->where('id = ' . $model->client_id)->one();
                    return Html::a($client->name, Url::toRoute(['clients/view', 'id' => $client->id]));
                },
                'filter' => ArrayHelper::map(Clients::find()->orderBy('id')->all(), 'id', 'name'),
            ],
            [
                'attribute' => 'service',
                'format' => 'html',
                'value' => function ($model) {
                    return ClientsTask::servicesArr[$model->service];
                },
                'filter' => ClientsTask::servicesArr,
            ],
            [
                'attribute' => 'price',
                'value' => function ($model) {
                    return number_format($model->price, 2, '.', ' ') . ' ₽';
                },
            ],
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
