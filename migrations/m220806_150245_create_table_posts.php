<?php

use yii\db\Migration;

class m220806_150245_create_table_posts extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('posts',
            ['id'                   => $this->primaryKey(),
            'title'                 => $this->string(255),
            'preview'               => $this->string(500),
            'content'               => $this->string(10000),
            'users_id'              => $this->integer()->defaultValue(1),
            'image'                 => $this->string(255),
            'date_of_creation'      => $this->dateTime(),
            'created_at'            => $this->integer()->notNull(),
            'updated_at'            => $this->integer()->notNull(),
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

    public function down()
    {
        $this->dropTable('posts');
    }
}