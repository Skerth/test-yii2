<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\VarDumper;

/** @var yii\web\View $this */
/** @var app\models\Clients $model */
/** @var app\models\ClientsPhones $phones */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="clients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?php // VarDumper::dump($phones,  10, true); ?>
    <?php
        foreach ($phones as $index => $phone)
        {
            echo $form->field($phone, "[$index]phone")->label('Phone');
        }
    ?>

    <div class="form-group pt-4">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
