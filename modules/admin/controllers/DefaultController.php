<?php

namespace app\modules\admin\controllers;

use app\models\Application;
use app\models\form\MailingForm;
use app\models\job\MassSendMailJob;
use app\models\Letter;
use app\models\MailTemplate;
use app\models\Material;
use app\models\Participant;
use app\models\User;
use app\modules\admin\Module;
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

        $countUnpublishedMaterial = Material::find()->where(['=', 'status_publisher', 0])->count();
        $countParticipant = Participant::find()->count();
        $countNewApplication = Application::find()->where(['=', 'status', 0])->count();
        $countNewLetter = Letter::find()->where(['=', 'status', 0])->count();

        return $this->render('index',[
            'countNewEmail' => $newEmails ? count($newEmails) : 0,
            'countUnpublishedMaterial' => $countUnpublishedMaterial,
            'countParticipant' => $countParticipant,
            'countNewApplication' => $countNewApplication,
            'countNewLetter' => $countNewLetter,
        ]);
    }


    /**
     * Saving editor files to a $sub directory
     * @param string $sub
     * @return array|\Exception|Exception
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
     * Saving images of the editor to the directory $sub
     * @param string $sub
     * @return array|\Exception|Exception
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

    public function actionMailTemplate($path = null)
    {
        $model = MailTemplate::find()->all();

        $params = \Yii::$app->getRequest()->get();
        unset($params['path']);

        return $this->render('mail-template', [
            'model' => $model,
            'path' => $path,
            'params' => $params,
        ]);
    }

    /**
     * Mailing for a participants conference
     * @return string|Response
     */
    public function actionMailing($id_template = null)
    {
        $model = new MailingForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->send()) {
            return $this->redirect('index');
        }

        $query = Participant::find();
        $template = MailTemplate::findOne($id_template);

        return $this->render('mailing', [
            'model' => $model,
            'participantCount' => $query->count(),
            'template' => $template,
        ]);
    }

}
