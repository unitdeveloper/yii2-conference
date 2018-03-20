<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\SignupForm */

$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'form-signup', 'class' => "form-horizontal"]); ?>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2>Реєстрація нового користувача</h2>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="name">Ім'я</label>
                <i class="fa fa-user ml-2 mt-2"></i>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'username')->textInput()->label(false) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <!-- Put name validation error messages here -->
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="name">E-Mail адреса</label>
                <i class="fa fa-at ml-2 mt-2"></i>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'email')->textInput()->label(false) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <!-- Put name validation error messages here -->
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="name">Пароль</label>
                <i class="fa fa-key ml-2 mt-2"></i>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <!-- Put name validation error messages here -->
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="name">Підтвердити пароль</label>
                <i class="fa fa-repeat ml-2 mt-2"></i>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'rpPassword')->passwordInput()->label(false) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <!-- Put name validation error messages here -->
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
<!--                <label for="name">Код перевірки</label>-->
<!--                <i class="fa fa-lock ml-2 mt-2"></i>-->
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <?= $form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i>Реєстрація</button>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>