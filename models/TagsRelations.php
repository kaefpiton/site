<?php
namespace app\models;

use app\models\Posts;

trait TagsRelations{
    //to relate many posts to many tags
    public function  getPosts(){
        return $this->hasMany(Posts::className(),['id' => 'post_id'] )
            ->viaTable('posts_tags', ['tag_id' => 'id']);
    }
}