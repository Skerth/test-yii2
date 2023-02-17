<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $modelLogin */
/** @var app\models\TestForm $modelFormTest */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\VarDumper;

Yii::$app->formatter->locale = 'ru-RU';
$this->title = 'Изучение фреймворка Yii2';
?>
<div class="site-index">
    <?php if (Yii::$app->user->isGuest): ?>
        <?php
        echo Yii::$app->view->renderFile(
            '@app/views/forms/login.php',
            ['modelLogin' => $modelLogin]);
        ?>
    <?php else: ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="border bg-light mb-3 p-3">
           <?php VarDumper::dump($modelFormTest,  10, true); ?>
        </div>
        <p>Привет: <?php print Yii::$app->user->identity->username; ?></p>
        <p>Время на сервере: <?php print date('d.m.Y G:i'); ?></p>
        <p>Время на сервере Unixtime: <?php print date('U'); ?></p>
        <p><a href="<?php print Yii::$app->getUrlManager()->createUrl(['country/index']); ?>">Страны</a></p>
    <?php if (isset($modelFormTest->date)): ?>
        <p>
            <label>Введенная дата:</label>
            <?= \Yii::$app->formatter->asDate(Html::encode($modelFormTest->date), 'long'); ?>
        </p>
    <?php else: ?>
        <p>Тут появится введеная дата.</p>
    <?php endif; ?>
        <?php
        echo Yii::$app->view->renderFile(
            '@app/views/forms/test-form.php',
            ['modelFormTest' => $modelFormTest]);
        ?>
    <?php endif; ?>
</div>
