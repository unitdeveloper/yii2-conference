<?php

namespace app\controllers;

use app\models\Archive;
use app\models\EmailConfirmForm;
use app\models\Fragment;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;


class SiteController extends Controller
{
//    public $layout = 'rightSidebar';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@yiister/gentelella/views/error',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $fragment = Fragment::find()->where(['=','name','About_the_conference'])->one();
        return $this->render('index',[
            'fragment' => $fragment,
        ]);
    }

    /**
     * Displays requirements fragment.
     * @return string
     */
    public function actionRequirements()
    {
        $requirementsFragment = Fragment::find()->where(['=','name','Requirements_for_registration'])->one();

        $copyrightFragment = Fragment::find()->where(['=','name','Copyright'])->one();

        return $this->render('requirements',[
            'requirementsFragment' => $requirementsFragment,
            'copyrightFragment' => $copyrightFragment,
        ]);
    }

    /**
     * Displays organizers fragment.
     * @return string
     */
    public function actionOrganizers()
    {
        $fragment = Fragment::find()->where(['=','name','Organizers'])->one();

        return $this->render('organizers',[
            'fragment' => $fragment,
        ]);
    }

    /**
     * Displays output data fragment.
     * @return string
     */
    public function actionOutputData()
    {
        $fragment = Fragment::find()->where(['=','name','Output_data'])->one();

        return $this->render('outputData',[
            'fragment' => $fragment,
        ]);
    }

    /**
     * Download resource
     * @param $resource
     * @return $this
     * @throws NotFoundHttpException
     */
    public function actionDownload($resource)
    {
        $file = Yii::getAlias('@webroot').'/resources/'.$resource;
        if (file_exists($file))
            return Yii::$app->response->sendFile($file);
        throw new NotFoundHttpException("Файл $file не найден");
    }

}
