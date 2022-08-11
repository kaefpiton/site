<?php

namespace app\controllers;

use app\models\SignupForm;
use Yii;
use app\models\LoginForm;
use app\models\Users;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;


class UauthController extends Controller
{
    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //todo разобраться с методами (был только post)
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionLogin()
    {
        // если не гость, то редиректим
        if (!Yii::$app->user->isGuest) {
          //  return $this->goHome();
        }

         //если гость, то создаем объект модели
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        //в конце передаем модель в представление
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) &&$model->validate()){
                if ($user = $model->signup()) {
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->goHome();
                    }
                }
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }


    //выходит из учетной записи
    public function actionLogout()
    {
        Yii::$app->user->logout();
        $this->goBack();
    }

}

