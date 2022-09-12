<?php

use yii\db\Migration;

/**
 * Class m220903_191854_create_table_posts_tags
 */
class m220903_191854_create_table_posts_tags extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%posts_tags}}', [
            'id'            => $this->primaryKey(12),
            'post_id'       => $this->integer()->defaultValue(1),
            'tag_id'       => $this->integer()->defaultValue(1),
        ]);

        $this->addForeignKey(
            'fk-posts-post_id',
            'posts_tags',
            'post_id',
            'posts',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tags-tag_id',
            'posts_tags',
            'tag_id',
            'tags',
            'id',
            'CASCADE',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('posts_tags');
    }

}
