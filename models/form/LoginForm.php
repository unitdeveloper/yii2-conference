<?php

namespace app\models\form;

use app\models\User;
use codemix\yii2confload\Config;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $reCaptcha;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => Config::env('RECAPTCHA_SECRET_KEY', 'secretKey'), 'uncheckedMessage' => 'Please confirm that you are not a bot.']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логін',
            'password' => 'Пароль',
            'rememberMe' => 'Запам\'ятати мене',
        ];
    }

    /**
     * Validates the username and password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', 'Неправильне ім\'я користувача або пароль.');
            } elseif ($user && $user->status == User::STATUS_BLOCKED) {
                $this->addError('username', 'Ваш аккаунт заблокований.');
            } elseif ($user && $user->status == User::STATUS_WAIT) {
                $this->addError('username', 'Ваш аккаунт не підтверджений.');
            }
        }
    }


    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
