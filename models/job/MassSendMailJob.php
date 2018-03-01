<?php

namespace app\models\job;


use yii\base\BaseObject;
use yii\queue\JobInterface;

class MassSendMailJob extends BaseObject implements JobInterface
{
    public $participant;
    public $mailingData;

    /**
     * Mailing for a participants conference
     * @param \yii\queue\Queue $queue
     * @return bool
     */
    public function execute($queue)
    {
        foreach ($this->participant as $model) {

            if($model->email) {

                try {

                    \Yii::$app->mailer->compose('@app/mail/mailing', ['mailingData' => $this->mailingData])
                        ->setFrom([\Yii::$app->config->get('SUPPORT_EMAIL') => \Yii::$app->name])
                        ->setTo($model->email)
                        ->setSubject($this->mailingData->subject)
                        ->send();
                } catch (\Exception $exception) {
                    //1
                }

            }

        }

        return true;
    }
}
