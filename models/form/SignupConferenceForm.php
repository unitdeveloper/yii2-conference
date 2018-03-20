<?php

namespace app\models\form;

use app\models\Application;
use app\models\Material;
use app\models\Participant;
use codemix\yii2confload\Config;
use yii\base\Model;
use yii\db\Exception;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class SignupConferenceForm extends Model
{
    public $username;
    public $email;
    public $reCaptcha;
    public $article_file;
    public $application_file;

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],

            [['article_file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['doc','docx']],

            [['application_file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['doc','docx']],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => Config::env('RECAPTCHA_SECRET_KEY', 'secretKey'), 'uncheckedMessage' => 'Please confirm that you are not a bot.']
        ];
    }

    public function beforeValidate()
    {
        $this->article_file = UploadedFile::getInstance($this, 'article_file');
        $this->application_file = UploadedFile::getInstance($this, 'application_file');

        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логін',
        ];
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function signupConferense()
    {
        if ($this->validate()) {

            $participant = Participant::find()->where(['=', 'email', $this->email])->one();
            if (!$participant)
                if (!$participant = $this->createParticipant())
                    return false;


            if ($material = $this->createMaterial($participant)) {

                if (!$this->createAttachments($material))
                    return false;

                if (!$this->createApplication($participant, $material))
                    return false;

                \Yii::$app->session->setFlash('success', 'Заявка успішно відправлена');
                return true;
            }

            \Yii::$app->session->setFlash('error', 'Не вдалося відправити заявку');
            return false;
        }

        return null;
    }

    /**
     * @param $participant
     * @param $material
     * @return bool
     */
    public function createApplication($participant, $material)
    {
        $application = new Application();
        $application->participant_id = $participant->id;
        $application->material_id    = $material->id;

        if ($application->save())
            return true;

        \Yii::$app->session->setFlash('error', 'Не вдалося відправити заявку');
        return false;
    }

    /**
     * @param $participant
     * @return Material|bool
     */
    public function createMaterial($participant)
    {
        $material = new Material();
        $material->participant_id = $participant->id;

        if ($material->save()) {
            return $material;
        }

        \Yii::$app->session->setFlash('error', 'Не вдалося відправити заявку');
        return false;
    }

    /**
     * @return Participant|bool
     */
    public function createParticipant()
    {
        $participant = new Participant();
        $participant->name = $this->username;
        $participant->email = $this->email;

        if ($participant->save())
            return $participant;

        \Yii::$app->session->setFlash('error', 'Не вдалося відправити заявку');
        return false;
    }

    /**
     * @param $material
     * @return bool
     */
    public function createAttachments($material)
    {
        $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$material->dir;

        try {
            if ($article_file = $this->article_file) {

                $article_file->saveAs($dir . $article_file->name);
            }

            if ($application_file = $this->application_file) {

                $application_file->saveAs($dir . $application_file->name);
            }

        } catch (Exception $exception) {
            \Yii::$app->session->setFlash('error', 'Не вдалося відправити заявку');
            return false;
        }

        return true;
    }
}
