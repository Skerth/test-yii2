<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/** @var yii\web\View $this */
/** @var app\models\Clients $client */
/** @var app\models\ClientsPhones $phones */
/** @var app\models\ClientsContact $contacts */
/** @var yii\widgets\ActiveForm $form */

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .contacts-item .contacts-item--num").each(function(index) {
        jQuery(this).text(index + 1);
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .contacts-item .contacts-item--num").each(function(index) {
        jQuery(this).text(index + 1);
    });
});
';

$this->registerJs($js);
?>


<div class="client-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?=
    $form->field($client, 'name', ['options' => ['class' => 'form-group mb-2']])
        ->textInput(['maxlength' => true]);
    ?>

    <?= $form->field($client, 'note')->textarea(['rows' => 4]); ?>

    <div class="contacts-wrap mt-5">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.contacts-items', // required: css class selector
            'widgetItem' => '.contacts-item', // required: css class
            'limit' => 6, // the maximum times, an element can be cloned (default 999)
            'min' => 0, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $contacts[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'name',
                'phone',
                'email',
            ],
        ]); ?>

        <div class="title row align-items-center">
            <h2 class="h5 col mb-0"><i class="fa fa-address-book-o"></i> Contacts</h2>
            <div class="col-auto">
                <button type="button" class="add-item btn btn-success btn-sm"><i class="fa fa-plus"></i> Add contacts</button>
            </div>
        </div>

        <hr />

        <div class="row contacts-items">
            <?php foreach ($contacts as $i => $contact): ?>
                <div class="col-lg-6 contacts-item">
                    <div class="card item mb-4">
                        <?php
                        // necessary for update action.
                        if (!$contact->isNewRecord) {
                            echo Html::activeHiddenInput($contact, "[{$i}]id");
                        }
                        ?>

                        <div class="card-header">
                            <div class="row align-items-center">
                                <h3 class="h6 col mb-0"><i class="fa fa-address-card-o"></i> Contact card: <span class="contacts-item--num"><?= $i + 1 ?></span></h3>

                                <div class="col-auto">
                                    <button type="button" class="remove-item btn btn-danger btn-sm"><i class="fa fa-minus"></i> Delete</button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <?=
                            $form->field($contact, "[{$i}]name", ['options' => ['class' => 'form-group mb-2']])
                                ->textInput(['maxlength' => true]);
                            ?>

                            <div class="row">
                                <?=
                                $form->field($contact, "[{$i}]phone", ['options' => ['class' => 'form-group col-lg-6']])
                                    ->textInput(['maxlength' => true]);
                                ?>

                                <?=
                                $form->field($contact, "[{$i}]email", ['options' => ['class' => 'form-group col-lg-6']])
                                    ->textInput(['maxlength' => true]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <hr />

        <?php DynamicFormWidget::end(); ?>
    </div>

    <div class="form-group pt-2">
        <?= Html::submitButton($client->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
