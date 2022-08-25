<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;



class Posts extends ActiveRecord
{
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return 'posts';
    }

    //to relate one post to many users
    public function getUsers(){
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [];
    }


    public function getAllPosts(){


        $rows = (new \yii\db\Query())
            ->select(['*'])
            ->from('posts')
            ->all();

        echo "<pre>";
        var_dump($rows);
        echo "</pre>";
        die();
    }

}