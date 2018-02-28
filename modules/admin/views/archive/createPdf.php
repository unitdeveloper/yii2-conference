<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = 'Create pdf';
$this->params['breadcrumbs'][] = ['label' => 'Archives', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create pdf';

?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<div class="archive-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([]); ?>

    <?= $form->field($model, 'conference_id')->dropDownList(\app\models\Conference::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
