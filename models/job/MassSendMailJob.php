<?php

namespace app\models\job;


use yii\base\BaseObject;
use yii\queue\JobInterface;

class MassSendMailJob extends BaseObject implements JobInterface
{
    public $participant;
    public $mailingData;

    public function execute($queue)
    {
        foreach ($this->participant as $model) {

            \Yii::$app->mailer->compose('@app/mail/mailing', ['mailingData' => $this->mailingData])
                ->setFrom([\Yii::$app->config->get('SUPPORT_EMAIL') => \Yii::$app->name])
                ->setTo($model->email)
                ->setSubject($this->mailingData->subject)
                ->send();
        }

        return true;
    }
}
