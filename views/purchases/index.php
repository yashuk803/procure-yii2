<?php

use app\models\Purchases;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PurchasesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Purchases';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchases-index">

    <p>
        <?= Html::a('Create Purchases', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            'description:ntext',
            'budget',
            [
                'attribute' => 'status_id',
                'format' => 'html',
                'content' => function ($data) {
                    return Purchases::STATUSES[$data->status_id];
                },
            ],
            [
                'attribute' => 'user_id',
                'label' => 'User Name',
                'format' => 'html',
                'content' => function ($data) {
                    return $data->user->first_name;
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Purchases $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                        return false;
                    },
                    'update' => function ($model, $key, $index) {
                        return $model->status_id == Purchases::STATUS_DRAFT;
                    },
                ],
            ],
        ],
    ]); ?>
</div>
