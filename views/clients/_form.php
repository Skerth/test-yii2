<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/** @var yii\web\View $this */
/** @var app\models\Clients $client */
/** @var app\models\ClientsPhones $phones */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="clients-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($client, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($client, 'note')->textarea(['rows' => 5]) ?>

    <?php //VarDumper::dump($phones,  10, true); ?>
    <?php
        /*foreach ($phones as $index => $phone)
        {
            echo $form->field($phone, "[$index]phone")->label('Phone');
        }*/
    ?>
    <div class="phone-items mt-4">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 4, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $phones[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'phone',
            ],
        ]); ?>
        <div class="title row">
            <h5 class="col"><i class="fa fa-phone"></i> Phones</h5>
            <div class="col-auto">
                <button type="button" class="add-item btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
            </div>
        </div>

        <div class="container-items">
            <?php foreach ($phones as $i => $phone): ?>
                <div class="item card"><!-- widgetBody -->
                    <div class="card-header">
                        <div class="row">
                            <h5 class="col">Phone</h5>
                            <div class="col-auto">
                                <button type="button" class="remove-item btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        // necessary for update action.
                        if (! $phone->isNewRecord)
                        {
                            echo Html::activeHiddenInput($phone, "[{$i}]id");
                        }
                        ?>
                        <?= $form->field($phone, "[{$i}]phone")->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php DynamicFormWidget::end(); ?>
    </div>

    <div class="form-group pt-4">
        <?= Html::submitButton($client->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
