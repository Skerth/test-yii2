<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Clients $client */
/** @var app\models\ClientsPhones $phones */

$this->title = 'Create Clients';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'client' => $client,
        'phones' => $phones,
    ]) ?>

</div>
