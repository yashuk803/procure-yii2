<?php

use app\models\Purchases;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Purchases $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Purchases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="purchases-view">

    <p>
        <?php if ($model->status_id == Purchases::STATUS_DRAFT): ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </p>
    <h3>Main Info</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'description:ntext',
            'budget',
            [
                'attribute' => 'status_id',
                'value' => function ($data) {
                    return Purchases::STATUSES[$data->status_id];
                },
            ],
            'user.first_name',
        ],
    ]) ?>

    <h3>Nomenclature</h3>
    <table id="w1" class="table table-striped table-bordered detail-view">
        <tbody>
        <tr>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit</th>
        </tr>

        <?php foreach ($model->items as $item): ?>
            <tr>
                <td><?= $item->description ?></td>
                <td><?= $item->quantity ?></td>
                <td><?= $item->unit ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
