<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Fragment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fragment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'imageUpload' => \yii\helpers\Url::to(['/admin/default/save-redactor-img', 'sub' => 'fragment']),
            'fileUpload' => \yii\helpers\Url::to(['/admin/default/save-redactor-file', 'sub' => 'fragment']),
            'plugins' => [
                'clips',
                'fullscreen',
                'imagemanager',
                'filemanager',
            ],
        ],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
