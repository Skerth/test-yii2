<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $modelLogin */
/** @var app\models\TestForm $modelFormTest */

use yii\bootstrap5\Html;
use yii\helpers\Url;

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
        <p>Привет: <?= Yii::$app->user->identity->username; ?></p>
        <p>Email: <?= Yii::$app->params['adminEmail']; ?></p>
        <p>Время на сервере: <?= date('d.m.Y G:i'); ?></p>
        <p>Время на сервере Unixtime: <?= date('U'); ?></p>
        <p><?= Html::a('Клиенты', Url::toRoute(['clients/index'])); ?></p>
        <p><?= Html::a('Задачи', Url::toRoute(['task/index'])); ?></p>

    <?php if (isset($modelFormTest->date)): ?>
        <p>
            <label>Введенная дата:</label>
            <?= Yii::$app->formatter->asDate(Html::encode($modelFormTest->date), 'long'); ?>
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
