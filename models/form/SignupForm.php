<?php

namespace app\models\form;

use app\models\User;
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
    public $verifyCode;

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

            ['verifyCode', 'captcha', 'captchaAction' => '/site/captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логін',
            'password' => 'Пароль',
            'verifyCode' => 'Код перевірки',
        ];
    }

    /**
    * Signs user up.
    *
    * @return User|null the saved model or null if saving fails
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
                Yii::$app->mailer->compose('@app/mail/emailConfirm', ['user' => $user])
                    ->setFrom([Yii::$app->config->get('SUPPORT_EMAIL') => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject('Підтвердження електронної пошти для ' . Yii::$app->name)
                    ->send();
                    return $user;
                }
            }

        return null;
    }
}
