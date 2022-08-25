<?php


namespace app\controllers;

use app\models\CreatePostForm;
use app\models\ImageUpload;
use Yii;
use app\models\Users;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\Posts;
use yii\web\UploadedFile;


class PostsController extends Controller
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
                        'actions' => ['creation'],
                        'allow' => true,
                        'roles' => ['user'],
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

    public function actionCreation()
    {
        $usr_id = Yii::$app->user->id;
        $model = new CreatePostForm();
        $imageUploader = new ImageUpload();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){

            if (UploadedFile::getInstance($model, 'image') != null){
                $model->image = $imageUploader->uploadFile(UploadedFile::getInstance($model, 'image'), " ");
            }


            if($model->write($usr_id)){
                //todo do redirect
            }else{
                //todo do handle error and log it!!!

                /* return $this->render('creation',
                    [
                        'model'=> $model,
                        'error' => "Ошибка создания поста",
                        'user_id' => $user_id,
                    ]);*/
            }

        }

        return $this->render('creation',
            [
                'model'=>$model,
                'error' => "Ошибка создания поста",
                'user_id' => $user_id,
            ]);
    }

    //todo подчистить
    public function actionPtest()
    {
        $model = Posts::findOne(1);
        //echo "<pre>";
        //echo "</pre>";
        // return $this->render("creation",  ['model' => $model]);
        // die("connect");
    }

    public function actionShow()
    {
        $model = Posts::find()->all();

        return $this->render("show",  ['model' => $model]);
    }


}