<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MailTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mail-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
//            'imageUpload' => \yii\helpers\Url::to(['/admin/default/save-redactor-img', 'sub' => 'fragment']),
//            'fileUpload' => \yii\helpers\Url::to(['/admin/default/save-redactor-file', 'sub' => 'fragment']),
            'plugins' => [
                'clips',
                'fullscreen',
//                'imagemanager',
//                'filemanager',
            ],
        ],
    ]);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
