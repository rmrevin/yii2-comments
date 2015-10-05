<?php

use yii\db\Migration;
use yii\db\Schema;

class m151005_165039_user extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'auth_key' => Schema::TYPE_STRING,
            'token' => Schema::TYPE_STRING,
        ], $tableOptions);

        $this->insert('{{%user}}', [
            'id' => 1,
            'name' => 'Demo User',
            'auth_key' => md5(uniqid()),
            'token' => md5(uniqid()),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
