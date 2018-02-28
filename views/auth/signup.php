<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\SignupForm */

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<main id="content" role="main" class="span12">
    <!-- Begin Content -->

    <div class="remind">

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <fieldset>
            <p>Будь-ласка, заповніть наступні поля для реєстрації:</p>
            <div class="control-group">
                <div class="controls">
                    <?= $form->field($model, 'username') ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '{image}<div class="col-lg-6">{input}</div>',
                    ]) ?>
                </div>
            </div>
            <div style="color:#999;margin:1em 0">
                Якщо ви забули свій пароль, ви можете <?= Html::a('змінити його', ['auth/password-reset-request']) ?>.
            </div>
        </fieldset>
        <div class="control-group">
            <div class="controls">
                <?= Html::submitButton('Реєстрація', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!-- End Content -->
</main>
