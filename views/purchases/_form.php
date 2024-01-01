<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Purchases $model */
/** @var yii\bootstrap4\ActiveForm $form */

?>
<?php $form = ActiveForm::begin([
        'id' => 'purchases-form'
    ]); ?>
<div class="purchases-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mt-2">Main Info</h4>
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'maxlength' => true]) ?>

                    <?= $form->field($model, 'budget')->input('number', ['maxlength' => true, 'min' => 0]) ?>

                    <?= $form->field($model, 'status_id')->dropDownList(\app\models\Purchases::STATUSES) ?>
                </div>
            </div>
        </div>
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mt-2">Nomenclature</h4>
                </div>
                <div class="card-body">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper',
                        'widgetBody' => '.container-items',
                        'widgetItem' => '.items',
                        'limit' => 10,
                        'min' => 1,
                        'insertButton' => '.add-item',
                        'deleteButton' => '.remove-item',
                        'model' => $modelItems[0],
                        'formId' => 'purchases-form',
                        'formFields' => [
                            'description',
                            'quantity',
                            'unit',
                        ],
                    ]); ?>
                    <div class="container-items">
                        <?php foreach ($modelItems as $i => $item): ?>
                            <div class="items row">
                                <div class="form-group col-md-5">
                                    <?= $form->field($item, "[{$i}]description")->textarea(['rows' => 1, 'maxlength' => true]) ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <?= $form->field($item, "[{$i}]quantity")->input('number', ['maxlength' => true, 'min' => 0]) ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <?= $form->field($item, "[{$i}]unit")->dropDownList(\app\models\Items::UNITS) ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label" for="items-unit">Del</label>
                                    <div><i class="bi bi-trash remove-item"></i></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="btn btn-light btn-block add-item">Add</div>
                        </div>
                        <div class="col-md-11"></div>
                    </div>
                    <?php DynamicFormWidget::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-5">
    <div class="col-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
