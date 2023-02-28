<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
#use yii\helpers\VarDumper;

/** @var yii\web\View $this */
/** @var app\models\Clients $model */
/** @var app\models\ClientsContact $contacts */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clients-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // VarDumper::dump($phones,  10, true); ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'note:ntext',
        ],
    ]) ?>

    <?php
        foreach ($contacts as $contact) {
            echo Html::tag('p', Html::encode($contact->name), ['class' => 'client-name']);
            echo Html::tag('p', Html::encode($contact->phone), ['class' => 'client-phone']);
            echo Html::tag('p', Html::encode($contact->email), ['class' => 'client-email']);
            echo Html::tag('hr');
        }
    ?>


</div>
