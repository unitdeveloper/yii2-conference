<?php

namespace app\models\form;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => 'app\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Немає користувача з цією адресою електронної пошти.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     * @throws \yii\base\Exception
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);
        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
//        return Yii::$app->mailer->compose('@app/mail/passwordReset', ['user' => $user])
//            ->setFrom([Yii::$app->config->get('SUPPORT_EMAIL') => Yii::$app->name . ' robot'])
//            ->setTo($this->email)
//            ->setSubject('Скидання пароля для ' . Yii::$app->name)
//            ->send();
        try {
            $sendGrid = \Yii::$app->sendGrid;
            $message = $sendGrid->compose('passwordReset', ['user' => $user]);
            $message->setFrom([Yii::$app->config->get('SUPPORT_EMAIL') => Yii::$app->name . ' robot'])
                ->setTo($this->email)
                ->setSubject('Скидання пароля для ' . Yii::$app->name)
                ->send($sendGrid);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }
}