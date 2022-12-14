<?php

use yii\db\Migration;

/**
 * Class m220903_191932_create_table_tags
 */
class m220903_191932_create_table_tags extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(12),
            'tag_name' => $this->string()->notNull()->unique(),

            'created_at'            => $this->integer()->notNull(),
            'updated_at'            => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('tags');
    }

}
