<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Config */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'param')->textInput(['maxlength' => true]) ?>

    <?php if (!$model->type || $model->type == 'string'): ?>
        <?= $form->field($model, 'value')->textInput(['maxlength' => true, 'placeholder'=>$model->default]) ?>
    <?php elseif ($model->type == 'text'): ?>
        <?= $form->field($model, 'value')->textarea(['maxlength' => true, 'placeholder'=>$model->default]) ?>
    <?php elseif ($model->type == 'checkbox'): ?>
        <?= $form->field($model, 'value')->checkbox(); ?>
    <?php elseif ($model->type == 'array'): ?>
        <?= $form->field($model, 'value')->textarea(['rows' => 2, 'placeholder'=>$model->default, 'value' =>$model->getValueToStr()]); ?>
    <?php endif; ?>

    <?= $form->field($model, 'default')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
