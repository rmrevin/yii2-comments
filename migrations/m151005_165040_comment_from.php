<?php

use yii\db\Migration;

class m151005_165040_comment_from extends Migration
{

    public function up()
    {
        $this->addColumn('{{%comment}}', 'from', $this->string()->after('entity'));
    }

    public function down()
    {
        $this->dropColumn('{{%comment}}', 'from');
    }
}
