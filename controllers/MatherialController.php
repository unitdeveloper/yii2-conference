<?php

namespace app\controllers;

use app\models\Conference;
use app\models\Material;
use app\models\form\SearchForm;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\web\HttpException;

class MatherialController extends SiteController
{

    /**
     * Lists all active Material models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Material::find()->active()->with(['category']);
        $query = clone $query;
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'defaultPageSize' => 6,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
        $matherial = $query->orderBy('id DESC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        //Set meta
        $conferences = Conference::find()->all();
        return $this->render('index', compact('matherial', 'pages', 'conferences'));
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
        if (empty($matherial) || !$matherial->status_publisher)
            throw new HttpException(404, 'Такого материала нет');

        return $this->render('view', compact('matherial'));
    }

    /**
     * Search material by parameters
     * @param bool $parameters
     * @return string|\yii\web\Response
     */
    public function actionSearch($parameters = false)
    {
        $model = new SearchForm();

        if ($model->load(\Yii::$app->request->get())) {
            $q = trim($model->q);
        } else {
            return $this->redirect(['index']);
        }

        if (!$q) {
            $q = Html::encode($parameters);

            if (!$q)
                return $this->render('search');
        }

        //Set meta
        $query = Material::searchByQuery($q);

        $pages = new Pagination([
            'totalCount' => $query->count(),
            'defaultPageSize' => 6,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
        $matherial = $query->orderBy('id DESC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->active()
            ->with(['category'])
            ->all();
        return $this->render('search', compact('matherial', 'pages', 'q'));
    }

    /**
     * Filtering materials by category
     * @param $id
     * @return string
     */
    public function actionCategory($id)
    {
        $query = Material::find()->active()->with(['category']);
        $query = clone $query;
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'defaultPageSize' => 6,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
        $matherial = $query->orderBy('id DESC')
            ->forCategory($id)
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        //Set meta
        $conferences = Conference::find()->all();
        return $this->render('index', compact('matherial', 'pages', 'conferences'));
    }

    /**
     * Filtering materials by conference
     * @param $id
     * @return string
     */
    public function actionConference($id)
    {
        $query = Material::find()->active()->with(['category']);
        $query = clone $query;
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'defaultPageSize' => 6,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
        $matherial = $query->orderBy('id DESC')
            ->forConference($id)
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        //Set meta
        $conferences = Conference::find()->all();
        return $this->render('index', compact('matherial', 'pages', 'conferences'));
    }

    /**
     * @param $id
     * @return $this
     * @throws HttpException
     */
    public function actionViewPdf($id)
    {
        $material = Material::find()->where(['=', 'id', $id])->active()->one();
        $filePath = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$material->dir.$material->pdf_file;
        if (file_exists($filePath)) {
            $info          = new \SplFileInfo($filePath);
            $fileName = $info->getFilename();
            return \Yii::$app->response->sendFile($filePath, $fileName, ['inline'=>true]);
        }
        throw new HttpException(404, 'Pdf файла не существует');
    }
}
