<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\ResetPasswordForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<main id="content" role="main" class="span12">
    <!-- Begin Content -->

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="remind">

        <?php $form = ActiveForm::begin(['id' => 'request-password-form']); ?>
        <fieldset>
            <p>Виберіть новий пароль:</p>
            <div class="control-group">
                <div class="controls">
                    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
                </div>
            </div>
        </fieldset>
        <div class="control-group">
            <div class="controls">
                <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!-- End Content -->
</main>
