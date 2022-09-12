<?php
namespace app\models;

use app\models\Posts;
use app\models\Users;

trait CommentsRelations{
    public function getPosts(){
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }

    public function getUsers(){
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }
}
