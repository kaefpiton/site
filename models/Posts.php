<?php

namespace app\models;

use Yii;
use yii\base\BaseObject;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;



class Posts extends ActiveRecord
{
    use PostsRelations;

    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return 'posts';
    }



    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    public function attributeLabels()
    {
        return [
            'title' =>'Введите название статьи',
            'content' =>'Введите текст статьи',
            'image' => 'Загрузите изображение к статье',
        ];
    }

    public function rules()
    {
        define('TOOLONG_TITLE', 'Заголовок не может быть больше 150 символов!');
        define('NOT_UNIQUE_TITLE', 'Заголовок должен быть уникальным!');

        define('TOOSHORT_CONTENT', 'Текст статьи не может быть меньше 100 символов!');
        define('TOOLONG_CONTENT', 'Текст статьи не может быть больше 1000 символов!');

        define('EMPTY_MESSAGE', 'Данное поле не может быть пустым!');

        return [
            ['title', 'trim'],
            ['title', 'required','message' => EMPTY_MESSAGE],
            ['title', 'string', 'max' => 150, 'tooLong' => TOOLONG_TITLE],
            ['title', 'unique', 'targetClass' => '\app\models\Posts', 'message' => NOT_UNIQUE_TITLE],

            ['content', 'trim'],
            ['content', 'required','message' => EMPTY_MESSAGE],
            ['content', 'string', 'min' => 100, 'max' => 9999, 'tooShort' => TOOSHORT_CONTENT,'tooLong' => TOOLONG_CONTENT],
        ];
    }

    /**
     * Save user's post in database
     *
     * @return bool save post or not
     */
    public function createPost($user_id)
    {
        if (!$this->validate()) {
            return null;
        }
        define('DEFAULT_VIEW_COUNT', 0);

        $post = new Posts();

        $post->title            = $this->title;
        $post->content          = $this->content;
        $post->image            = $this->image;
        $post->users_id         = $user_id;
        $post->view_count       = DEFAULT_VIEW_COUNT;
        $post->date_of_creation = date('Y-m-d H:i:s');

        $post->created_at       = null;
        $post->updated_at       = null;


        return  $post->save();
    }






    public function getAllPosts(){
        return Posts::find()->orderBy(["date_of_creation" => SORT_DESC]);
    }

    /**
     * @return array concrete post by id
     */
    public static function getPostById($post_id){
        return Posts::find()->where(['id' => $post_id])->one();
    }


    /**
     * return all posts by tag name
     */
    public function getPostsByTag($tag_name){
        return Posts::find()
            ->joinWith('tags')
            ->where(['tags.tag_name' => $tag_name]);
    }

    /**
     * return all posts by user id
     */
    public function getPostsByUser($id){
        return Posts::find()
            ->joinWith('users')
            ->where(['users.id' => $id]);
    }

}