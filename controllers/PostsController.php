<?php

namespace app\controllers;


use app\models\Comments;
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

        if ($model->load(Yii::$app->request->post()) && $model->validate([])){
            $this->uploadImage($model);
            if($model->createPost($usr_id)){
                return $this->render('createPost',
                    [
                        'model'=>$model,
                        'status'=> "success",
                    ]);
            }
            else{
                 return $this->render('createPost',
                    [
                        'model'=> $model,
                        'status' => "error",
                    ]);
            }
        }
        return $this->render('createPost',
            [
                'model'=> $model,
                'status' => "creating",
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
        die("Отправляем почту");
    }

    public function actionGetPosts($tag = null, $user = null, $title=null): string
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

        //todo спросить, норм или нет
        if ($model->load(Yii::$app->request->post())) {
            $pageTitle = 'Поиск статьи по заголовку: '. $model->title;
            $query =  $model->getPostsByName($model->title);
        }


        $pages = new Pagination(['totalCount' => $query->count(),
                                'defaultPageSize' => POSTS_ON_PAGE,
        ]);

        $models = $query->offset($pages->offset)
                  ->limit($pages->limit)
                  ->all();

        Posts::formatDate($models);
        return $this->render('getAllPosts', [
                'pageTitle' => $pageTitle,
                'models' => $models,
                'pages' => $pages,
        ]);

    }


    public function actionGetPost($post_id): string
    {
        $post   =  new Posts();
        $model = $post->getPostById($post_id);

        if (!$model){
            return $this->render('getPost', [
                'model' => $model,
                'status' => 'error'
            ]);
        }

        $model->updateCounters(['view_count' => 1]);

        Posts::formatDate(array($model));
        return $this->render('getPost', [
            'model' => $model,
            'status' => 'success'
        ]);
    }

    public function actionAddPostComment($post_id)
    {
        $usr_id = Yii::$app->user->id;
        $model = new Comments();
        if ($model->load(Yii::$app->request->post()) && $model->validate('text')) {

            if($model->createComment($usr_id,$post_id)){
                return $this->redirect(['get-post?post_id='.$post_id]);
            }

        }else{
            //todo вывести страницу с ошибкой
            die("BAD REQUEST");
        }

    }



    //todo СДЕЛАТЬ НОРМАЛЬНО!
    public function actionPostNotFound(){
        die("POST NOT FOUND");
    }

}