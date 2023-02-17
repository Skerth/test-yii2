<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $modelLogin */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
?>
<div class="row justify-content-center">
    <div class="col-lg-6 pt-5">
        <h1>Вход в панель управления</h1>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-form-label'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],

            ],
        ]); ?>

        <?= $form->field($modelLogin, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($modelLogin, 'password')->passwordInput() ?>

        <?= $form->field($modelLogin, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-6 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-11">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
