<?php
namespace app\models;

use app\models\Tags;
use app\models\Comments;
use app\models\Users;

trait PostsRelations{

    //to relate many posts to many tags (via table - так как есть таблица посредник)
    public function getTags(){
       return $this->hasMany(Tags::className(),['id'=>'tag_id'] )
            ->viaTable('posts_tags', ['post_id' => 'id']);
    }

    //to relate one post to user
    public function getUsers(){
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    //to relate one post to many comments
    public function getComments(){
        return $this->hasMany(Comments::className(),['post_id'=>'id']);

    }


}