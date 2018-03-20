<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\form\ContactForm */

?>

<body style="margin: 0; padding: 0;">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;border: 1px solid #cccccc;">
    <tr>
        <td align="" bgcolor="#70BBD9" style="padding: 30px  30px ;color: #fff;font-family: Arial, sans-serif; ">
            <h3 style="color: #fff;">
                Актуальні проблеми автоматизації та управліня
            </h3>
            <small>
                Міжнародна науково-практична інтернет-коференція молодих учених та студентів
            </small>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                        <b>Feedback</b>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif;">
                        <table>
                            <tr>
                                <td style="width: 50%;">
                                    <span style="font-style: italic;">Ім'я:</span>
                                    <b><?= Html::encode($model->name)?></b>
                                </td>
                                <td style="width: 50%;">
                                    <span style="font-style: italic;">Email:</span>
                                    <b><?= Html::encode($model->email)?></b>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">
                                    <span style="font-style: italic;">Прізвище:</span>
                                    <b><?= Html::encode($model->secondName)?></b>
                                </td>
                                <td style="width: 50%;">
                                    <?php if ($model->phone) :?>
                                        <span style="font-style: italic;">Телефон:</span>
                                        <b><?= Html::encode($model->phone)?></b>
                                    <?php endif;?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-family: Arial, sans-serif;color: #153643;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <span style="font-style: italic;">Повідомлення:</span>
                            </tr>
                            <tr>
                                <p><?= $model->message?></p>
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
