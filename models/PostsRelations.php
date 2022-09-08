<?php
namespace app\models;

use app\models\Tags;
use app\models\Users;

trait PostsRelations{
    //to relate many posts to many tags
    public function getTags(){
        return $this->hasMany(Tags::className(),['id'=>'tag_id'] )
            ->viaTable('posts_tags', ['post_id' => 'id']);
    }

    //to relate one post to many users
    public function getUsers(){
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }
}