<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Archive;
use app\models\search\ArchiveSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArchiveController implements the CRUD actions for Archive model.
 */
class ArchiveController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Archive models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArchiveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $pdfFiles = FileHelper::findFiles(\Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].'/archive/');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pdfFiles' => $pdfFiles,
        ]);
    }

    /**
     * Displays a single Archive model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Archive model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Archive();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Archive model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Archive model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Archive model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Archive the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Archive::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionViewPdf($id)
    {
        $archive = Archive::find()->where(['=', 'id', $id])->one();
        $filePath = \Yii::getAlias('@webroot').'/archive/pdf/'.$archive->pdf_file;
        if (file_exists($filePath)) {
            $info          = new \SplFileInfo($filePath);
            $fileName = $info->getFilename();
            return \Yii::$app->response->sendFile($filePath, $fileName, ['inline'=>true]);
        }
        throw new HttpException(404, 'Pdf файла не существует');
    }

    public function actionCreatePdf()
    {
        $model = new \app\models\form\CreatePdfForm();

        if ($model->load(\Yii::$app->request->post())) {

            if (Archive::createPdf($model))
                return $this->redirect(['index']);

        }
        return $this->render('createPdf', [
            'model' => $model,
        ]);
    }

    public function actionRemove($resource)
    {
        if (!file_exists($resource)) {

            \Yii::$app->getSession()->setFlash('error', "Pdf файл $resource не знайдено");
            return $this->redirect(['index']);
        }

        if (unlink($resource))
            \Yii::$app->getSession()->setFlash('success', "Файл $resource успішно видалено");

        return $this->redirect(['index']);
    }
}
