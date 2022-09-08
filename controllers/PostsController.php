<?php

namespace app\controllers;


use app\models\ImageUpload;
use Yii;
use app\models\Users;
use yii\base\BaseObject;
use yii\data\Pagination;
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

    public function actionCreatePost()
    {
        $usr_id = Yii::$app->user->id;
        $model = new Posts();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){

            $this->uploadImage($model);

            if($model->createPost($usr_id)){
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

        return $this->render('createPost',
            [
                'model'=>$model,
                'error' => "Ошибка создания поста",
                'user_id' => $user_id,
            ]);
    }
    //todo возможно вынести в uploader или еще куда-то
    private function uploadImage($model){
        $imageUploader = new ImageUpload();

        if (UploadedFile::getInstance($model, 'image') != null){
            $model->image = $imageUploader->uploadFile(UploadedFile::getInstance($model, 'image'), " ");
        }
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

    public function actionGetAllPosts($tag = null, $user = null): string
    {
        define('POSTS_ON_PAGE', 5);

        $model = new Posts();

        $pageTitle = 'Все публикации';
        $query =  $model->getAllPosts();

        if ($tag){
            $pageTitle = 'Публикации по тегу: '. $tag;
            $query =  $model->getPostsByTag($tag);
        }
        if ($user){
            $curUser = new Users();
            $pageTitle = 'Публикации пользователя: '. $curUser->getByID($user)->username;
            $query =  $model->getPostsByUser($user);
        }

        $pages = new Pagination(['totalCount' => $query->count(),
                                'defaultPageSize' => POSTS_ON_PAGE,
        ]);

        $models = $query->offset($pages->offset)
                  ->limit($pages->limit)
                  ->all();

        return $this->render('getAllPosts', [
                'pageTitle' => $pageTitle,
                'models' => $models,
                'pages' => $pages,
        ]);

    }


    public function actionGetPost($post_id): string
    {
        $model = Posts::getPostById($post_id);

        if (!$model){$this->actionPostNotFound();}

        $model->updateCounters(['view_count' => 1]);

        return $this->render('getPost', [
            'model' => $model,
        ]);
    }



    //todo СДЕЛАТЬ НОРМАЛЬНО!
    public function actionPostNotFound(){
        die("POST NOT FOUND");
    }

}