<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\TestForm $modelFormTest */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<?php $form = ActiveForm::begin([
    'id' => 'form-test',
    'options' => [
        'class' => 'col-lg-6 p-3 rounded bg-secondary'
    ],
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'labelOptions' => ['class' => 'form-label text-white'],
        'inputOptions' => ['class' => 'form-control'],
        'errorOptions' => ['class' => 'invalid-feedback'],

    ],
]); ?>
<h2 class="text-white">Форма отправки даты</h2>
<?=
$form->field($modelFormTest, 'date')->textInput([
        'type' => 'date',
]);
?>
<div class="form-group">
    <div class="pt-2">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-warning']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
