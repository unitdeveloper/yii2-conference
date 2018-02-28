<?php

namespace app\modules\admin\controllers;

use app\models\form\MailingForm;
use app\models\job\MassSendMailJob;
use app\models\Material;
use app\models\Participant;
use app\models\User;
use yii\base\DynamicModel;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $email     = new EmailController();
        $newEmails = $email->searchNewEmails();
        !$newEmails ? $newEmails = null : $newEmails;

        $users = User::find()->where(['=', 'status', 1])->all();

        $countUnpublishedMaterial = Material::find()->where(['=', 'status_publisher', 0])->all();
        $countParticipant = Participant::find()->all();

        return $this->render('index',[
            'countNewEmail' => count($newEmails),
            'countUsers' => count($users),
            'countUnpublishedMaterial' => count($countUnpublishedMaterial),
            'countParticipant' => count($countParticipant),
        ]);
    }

    /**
     * @param string $sub
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionSaveRedactorFile($sub='main')
    {
        $this->enableCsrfValidation = false;

        if (\Yii::$app->request->isPost) {

            $dir = \Yii::getAlias('@webroot').'/resources/'.$sub.'/';
            if (!file_exists($dir)) {

                try {
                    FileHelper::createDirectory($dir);
                } catch (Exception $exception) {
                    return $exception;
                }
            }
            $result_link = '/resources/'.$sub.'/';

            $file = UploadedFile::getInstanceByName('file');
            $model = new DynamicModel(compact('file'));
            $model->addRule('file', 'file')->validate();

            if ($model->hasErrors()) {

                $result = [
                    'error' => $model->getFirstError('file')
                ];
            } else {

                try {
                    $model->file->name = strtotime('now').'_'.\Yii::$app->getSecurity()->generateRandomString(6).'.'.$model->file->extension;
                } catch (Exception $exception) {
                    return $exception;
                }

                if ($model->file->saveAs($dir.$model->file->name)) {

                    $result = ['filelink' => $result_link.$model->file->name, 'filename' => $model->file->name];
                } else {

                    $result = [
                        'error' => \Yii::t('vova07/imperavi', 'ERROR_CAN_NOT_UPLOAD_FILE')
                    ];
                }
            }

            \Yii::$app->response->format = Response::FORMAT_JSON;

            return $result;
        } else {

            throw new BadRequestHttpException('Only POST as allowed');
        }
    }

    /**
     * @param string $sub
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionSaveRedactorImg($sub='main')
    {
        $this->enableCsrfValidation = false;

        if (\Yii::$app->request->isPost) {

            $dir = \Yii::getAlias('@webroot').'/img/'.$sub.'/';
            if (!file_exists($dir)) {

                try {
                    FileHelper::createDirectory($dir);
                } catch (Exception $exception) {
                    return $exception;
                }
            }
            $result_link = '/img/'.$sub.'/';

            $file = UploadedFile::getInstanceByName('file');
            $model = new DynamicModel(compact('file'));
            $model->addRule('file', 'image')->validate();

            if ($model->hasErrors()) {

                $result = [
                    'error' => $model->getFirstError('file')
                ];
            } else {

                try {
                    $model->file->name = strtotime('now').'_'.\Yii::$app->getSecurity()->generateRandomString(6).'.'.$model->file->extension;
                } catch (Exception $exception) {
                    return $exception;
                }

                if ($model->file->saveAs($dir.$model->file->name)) {

//                    $imag = \Yii::$app->image->load($dir.$model->file->name);
//                    $imag->resize(800, NULL, Image::PRECISE)->save($dir.$model->file->name, 85);

                    $result = ['filelink' => $result_link.$model->file->name, 'filename' => $model->file->name];
                } else {

                    $result = [
                        'error' => \Yii::t('vova07/imperavi', 'ERROR_CAN_NOT_UPLOAD_FILE')
                    ];
                }
            }

            \Yii::$app->response->format = Response::FORMAT_JSON;

            return $result;
        } else {

            throw new BadRequestHttpException('Only POST as allowed');
        }
    }


    /**
     * @return Response
     * @throws \HttpException
     */
    public function actionReaderEmail()
    {
        $email = new EmailController();

        if (!$newEmails = $email->searchNewEmails())
            \Yii::$app->getSession()->setFlash('error', 'Не знайдено нових листів');
        elseif($email->readingEmail($newEmails))
            \Yii::$app->getSession()->setFlash('success', 'Листи успішно прочитані');

        return $this->redirect(['index']);
    }

    public function actionMailing()
    {
        $model = new MailingForm();

        if ($model->load(\Yii::$app->request->post())) {

            $participant = Participant::find()->all();
            if (count($participant) == 0) {

                \Yii::$app->getSession()->setFlash('success', 'Не знайдено учасників конфренції');
                return $this->redirect('index');
            }
            if(\Yii::$app->queue->push(new MassSendMailJob([
                'mailingData' => $model,
                'participant' => $participant,
            ]))) {
                \Yii::$app->getSession()->setFlash('success', 'Почалася розсилка листів');
            } else {

                \Yii::$app->getSession()->setFlash('error', 'Не вдалося розіслати листи');
            }

            return $this->redirect('index');
        } else {
            return $this->render('mailing', [
                'model' => $model,
            ]);
        }
    }

}
