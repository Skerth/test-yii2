<?php

use app\models\Clients;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ClientsTask $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $clients */
/** @var array $services */
/** @var integer $client_id */

$paramsDropDownList = [
    'prompt' => 'Выберите клиента',
];

if (isset($client_id)) {
    $paramsDropDownList = array_merge($paramsDropDownList, [
        'options' => [
            $client_id => [
                    'Selected' => true,
            ]
        ]
    ]);
}
?>

<div class="client-task-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-6">
        <?=
        $form->field($model, 'client_id')->dropDownList($clients, $paramsDropDownList);
        ?>
        <div class="row pt-3 pb-3">
            <?=
            $form->field($model, 'service', ['options' => ['class' => 'form-group col-lg-6']])
                ->dropDownList($services, ['prompt' => 'Выберите услугу']);
            ?>

            <?= $form->field($model, 'price', [
                'options' => ['class' => 'form-group col-lg-6'],
                'template' => '{label}<div class="input-group">{input}<span class="input-group-text" id="basic-addon">₽</span></div>'
            ])->textInput() ?>
        </div>
        <?= $form->field($model, 'check_date')->textInput(['type' => 'date']) ?>
        </div>
        <div class="col-lg-6">
        <?= $form->field($model, 'note')->textarea(['rows' => 7]) ?>
        </div>
    </div>

    <?= $form->field($model, 'archive', ['options' => ['class' => 'form-group mt-4 mb-2']])->checkbox() ?>

    <div class="form-group pt-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
