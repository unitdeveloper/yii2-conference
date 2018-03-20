<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/email-confirm', 'token' => $user->email_confirm_token]);
?>

<body style="margin: 0; padding: 0;">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;border: 1px solid #cccccc;">
    <tr>
        <td bgcolor="#ffffff" style="padding: 20px 30px 20px 30px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="color: #153643; font-family: Arial, sans-serif;">
                        <h3><a style="color: #153643; font-family: Arial, sans-serif;text-decoration: none" href="<?=\yii\helpers\Url::home(true)?>">Актуальні проблеми автоматизації та управліня</a></h3>
                        <small>Міжнародна науково-практична інтернет-коференція молодих учених та студентів</small>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 0 20px 0; color: #153643; font-family: Arial, sans-serif;">
                        <table>
                            <tr>
                                <td style="width: 50%;">
                                    <span style="font-style: italic;">Вітаю, <?= Html::encode($user->username) ?>!</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0px 0 30px 0; color: #153643; font-family: Arial, sans-serif;">
                        <table>
                            <tr>
                                <td>
                                    <span style="font-style: italic;">Для підтвердження адреси пройдіть по посиланню:</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding: 0px 0 25px 0; color: #153643; font-family: Arial, sans-serif;">
                        <table>
                            <tr>
                                <td>
                                    <a href="<?=Html::encode($confirmLink)?>" style="font-family:helvetica neue,helvetica,arial,sans-serif;font-weight:bold;font-size:18px;line-height:22px;color: #fff;text-decoration:none;display:block;text-align:center;max-width:400px;overflow:hidden;text-overflow:ellipsis;padding: 10px 30px;background-color: #348eda;border: solid 1px #348eda;border-radius: 2px;" target="_blank">
                                        Підтвердити ел. адресу
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif;font-size: 14px">
                                    <b>Якщо Ви не реєструвалися на нашому сайті, то просто видаліть цей лист.</b>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor="#F2F2F2" style="padding: 30px 30px 30px 30px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 14px;">
                        &reg; <a style="color: #153643;" href="<?=\yii\helpers\Url::home(true)?>"><?=\yii\helpers\Url::home(true)?></a> 2018<br/>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>