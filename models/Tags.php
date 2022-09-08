<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Tags extends ActiveRecord{
    use TagsRelations;
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return 'tags';
    }

    //to relate many posts to many tags
    public function  getPosts(){
        return $this->hasMany(Posts::className(),['id' => 'post_id'] )
            ->viaTable('posts_tags', ['tag_id' => 'id']);
    }


    /**
     * return concrete tag by id
     */
    public static function getTagById($tag_id)
    {
        return Tags::find()->where(['id' => $tag_id]);
    }

}