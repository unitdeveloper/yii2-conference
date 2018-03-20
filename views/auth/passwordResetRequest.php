<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\PasswordResetRequestForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-lg-5">
    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form',]); ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2>Будь ласка, заповніть свою електронну пошту.</h2>
            <hr>
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
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary"><i class="fa fa-envelope mr-2"></i>Відправити</button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>