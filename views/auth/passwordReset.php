<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\ResetPasswordForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-lg-5">
    <?php $form = ActiveForm::begin(['id' => 'request-password-form',]); ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2>Введіть новий пароль:</h2>
            <hr>
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
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary"><i class="fa fa-key mr-2"></i>Зберегти</button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>