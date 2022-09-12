<?php
namespace app\models;

use app\models\Posts;
use app\models\Users;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


/**
 * Comments model
 *
 * @property integer $id
 * @property string $text
 * @property integer $post_id
 * @property integer $users_id
 * @property string $date_of_creation

 *
 * @property integer $created_at
 * @property integer $updated_at
 */

class Comments extends ActiveRecord{
    use CommentsRelations;

    public $tmp = "0";
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return 'comments';
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
            'text' =>'Введите свой комментарий',
        ];
    }


    public function rules()
    {
        define('TOOLONG_COMMENT', 'Ваш комментарий превышает 1000 символов! Пожалуйста, сократите ваш комментарий!');
        define('EMPTY_MESSAGE', 'Комментарий не может быть пустым!');

        return [
            ['text', 'trim'],
            ['text', 'required','message' => EMPTY_MESSAGE],
            ['text', 'string', 'max' => 1000, 'tooLong' => TOOLONG_COMMENT],
        ];
    }

    /**
     * create comment to post
     *
     * @return bool save post or not
     */
    public function createComment($users_id, $post_id)
    {
        if (!$this->validate()) {
            return null;
        }

        $comment = new Comments();

        $comment->text = $this->text;
        $comment->post_id = $post_id;
        $comment-> users_id = $users_id;
        $comment->date_of_creation = date('Y-m-d H:i:s');

        //todo попробовать datetime в int
        $comment->created_at       = 1;
        $comment->updated_at       = 1;

        return  $comment->save();
    }


}