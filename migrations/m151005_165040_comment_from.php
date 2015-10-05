<?php

use yii\db\Migration;
use yii\db\Schema;

class m151005_165040_comment_from extends Migration
{

    public function up()
    {
        $this->addColumn('{{%comment}}', 'from', Schema::TYPE_STRING . ' AFTER [[entity]]');
    }

    public function down()
    {
        $this->dropColumn('{{%comment}}', 'from');
    }
}
