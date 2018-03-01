<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Archive */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="archive-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?php if ($model->pdf_file) : ?>
    <?=$form->field($model, 'pdfFile')->widget(\kartik\file\FileInput::classname(), [
        'options' => ['accept' => 'file/*'],
        'pluginOptions' => [
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false,
            'initialPreview'=>[
                $model->pdf_file ? Html::tag('embed', '',
                    ['class' => "kv-preview-data file-preview-pdf",
                    'src' => "/archive/pdf/" . $model->pdf_file,
                    'type' => "application/pdf",
                    ]) : null
            ],
        ]
    ]);?>
    <?php else : ?>
        <?=$form->field($model, 'pdfFile')->widget(\kartik\file\FileInput::classname(), [
            'options' => ['accept' => 'file/*'],
            'pluginOptions' => [
//            'showPreview' => false,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
            ]
        ]);?>
    <?php endif; ?>


    <?=$form->field($model, 'imageFile')->widget(\kartik\file\FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' =>  'Select Photo',
            'initialPreview'=>[
                $model->image ? Html::img("/archive/" . $model->image, ['height' => '100%']) : null
            ],
        ],
    ]);?>
    <?= $form->field($model, 'active')->checkbox() ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
