<?php

namespace app\models\form;

use app\models\User;
use codemix\yii2confload\Config;
use yii\base\Model;
use Yii;

/**
* Signup form
*/
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rpPassword;
    public $verifyCode;
    public $reCaptcha;

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => '{attribute} вже зайнятий.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => '{attribute} вже зайнятий.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['rpPassword', 'required'],
            ['rpPassword', 'string', 'min' => 6],
            ['rpPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Паролі не співпадають'],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => Config::env('RECAPTCHA_SECRET_KEY', 'secretKey'), 'uncheckedMessage' => 'Please confirm that you are not a bot.']
//            ['verifyCode', 'captcha', 'captchaAction' => '/site/captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логін',
            'password' => 'Пароль',
            'rpPassword' => 'Підтвердити пароль',
            'verifyCode' => 'Код перевірки',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->status = User::STATUS_WAIT;
            $user->generateAuthKey();
            $user->generateEmailConfirmToken();

            if ($user->save()) {
//                Yii::$app->mailer->compose('@app/mail/emailConfirm', ['user' => $user])
//                    ->setFrom([Yii::$app->config->get('SUPPORT_EMAIL') => Yii::$app->name])
//                    ->setTo($this->email)
//                    ->setSubject('Підтвердження електронної пошти для ' . Yii::$app->name)
//                    ->send();

                $sendGrid = \Yii::$app->sendGrid;
                $message = $sendGrid->compose('emailConfirm', ['user' => $user]);
                $message->setFrom([\Yii::$app->config->get('SUPPORT_EMAIL') => \Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject('Підтвердження електронної пошти для ' . Yii::$app->name)
                    ->send($sendGrid);
                    return $user;
                }
            }

        return null;
    }
}
