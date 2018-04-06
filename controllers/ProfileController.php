<?php

namespace app\controllers;

use app\models\Application;
use app\models\form\DownloadApplicationFilesForm;
use app\models\Material;
use app\models\search\ApplicationSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;


class ProfileController extends Controller
{

    public $defaultPageSize = 10;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['application'],
                'rules' => [
                    [
                        'actions' => ['application'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param null $id
     * @return string
     * @throws HttpException
     */
    public function actionApplication()
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->id);
        $dataProvider->pagination->pageSize = $this->defaultPageSize;

        return $this->render('application', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionApplicationMaterial($id)
    {
        $model = $this->findApplicationModel($id);
        $form = new DownloadApplicationFilesForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate() && $form->createAttachments($model->id)) {
            return $this->redirect(['application-view', 'id' => $model->id]);
        }

        return $this->render('applicationDownloadMaterial', [
            'model' => $model,
            'applicationForm'  => $form,
        ]);

    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionApplicationDelete($id)
    {
        $model = $this->findApplicationModel($id);

        if ($model->material_id) {

            $material = Material::findOne($model->material_id);
            $material->delete();
        }
        $model->delete();

        return $this->redirect(['application']);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionApplicationView($id)
    {
        return $this->render('applicationView', [
            'model' => $this->findApplicationModel($id),
        ]);
    }

    /**
     * @param $id
     * @return Application
     * @throws NotFoundHttpException
     */
    protected function findApplicationModel($id)
    {
        if (($model = Application::findOne($id)) !== null)
            if ($model->user_id = Yii::$app->user->identity->getId())
                return $model;

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
