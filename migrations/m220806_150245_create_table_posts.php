<?php

use yii\db\Migration;

class m220806_150245_create_table_posts extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function Up()
    {
        $this->createTable('posts',
            ['id'                => $this->primaryKey(),
            'title'             => $this->string(255),
            'content'           => $this->string(255),

            'users_id'           => $this->integer()->defaultValue(1),

            'date_of_creation'  => $this->date()
        ]);

        $this->addForeignKey(
            'fk-posts-users_id',
            'posts',
            'users_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

    }

    public function Down()
    {
        $this->dropTable('post');
    }
}