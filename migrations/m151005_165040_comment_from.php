<?php

use yii\db\Migration;

class m151005_165040_comment_from extends Migration
{

    public function up()
    {
        $options = '';
        if ($this->db->driverName === 'mysql') {
            $options = ' AFTER [[entity]]';
        }
        $this->addColumn('{{%comment}}', 'from', $this->string() . $options);
    }

    public function down()
    {
        $this->dropColumn('{{%comment}}', 'from');
    }
}
