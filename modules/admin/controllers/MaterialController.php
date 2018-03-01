<?php

namespace app\modules\admin\controllers;

use app\modules\admin\Module;
use Yii;
use app\models\Material;
use app\models\search\MaterialSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MaterialController implements the CRUD actions for Material model.
 */
class MaterialController extends Controller
{
    public $pathToAttachments;

    /**
     * MaterialController constructor.
     * @param $id
     * @param Module $module
     * @param array $config
     */
    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->pathToAttachments = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'];

    }

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
     * Lists all Material models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaterialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Material model.
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
     * Creates a new Material model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Material();

        if ($model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Material model.
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
     * Conversion word file in pdf and html
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionConversion($id)
    {
        $model = $this->findModel($id);

        $pathToWordFile = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$model->dir.$model->word_file;

        if (!ParsingController::checkExistWordFile($model, $pathToWordFile))
            return $this->redirect(['view', 'id' => $model->id]);

        if (!ParsingController::checkNeedleFile($model, $pathToWordFile))
            return $this->redirect(['view', 'id' => $model->id]);

        Yii::$app->getSession()->setFlash('success', 'Файлы конвертированы');
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Saving parsing data
     * @param $model Material
     * @param $parsData
     * @return bool
     */
    public function saveData($model, $parsData)
    {
        try {

            if (!empty($parsData)) {
                foreach ($parsData as $key => $value) {

                    if (!empty($value))
                        $model->$key = $value;
                    else
                        $model->$key = null;
                }

            }
            $model->updated_at = date('Y-m-d');
            $model->save();
        } catch (\Exception $exception) {

            Yii::$app->getSession()->setFlash('error', "Ошибка сохранение данных $exception");
            return false;
        }

        Yii::$app->getSession()->setFlash('success', 'Данные получены и сохранены');
        return true;
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionParsing($id)
    {
        $model = $this->findModel($id);
        $result = ParsingController::parsing($model);

        if (!$result)
            return $this->redirect(['view', 'id' => $model->id]);

        $this->saveData($model, $result);

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * * Deletes an existing Material model.
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
     * Finds the Material model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Material the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Material::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     * @return $this
     * @throws HttpException
     */
    public function actionViewPdf($id)
    {
        $material = Material::find()->where(['=', 'id', $id])->one();
        $filePath = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$material->dir.$material->pdf_file;
        if (file_exists($filePath)) {
            $info          = new \SplFileInfo($filePath);
            $fileName = $info->getFilename();
            return \Yii::$app->response->sendFile($filePath, $fileName, ['inline'=>true]);
        }
        throw new HttpException(404, 'Pdf файла не существует');
    }

    /**
     * @param $resource
     * @return $this
     * @throws NotFoundHttpException
     */
    public function actionDownload($resource)
    {
        if (file_exists($resource))
            return Yii::$app->response->sendFile($resource);
        throw new NotFoundHttpException("Файл $resource не найден");
    }
}
