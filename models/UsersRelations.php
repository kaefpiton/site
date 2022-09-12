<?php
namespace app\models;

use app\models\Posts;


trait UsersRelations{

    //todo checked
    //to relate one post to many users
    public function getPosts(){
        return $this->hasMany(Posts::className(), ['users_id' => 'id']);
    }

    //to relate one post to many comments
    public function getComments(){
        return $this->hasMany(Commentaries::className(), ['id' => 'users_id'])
            ->viaTable('comments',['users_id' => 'id']);
    }
}