<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\form\MailingForm */
/* @var $form yii\widgets\ActiveForm */
/* @var integer $participantCount*/
/* @var \app\models\MailTemplate $template*/
?>


<h3>Лист буде надіслано <?=$participantCount?> учанику(ам) конференцій</h3>
<br>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<?= Html::a('Select template', ['mail-template', 'path' => '/default/mailing'], ['class' => 'btn btn-primary']) ?>
<hr>
<div class="archive-form">

    <?php $form = ActiveForm::begin([]); ?>

    <?= $form->field($model, 'subject')->input('string', ['value' => $template ? $template->subject : ''])?>

    <?php $model->body = $template ? $template->body : ''?>

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
        <?= Html::a('Reset', ['mailing'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
