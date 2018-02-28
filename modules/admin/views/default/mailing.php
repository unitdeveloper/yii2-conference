<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Archive */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="archive-form">

    <?php $form = ActiveForm::begin([]); ?>

    <?= $form->field($model, 'subject')->input('string')?>

    <?= $form->field($model, 'body')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
//            'imageUpload' => \yii\helpers\Url::to(['/admin/default/save-redactor-img', 'sub' => 'mailing']),
//            'fileUpload' => \yii\helpers\Url::to(['/admin/default/save-redactor-file', 'sub' => 'mailing']),
            'plugins' => [
                'clips',
                'fullscreen',
//                'imagemanager',
//                'filemanager',
            ],
        ],
    ]);?>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
