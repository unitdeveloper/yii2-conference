<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<main id="content" role="main" class="span12">
    <!-- Begin Content -->

    <div class="remind">

            <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => [
//                        'class' => 'form-validate form-horizontal well'
                    ],
            ]); ?>
            <fieldset>
                <div class="control-group">
                    <div class="controls">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true,]) ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    </div>
                </div>
                <div style="color:#999;margin:1em 0">
                    Якщо ви забули свій пароль, ви можете <?= Html::a('змінити його', ['auth/password-reset-request']) ?>.
                </div>
            </fieldset>
            <div class="control-group">
                <div class="controls">
                    <?= Html::submitButton('Ввійти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    <?= Html::a('Реєстрація', ['auth/signup'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!-- End Content -->
</main>