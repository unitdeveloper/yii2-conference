<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-lg-5">
    <?php $form = ActiveForm::begin(['id' => 'login-form',]); ?>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2>Вхід</h2>
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
                <div class="form-control-feedback">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i>Увійти</button>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div style="color:#999;margin:1em 0">
                Якщо ви забули свій пароль, ви можете <?= Html::a('змінити його', ['auth/password-reset-request']) ?>.
            </div>
        </div>
    </div>
</div>