<?php

use yii\db\Schema;

class m150106_122229_comments extends \yii\db\Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%comment}}', [
            'id' => Schema::TYPE_PK,
            'entity' => Schema::TYPE_STRING,
            'text' => Schema::TYPE_TEXT,
            'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex('index_entity', '{{%comment}}', ['entity']);
        $this->createIndex('index_created_by', '{{%comment}}', ['created_by']);
        $this->createIndex('index_created_at', '{{%comment}}', ['created_at']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}