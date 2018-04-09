<?php

namespace app\commands;

use app\models\Application;
use app\models\Letter;
use app\models\Material;
use app\modules\admin\controllers\EmailController;
use yii\console\Controller;

class TrackingController extends Controller
{

    /**
     * @return \Exception|int
     */
    public function actionTrack()
    {
        try {
            $email       = $this->email();
            $material    = $this->checkMaterial();
            $letter      = $this->checkLetter();
            $application = $this->checkApplication();

            $message = $email.$material.$letter.$application;
            $this->send($message);

        } catch (\Exception $exception) {
            return $exception;
        }
        return 1;
    }

    /**
     * @return string
     */
    public function checkApplication()
    {
        $countNewApplication = Application::find()->where(['=', 'status', 0])->count();
        $message = "Кількість заявок які очікують модерації ($countNewApplication)".'<br>';
        return $message;
    }

    /**
     * @return string
     */
    public function checkMaterial()
    {
        $countUnpublishedMaterial = Material::find()->where(['=', 'status_publisher', 0])->count();
        $message = "Кількість неопублікованих матеріалів ($countUnpublishedMaterial)".'<br>';
        return $message;
    }

    /**
     * @return string
     */
    public function checkLetter()
    {
        $countNewLetter = Letter::find()->where(['=', 'status', 0])->count();
        $message = "Кількість необроблених листів ($countNewLetter)".'<br>';
        return $message;
    }

    /**
     * @return string
     */
    public function email()
    {
        $email = new EmailController();

        $message = $this->checkEmail($email);

        return $message;
    }

    /**
     * @param $email
     * @return string
     */
    public function checkEmail($email)
    {
        $newEmails = $this->searchEmail($email);
        if ($newEmails) {
            if ($this->readEmail($email, $newEmails)) {
                if ($this->searchEmail($email))
                    return $this->checkEmail($email);
                else
                    return "Нові листи успішно прочитані".'<br>';
            } else
                return "Помилка при зчитуванні листів".'<br>';
        } else
            return 'Не знайдено нових листів'.'<br>';
    }

    /**
     * @param $email EmailController
     * @return mixed
     */
    public function searchEmail($email)
    {
        return $email->searchNewEmails();
    }

    /**
     * @param $email EmailController
     * @param $newEmails
     * @return mixed
     */
    public function readEmail($email, $newEmails)
    {
        return $email->readingEmail($newEmails, false);
    }

    /**
     * @param $message
     */
    public function send($message)
    {
        $sendGrid = \Yii::$app->sendGrid;
        $message = $sendGrid->compose('trackingInfo', ['message' => $message]);
        $message->setFrom([\Yii::$app->config->get('SUPPORT_EMAIL') => \Yii::$app->name])
            ->setTo(\Yii::$app->config->get('ADMIN_EMAIL'))
            ->setSubject('Tracking Info - ' . \Yii::$app->name)
            ->send($sendGrid);
    }

}
