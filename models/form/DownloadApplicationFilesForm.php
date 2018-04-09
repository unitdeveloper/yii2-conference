<?php

namespace app\models\form;

use app\models\Application;
use app\models\Category;
use app\models\Conference;
use app\models\Letter;
use app\models\Material;
use app\models\Participant;
use codemix\yii2confload\Config;
use yii\base\Model;
use yii\db\StaleObjectException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class DownloadApplicationFilesForm extends Model
{
    public $reCaptcha;
    public $article_file;
    public $application_file;
    public $category_id;

    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id'], 'exist', 'skipOnError' => false, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],

            [['article_file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['doc','docx']],

            [['application_file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['doc','docx']],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => Config::env('RECAPTCHA_SECRET_KEY', 'secretKey'), 'uncheckedMessage' => 'Please confirm that you are not a bot.']
        ];
    }

    public function attributeLabels()
    {
        return [
            'category_id' => 'Category',
        ];
    }

    public function beforeValidate()
    {
        $this->article_file = UploadedFile::getInstance($this, 'article_file');
        $this->application_file = UploadedFile::getInstance($this, 'application_file');

        return parent::beforeValidate();
    }

    public function createAttachments($application_id)
    {
        $application = Application::findOne($application_id);

        $participant = Participant::find()->where(['email' => $application->email])->one();

        if (!$participant || !$application)
            return false;

        if (!$material = $this->createMaterial($participant, $application))
            return false;

        $application->material_id = $material->id;
        $application->category_id = $this->category_id;

        if (!$application->save(false)) {

            try {
                $material->delete();
            } catch (StaleObjectException $e) {} catch (\Exception $e) {}

            \Yii::$app->session->setFlash('error', 'Не вдалося завантажити файли');
            return false;
        }

        if (!$this->downloadAttachments($material))
            return false;

        \Yii::$app->session->setFlash('success', 'Матеріали успішно завантажені');
        return true;
    }

    /**
     * @param $participant
     * @param $application
     * @return Material|bool
     */
    public function createMaterial($participant, $application)
    {
        /** @var Letter $letter */
        /** @var Conference $conference */
        $conference = Conference::active();
        $letter = Letter::find()->where(['email' => $application->email])->andWhere(['not', ['material_id' => null]])->andWhere(['conference_id' => $conference->id])->one();
        if ($letter && $letter->material_id)
            return $letter->material;

        $material = new Material();
        $material->participant_id = $participant->id;
        $material->conference_id = $application->conference_id;
        $material->category_id = $this->category_id;

        if ($material->save()) {
            return $material;
        }

        \Yii::$app->session->setFlash('error', 'Не вдалося завантажити файли');
        return false;
    }

    /**
     * @param $material Material
     * @return bool
     */
    public function downloadAttachments($material)
    {
        $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$material->dir;

        $dir = $dir . date('Y-m-d H:i:s') . '/';

        if (!file_exists($dir)) {
            try {
                FileHelper::createDirectory($dir);
            } catch (\Exception $exception) {
                \Yii::$app->session->setFlash('error', 'Не вдалося завантажити файли');
                return false;
            }
        }

        try {
            /** @var UploadedFile $article_file */
            /** @var UploadedFile $application_file */
            if ($article_file = $this->article_file)
                $article_file->saveAs($dir . $article_file->name);

            if ($application_file = $this->application_file)
                $application_file->saveAs($dir . $application_file->name);

        } catch (\Exception $exception) {
            \Yii::$app->session->setFlash('error', 'Не вдалося завантажити файли');
            return false;
        }

        return true;
    }
}
