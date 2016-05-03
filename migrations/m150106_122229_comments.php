<?php

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
            'id' => $this->primaryKey(),
            'entity' => $this->string(),
            'text' => $this->text(),
            'deleted' => $this->boolean()->notNull()->defaultValue(false),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx_entity', '{{%comment}}', ['entity']);
        $this->createIndex('idx_created_by', '{{%comment}}', ['created_by']);
        $this->createIndex('idx_created_at', '{{%comment}}', ['created_at']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}
