<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ClientsTaskSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="clients-task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'archive') ?>

    <?= $form->field($model, 'client_id') ?>

    <?= $form->field($model, 'service') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'check_date') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
