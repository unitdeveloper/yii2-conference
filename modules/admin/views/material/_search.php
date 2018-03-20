<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\MaterialSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="material-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

<!--    --><?//= $form->field($model, 'category_id') ?>
<!---->
<!--    --><?//= $form->field($model, 'created_at') ?>
<!---->
<!--    --><?//= $form->field($model, 'updated_at') ?>
<!---->
<!--    --><?//= $form->field($model, 'publisher_at') ?>

    <?php // echo $form->field($model, 'udk') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'university') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'material_name') ?>

    <?php // echo $form->field($model, 'ru_annotation') ?>

    <?php // echo $form->field($model, 'ua_annotation') ?>

    <?php // echo $form->field($model, 'us_annotation') ?>

    <?php // echo $form->field($model, 'ru_tag') ?>

    <?php // echo $form->field($model, 'ua_tag') ?>

    <?php // echo $form->field($model, 'us_tag') ?>

    <?php // echo $form->field($model, 'status_publisher') ?>

    <?php // echo $form->field($model, 'word_file') ?>

    <?php // echo $form->field($model, 'pdf_file') ?>

    <?php // echo $form->field($model, 'html_file') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
