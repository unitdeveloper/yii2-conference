<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\form\ContactForm */

$this->title = 'Contact';
?>

<div class="col-md-8 mt-5">
    <?php $form = ActiveForm::begin(['id' => 'form-contact', 'method' => 'post']); ?>

        <div class="row">
            <div class="col-md-12">
                <h2>Зв'яжіться з нами</h2>
                <hr>
            </div>
        </div>

        <div class="messages"></div>

        <div class="controls">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php if (!Yii::$app->user->isGuest) $model->name = \Yii::$app->user->identity->username ?>
                        <?= $form->field($model, 'name') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'secondName') ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php if (!Yii::$app->user->isGuest) $model->email = \Yii::$app->user->identity->email ?>
                        <?= $form->field($model, 'email') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_name">Телефон</label>
                        <?= $form->field($model, 'phone')->widget(\borales\extensions\phoneInput\PhoneInput::className(), [
                            'jsOptions' => [
                                'preferredCountries' => ['ua', 'ru'],
                                'nationalMode' => false,
                            ],
                            'options' => [
                                    'class' => 'form-control'
                            ],
                            'name' => 'Телефон',
                        ])->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <?= $form->field($model, 'message')->widget(\vova07\imperavi\Widget::className(), [
                            'settings' => [
                                'lang' => 'ru',
                                'minHeight' => 150,
                            ],
                        ]);?>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>
                </div>
                <div class="col-md-12">
                    <input type="submit" class="btn btn-outline-dark btn-send" value="Надіслати повідомлення">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p class="text-muted"><strong>*</strong> Ці поля обов'язкові для заповнення.</p>
                </div>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
<div class="col-md-4 mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Контакти</h2>
            <hr>
        </div>
    </div>
    <div class="row p-3">
        <div class="col-md-12">
            <h3>Адреса</h3>
            <p>Луцький НТУ, кафедра АУВП, вул. Потебні, 56, м. Луцьк, 43018, Україна</p>
        </div>
        <div class="col-md-12">
            <h3>Телефон</h3>
            <p>(0332) 26-14-09</p>
        </div>
        <div class="col-md-12">
            <h4>Email</h4>
            <p>auvp@lntu.edu.ua</p>
        </div>
    </div>
</div>
