<?php


namespace app\models;

use yii\base\BaseObject;
use yii\base\Model;


class CreatePostForm extends Model
{
    public $title;
    public $content;
    public $image;

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
    public function write($user_id)
    {
        if (!$this->validate()) {
            return null;
        }

        $post = new Posts();

        $post->title            = $this->title;
        $post->content          = $this->content;
        $post->preview          = $this->getPreview($this->content);
        $post->image            = $this->image;
        $post->users_id         = $user_id;
        $post->date_of_creation = date('Y-m-d H:i:s');

        return  $post->save();
    }


    /**
     * Get contents preview
     * @return string short version of post content for preview
     */
    private function getPreview($content)
    {
        if (strlen($content) >= 500){
            $preview = substr($content, 0,500);
            return $preview . "...";
        }else{
            return $content;
        }
    }

}