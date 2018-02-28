<?php

namespace app\controllers;

use app\models\Conference;
use app\models\Material;
use app\models\SearchForm;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\web\HttpException;

class MatherialController extends SiteController
{

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

    public function actionView($id)
    {
        $matherial = Material::find()->where(['=', 'id', $id])->active()->one();
        if (empty($matherial) || !$matherial->status_publisher)
            throw new HttpException(404, 'Такого материала нет');

        return $this->render('view', compact('matherial'));
    }

    public function actionSearch($q = false)
    {
        if (!$q) {

            $q = \Yii::$app->request->get('SearchForm');
            $q = trim($q['q']);
        }

        $q = Html::encode($q);
        //Set meta
        if (!$q) return $this->render('search');
        $query = Material::find()
            ->where(['like', 'udk', $q])
            ->orWhere(['like', 'author', $q])
            ->orWhere(['like', 'university', $q])
            ->orWhere(['like', 'email', $q])
            ->orWhere(['like', 'material_name', $q])
            ->orWhere(['like', 'ru_annotation', $q])
            ->orWhere(['like', 'ua_annotation', $q])
            ->orWhere(['like', 'us_annotation', $q])
            ->orWhere(['like', 'ru_tag', $q])
            ->orWhere(['like', 'ua_tag', $q])
            ->orWhere(['like', 'us_tag', $q]);
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
