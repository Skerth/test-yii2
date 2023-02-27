<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Clients $client */
/** @var app\models\ClientsPhones $phones */

$this->title = 'Update Clients: ' . $client->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $client->name, 'url' => ['view', 'id' => $client->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'client' => $client,
        'phones' => $phones,
    ]) ?>

</div>
