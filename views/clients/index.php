<?php

use app\models\Clients;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ClientsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">
    <div class="row">
        <h1 class="col h3 mb-0"><?= Html::encode($this->title) ?></h1>

        <div class="col-auto btn-group btn-group-sm">
            <?= Html::a('<i class="fa fa-plus"></i> Добавить клиента', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'name',
                'format' => 'html',
                'value' => function ($model) {
                    $activeTasks = $model->activeTasks;
                    $val = Html::a($model->name, Url::toRoute(['clients/view', 'id' => $model->id]));
                    if (!empty($activeTasks))
                    {
                        $val .= '<div>' . Html::tag('small', 'Активных задач: ' . count($activeTasks), ['class' => 'text-secondary']) . '</div>';
                    }
                    return $val;
                },
            ],
            [
                'attribute' => 'note',
                'filter' => false,
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Clients $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
</div>
