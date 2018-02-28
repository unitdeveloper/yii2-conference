<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\PasswordResetRequestForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<main id="content" role="main" class="span12">
    <!-- Begin Content -->

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="remind">

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
        <fieldset>
            <p>Будь ласка, заповніть свою електронну пошту.</p>
            <div class="control-group">
                <div class="controls">
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                </div>
            </div>
        </fieldset>
        <div class="control-group">
            <div class="controls">
                <?= Html::submitButton('Відправити', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!-- End Content -->
</main>
