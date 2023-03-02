<?php

use app\models\Clients;
use app\models\ClientsTask;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ClientsTask $model */

$this->title = 'Задача №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <h1 class="col h3 mb-0">
                    <i class="fa fa-id-card-o"></i>
                    <?= Html::encode($this->title) ?>
                    <?= $model->archive ? '(Архив)' : false; ?>
                </h1>

                <div class="col-auto btn-group btn-group-sm">
                    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'client_id',
                        'format' => 'html',
                        'value' => function ($model) {
                            $client = Clients::find()->where('id = ' . $model->client_id)->one();
                            return Html::a($client->name, Url::toRoute(['clients/view', 'id' => $client->id]));
                        },
                    ],
                    [
                        'attribute' => 'service',
                        'format' => 'html',
                        'value' => function ($model) {
                            return ClientsTask::servicesArr[$model->service];
                        },
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
                ],
            ]) ?>

            <?= Html::tag('p', $model->note); ?>
        </div>
    </div>

</div>
