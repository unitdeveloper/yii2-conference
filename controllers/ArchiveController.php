<?php

namespace app\controllers;


use app\models\Archive;
use yii\web\HttpException;

class ArchiveController extends SiteController
{

    /**
     * Lists all Archive models.
     * @return mixed
     */
    public function actionIndex()
    {
        $archive = Archive::find()->active()->all();

        return $this->render('index',[
            'archive' => $archive,
        ]);
    }

    /**
     * Viewing a document PDP
     * @param $id
     * @return $this
     * @throws HttpException
     */
    public function actionViewPdf($id)
    {
        $archive = Archive::find()->where(['=', 'id', $id])->active()->one();
        $filePath = \Yii::getAlias('@webroot').'/archive/pdf/'.$archive->pdf_file;
        if (file_exists($filePath)) {
            $info          = new \SplFileInfo($filePath);
            $fileName = $info->getFilename();
            return \Yii::$app->response->sendFile($filePath, $fileName, ['inline'=>true]);
        }
        throw new HttpException(404, 'Pdf файла не существует');
    }
}
