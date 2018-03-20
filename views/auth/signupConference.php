<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\SignupForm */

$this->title = 'Sign Up Conference';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-lg-5 signup-conference">
<!--    <div class="white_body">-->
        <?php $form = ActiveForm::begin([
            'id' => 'form-signup-conference',
            'class' => "form-horizontal",
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2>Реєстрація на конференцію</h2>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-user mr-2 mt-2"></i>
                <label for="name">Ім'я</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?php if (!Yii::$app->user->isGuest) $model->username = \Yii::$app->user->identity->username ?>
                    <?= $form->field($model, 'username')->textInput()->label(false) ?>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-at  mr-2 mt-2"></i>
                <label for="name">E-Mail адреса</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php if (!Yii::$app->user->isGuest) $model->email = \Yii::$app->user->identity->email ?>
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

        <div class="row mt-2">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-file  mr-2 mt-2"></i>
                <label for="name">Файл заявки</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <div class="col-md-3">
                <div class="form-group">
                    <?=$form->field($model, 'application_file')->fileInput()->label(false);?>
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
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-file  mr-2 mt-2"></i>
                <label for="name">Файл статті</label>
            </div>

        </div>
        <div class="row mb-4">
            <div class="col-md-3 field-label-responsive"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <?=$form->field($model, 'article_file')->fileInput()->label(false);?>
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
<!--    </div>-->
</div>