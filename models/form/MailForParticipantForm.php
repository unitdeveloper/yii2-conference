<?php

namespace app\models\form;


use app\models\Participant;
use yii\base\Model;

class MailForParticipantForm extends Model
{
    public $body;
    public $subject;

    public function rules()
    {
        return [
            [['body', 'subject'], 'string'],
            [['body', 'subject'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'body' => 'Body message',
            'subject' => 'Subject',
        ];
    }

    public function send($id)
    {
        $participant = Participant::find()->where(['=', 'id', $id])->one();

        if (!$participant) {
            \Yii::$app->getSession()->setFlash('error', 'Не знайдено учасника конфренції.');
            return false;
        }

        if (!$participant->email) {
            \Yii::$app->getSession()->setFlash('error', 'Не вказано email адреси учасника конференції '.$participant->name);
            return false;
        }
        try {

//            \Yii::$app->mailer->compose('@app/mail/mailForParticipant', ['mailingData' => $this])
//                ->setFrom([\Yii::$app->config->get('SUPPORT_EMAIL') => \Yii::$app->name])
//                ->setTo($participant->email)
//                ->setSubject($this->subject)
//                ->send();
            $sendGrid = \Yii::$app->sendGrid;
            $message = $sendGrid->compose('mailForParticipant', ['mailingData' => $this]);
            $message->setFrom([\Yii::$app->config->get('SUPPORT_EMAIL') => \Yii::$app->name])
                ->setTo($participant->email)
                ->setSubject($this->subject)
                ->send($sendGrid);
        } catch (\Exception $exception) {
            \Yii::$app->getSession()->setFlash('error', 'Не вдалося відправити листа.');
            return false;
        }
        \Yii::$app->getSession()->setFlash('success', 'Лист відправлено.');
        return true;
    }

}