<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

/** @var \app\services\auth\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';

?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <a href="/auth/sign-up" class="float-right btn btn-outline-primary mt-1">Register</a>
                <h4 class="card-title mt-2">Log In</h4>
            </div>
            <div class="card-body">
                <?php
                $form = ActiveForm::begin(
                    [
                        'id' => 'login-form',
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => true,
                        'validationUrl' => \yii\helpers\Url::to(['/auth/validate-form', 'path' => 'app\services\auth', 'modelName' => 'LoginForm'])
                    ]
                ); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
