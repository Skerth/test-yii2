<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Clients $client */
/** @var app\models\ClientsContact $contacts */

$this->title = 'Create client';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-create">
    <div class="card">
        <div class="card-header">
            <h1 class="h3 mb-0"><i class="fa fa-pencil"></i> <?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card-body">
            <?= $this->render('_form', [
                'client' => $client,
                'contacts' => $contacts,
            ]) ?>
        </div>
    </div>
</div>
