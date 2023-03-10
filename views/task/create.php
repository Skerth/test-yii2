<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ClientsTask $model */
/** @var array $clients */
/** @var array $services */

$request = Yii::$app->request;
$client_id = $request->get('client_id');

$this->title = 'Добавление задачи';
if (isset($client_id))
    $this->title .= ' для ' . \app\models\Clients::findOne($client_id)->name;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-task-create">
    <div class="card">
        <div class="card-header">
            <h1 class="h3 mb-0"><i class="fa fa-pencil"></i> <?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-body">

            <?= $this->render('_form', [
                'model' => $model,
                'clients' => $clients,
                'services' => $services,
                'client_id' => $client_id,
            ]) ?>
        </div>
    </div>
</div>
