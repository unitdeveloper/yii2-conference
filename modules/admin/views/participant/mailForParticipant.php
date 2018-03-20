<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\form\MailForParticipantForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $participant \app\models\Participant */
/* @var $template \app\models\MailTemplate */
?>
<h3>Лист буде надіслано за адресою <?= $participant->email ?></h3>
<br>
<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<?= Html::a('Select template', ['/admin/default/mail-template', 'path' => '/participant/send-email', 'id' => $participant->id], ['class' => 'btn btn-primary']) ?>
<div class="archive-form">

    <?php $form = ActiveForm::begin([]); ?>

    <?= $form->field($model, 'subject')->input('string', ['value' => $template ? $template->subject : ''])?>

    <?php $model->body = $template ? $template->body : ''?>

    <?= $form->field($model, 'body')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]);?>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
