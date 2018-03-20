<?php

namespace app\models\form;

use borales\extensions\phoneInput\PhoneInputValidator;
use codemix\yii2confload\Config;
use yii\base\Model;

/**
 * Contact form
 */
class ContactForm extends Model
{
    public $name;
    public $secondName;
    public $email;
    public $message;
    public $phone;
    public $verifyCode;
    public $reCaptcha;

    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['secondName', 'filter', 'filter' => 'trim'],
            ['secondName', 'required'],
            ['secondName', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],

            ['message', 'filter', 'filter' => 'trim'],
            ['message', 'required'],
            ['message', 'string', 'min' => 2, 'max' => 5000],

            [['phone'], 'string'],
            [['phone'], PhoneInputValidator::className()],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => Config::env('RECAPTCHA_SECRET_KEY', 'secretKey'), 'uncheckedMessage' => 'Please confirm that you are not a bot.']
//            ['verifyCode', 'captcha', 'captchaAction' => '/site/captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Ім\'я *',
            'secondName' => 'Прізвище *',
            'email' => 'Email *',
            'phone' => 'Телефон',
            'message' => 'Повідомлення *',
//            'verifyCode' => 'Код перевірки *',
        ];
    }

    /**
     * @return bool|\Exception|null
     * @var \SendGrid $message
     */
    public function send()
    {
        if ($this->validate()) {

            try {
//                \Yii::$app->mailer->compose('@app/mail/feedback', ['model' => $this])
//                    ->setFrom([\Yii::$app->config->get('SUPPORT_EMAIL') => \Yii::$app->name])
//                    ->setTo(\Yii::$app->config->get('ADMIN_EMAIL'))
//                    ->setSubject("Feedback - ".\Yii::$app->name)
//                    ->send();
                $sendGrid = \Yii::$app->sendGrid;
                $message = $sendGrid->compose('feedback', ['model' => $this]);
                $message->setFrom([\Yii::$app->config->get('SUPPORT_EMAIL') => \Yii::$app->name])
                    ->setTo(\Yii::$app->config->get('ADMIN_EMAIL'))
                    ->setSubject("Feedback - ".\Yii::$app->name)
                    ->send($sendGrid);
            } catch (\Exception $exception) {
                return $exception;
            }
            return true;
        }

        return null;
    }

}
