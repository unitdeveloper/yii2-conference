<?php

namespace app\models\form;


use app\models\job\MassSendMailJob;
use app\models\Participant;
use yii\base\Model;

class MailingForm extends Model
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

    public function send()
    {
        $participant = Participant::find()->all();
        if (count($participant) == 0) {

            \Yii::$app->getSession()->setFlash('success', 'Не знайдено учасників конфренції');
            return false;
        }
        if(\Yii::$app->queue->push(new MassSendMailJob([
            'mailingData' => $this,
            'participant' => $participant,
        ]))) {
            \Yii::$app->getSession()->setFlash('success', 'Почалася розсилка листів');
            return true;
        } else {

            \Yii::$app->getSession()->setFlash('error', 'Не вдалося розіслати листи');
            return false;
        }
    }

}