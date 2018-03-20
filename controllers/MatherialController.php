<?php

namespace app\controllers;

use app\models\Conference;
use app\models\Material;
use app\models\form\SearchForm;
use app\models\search\MaterialFrontSearch;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\HttpException;

class MatherialController extends SiteController
{

    public $defaultPageSize = 2;

    /**
     * Lists all active Material models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaterialFrontSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $this->defaultPageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single active Material model.
     * @param $id
     * @return string
     * @throws HttpException
     */
    public function actionView($id)
    {
        $matherial = Material::find()->where(['=', 'id', $id])->active()->one();
        if (empty($matherial))
            throw new HttpException(404, 'Такого материала нет');

        return $this->render('view', compact('matherial'));
    }

    /**
     * Search material by parameters
     * @param bool $parameters
     * @return string|\yii\web\Response
     */
    public function actionSearch()
    {
        $model = new SearchForm();
        if (!$model->load(\Yii::$app->request->get()) && $model->validate())
            return $this->redirect(['index']);

        $searchModel = new MaterialFrontSearch();
        $dataProvider = $searchModel->search(null, $model);
        $dataProvider->pagination->pageSize = $this->defaultPageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return \yii\console\Response|\yii\web\Response
     * @throws HttpException
     */
    public function actionViewPdf($id)
    {
        $material = Material::find()->where(['=', 'id', $id])->active()->one();
        if (!$material)
            throw new HttpException(404, 'Pdf файла не существует');
        $filePath = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$material->dir.$material->pdf_file;
        if (file_exists($filePath)) {
            $info          = new \SplFileInfo($filePath);
            $fileName = $info->getFilename();
            return \Yii::$app->response->sendFile($filePath, $fileName, ['inline'=>true]);
        }
        throw new HttpException(404, 'Pdf файла не существует');
    }
}
