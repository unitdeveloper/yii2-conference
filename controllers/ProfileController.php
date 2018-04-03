<?php

namespace app\controllers;

use app\models\Application;
use app\models\search\ApplicationSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;


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
    public function actionApplication($id = null)
    {
        if ($id) {
            $application = Application::findOne($id);
            if (empty($application))
                throw new HttpException(404, 'Такой заявки нет');

            return $this->render('applicationView', compact('application'));
        }

        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->id);
        $dataProvider->pagination->pageSize = $this->defaultPageSize;

        return $this->render('application', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
