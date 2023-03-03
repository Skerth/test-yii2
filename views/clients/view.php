<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

//use yii\helpers\VarDumper;

/** @var yii\web\View $this */
/** @var app\models\Clients $model */
/** @var app\models\ClientsContact $contacts */
/** @var app\models\ClientsTask $tasks */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="client-view">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <h1 class="col h3 mb-0"><i class="fa fa-id-card-o"></i> <?= Html::encode($this->title) ?></h1>

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
                    'id',
                    'name',
                    'note:ntext',
                ],
            ]) ?>

            <div class="contacts-wrap mt-5">
                <div class="title">
                    <h2 class="h5 mb-0"><i class="fa fa-address-book-o"></i> Контакты</h2>
                </div>

                <hr />

                <div class="row contacts-items">
                    <?php foreach ($contacts as $i => $contact): ?>
                        <div class="col-lg-4 contacts-item">
                            <div class="card item mb-4">
                                <div class="card-header">
                                    <h3 class="h6 mb-0"><i class="fa fa-address-card-o"></i> Карточка контакта: <span class="contacts-item--num"><?= $i + 1 ?></span></h3>
                                </div>

                                <div class="card-body">
                                    <?= DetailView::widget([
                                        'model' => $contact,
                                        'attributes' => [
                                            'name',
                                            'phone',
                                            'email:email',
                                        ],
                                        'options' =>
                                            [
                                                'class' => 'table table-striped table-bordered detail-view',
                                            ]
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (!isset($contacts[0]->phone)): ?>
                <div class="contacts-items--empty col-12 text-secondary">
                    Контакты отсутствуют
                </div>
                <?php endif; ?>
            </div>

            <div class="tasks-wrap mt-4">
                <div class="title">
                    <div class="row">
                        <h2 class="h5 col mb-0"><i class="fa fa-tasks"></i> Задачи</h2>
                        <div class="col-auto">
                            <?= Html::a('<i class="fa fa-plus"></i> Добавить задачу', ['task/create', 'client_id' => $model->id], ['class' => 'btn btn-success btn-sm']) ?>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row tasks-items">
                    <?php foreach ($tasks as $i => $task): ?>
                        <div class="col-lg-6 contacts-item<?= $task->archive ? ' opacity-75' : false; ?>">
                            <div class="card item mb-4">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <h3 class="h6 mb-0 col">
                                            <i class="fa fa-bullseye"></i>
                                            <?= Html::a('Задача №' . $task->id, ['task/view', 'id' => $task->id]) ?>
                                            <?= $task->archive ? '(Архив)' : false; ?>
                                        </h3>
                                        <div class="col-auto">
                                            <?= Html::a('<i class="fa fa-pencil"></i> Редактировать',
                                                ['task/update', 'id' => $task->id], ['class' => 'btn btn-secondary btn-sm']) ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <?= DetailView::widget([
                                        'model' => $task,
                                        'attributes' => [
                                            [
                                                'attribute' => 'service',
                                                'value' => function ($model) {
                                                    return \app\models\ClientsTask::servicesArr[$model->service];
                                                }
                                            ],
                                            [
                                                'attribute' => 'price',
                                                'value' => function ($model) {
                                                    return number_format($model->price, 2, '.', ' ') . ' ₽';
                                                },
                                            ],
                                            'check_date:date',
                                        ],
                                        'options' =>
                                            [
                                                'class' => 'table table-striped table-bordered detail-view',
                                            ]
                                    ]) ?>

                                    <?= $task->note; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
