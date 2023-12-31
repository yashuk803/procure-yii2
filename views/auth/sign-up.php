<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <a href="/auth/login" class="float-right btn btn-outline-primary mt-1">Log in</a>
                <h4 class="card-title mt-2">Sign up</h4>
            </div>
            <div class="card-body">
                <?php
                $form = ActiveForm::begin(
                    [
                        'id' => 'user-form',
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => true,
                        'validationUrl' => \yii\helpers\Url::to(['/auth/validate-form', 'path' => 'app\services\auth', 'modelName' =>  'SignupForm'])
                    ]
                ); ?>
                <div class="form-row">
                    <div class="col form-group">
                        <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'First name']) ?>
                    </div>
                    <div class="col form-group">
                        <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Last name']) ?>
                    </div>
                </div>
                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email', 'type' => 'email']) ?>
                <?= $form->field($model, 'password')->textInput(['placeholder' => 'Password', 'type' => 'password']) ?>
                <div class="form-group">
                    <?= Html::submitButton('Register', ['class' => 'btn btn-primary btn-block']); ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
