<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

//use yii\helpers\VarDumper;

/** @var yii\web\View $this */
/** @var app\models\Clients $model */
/** @var app\models\ClientsContact $contacts */

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
                                    <!--
                                    <?php /*if (isset($contact->name)): */?>
                                        <div class="client-name mb-2">
                                            <?/*= Html::tag('b', Html::encode($contact->name)); */?>
                                        </div>
                                    <?php /*endif; */?>

                                    <?php /*if (isset($contact->phone)): */?>
                                        <div class="client-phone mb-2">
                                            Телефон: <?/*= Html::encode($contact->phone); */?>
                                        </div>
                                    <?php /*endif; */?>

                                    <?php /*if (isset($contact->email)): */?>
                                        <div class="client-email">
                                            Email:
                                            <?/*= Html::tag('a', Html::encode($contact->email),
                                                    [
                                                        'class' => 'client-email',
                                                        'href' => 'mailto:' . Html::encode($contact->email)
                                                    ]
                                            ); */?>
                                        </div>
                                    <?php /*endif; */?>
                                    -->
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
        </div>
    </div>
</div>
