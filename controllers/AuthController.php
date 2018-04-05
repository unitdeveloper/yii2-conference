<?php

namespace app\controllers;

use app\models\Application;
use app\models\Conference;
use app\models\form\EmailConfirmForm;
use app\models\form\LoginForm;
use app\models\form\PasswordResetRequestForm;
use app\models\form\ResetPasswordForm;
use app\models\form\DownloadApplicationFilesForm;
use app\models\form\SignupForm;
use app\models\User;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class AuthController extends SiteController
{
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionSignup()
    {

        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                \Yii::$app->session->setFlash('success', 'Підтвердіть вашу електронну адресу');
            } else {
                \Yii::$app->session->setFlash('error', 'Повідомлення не вдалося відправити');
            }
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionEmailConfirm($token)
    {
        try {
            $model = new EmailConfirmForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->confirmEmail()) {
            \Yii::$app->session->setFlash('success', 'Дякуємо! Ваш Email успішно підтверджений');
        } else {
            \Yii::$app->session->setFlash('error', 'Помилка підтвердження Email');
        }

        return $this->goHome();
    }

    /**
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionPasswordResetRequest()
    {

        $model = new PasswordResetRequestForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                \Yii::$app->session->setFlash('success', 'Дякуємо! На ваш Email було відправлено лист з посиланням на відновлення пароля');
            } else {
                \Yii::$app->session->setFlash('error', 'Вибачте. У нас виникли проблеми з відправкою');
            }
            return $this->goHome();
        }

        return $this->render('passwordResetRequest', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionSignupConference()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(['/auth/login']);
        }

        $model = new Application();

        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->signupConferense()) {

            return $this->redirect(['/profile/application-view',
                'id' => $model->id,
            ]);
        }

        $activeConference = Conference::find()->where(['status' => 1])->one();

        return $this->render('signupConference', [
            'model' => $model,
            'activeConference' => $activeConference,
        ]);
    }

    /**
     * @param $token
     * @return string|Response
     * @throws BadRequestHttpException
     */
    public function actionPasswordReset($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            \Yii::$app->session->setFlash('success', 'Дякуємо! Пароль успішно змінено.');

            return $this->goHome();
        }

        return $this->render('passwordReset', [
            'model' => $model,
        ]);
    }
}