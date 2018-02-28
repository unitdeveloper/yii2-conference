<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/password-reset', 'token' => $user->password_reset_token]);
?>

    Вітаю, <?= Html::encode($user->username) ?>!

    Пройдіть по посиланню, щоб змінити пароль:

<?= Html::a(Html::encode($resetLink), $resetLink) ?>