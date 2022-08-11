<?php

use yii\db\Migration;

/**
 * Class m220806_150110_create_table_users
 */
class m220806_150110_create_table_users extends Migration
{

    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('users', [
            'id' => $this->primaryKey(12),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    /*public function UpOLD()
    {
        $this->createTable("users",
        [
            'id'             =>   $this->primaryKey(12),
            'username'       =>   $this->string(255),
            'password_hash'  => $this->string()->notNull(),
            'email'          =>   $this->string(255),
            'status'         =>   $this->integer(3),
            'auth_key'       =>   $this->string(255),
            'date_of_registration'   =>   $this->date()
        ]);

    }*/

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
      $this->dropTable('users');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220806_150110_create_table_users cannot be reverted.\n";

        return false;
    }
    */
}
