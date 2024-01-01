<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Purchases $model */

$this->title = 'Update Purchases: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Purchases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchases-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelItems' => $modelItems,
    ]) ?>

</div>
