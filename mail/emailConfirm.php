<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/email-confirm', 'token' => $user->email_confirm_token]);
?>

Вітаю, <?= Html::encode($user->username) ?>!

Для підтвердження адреси пройдіть по посиланню:

<?= Html::a(Html::encode($confirmLink), $confirmLink) ?>

Якщо Ви не реєструвалися у на нашому сайті, то просто видаліть цей лист.