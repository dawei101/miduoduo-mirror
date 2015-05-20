<?php

use yii\db\Schema;
use yii\db\Migration;

class m150520_014309_freetime extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('jz_freetimes', [
            'id'            => Schema::TYPE_PK,
            'user_id'       => Schema::TYPE_STRING   . ' NOT NULL',
            'dayofweek'     => Schema::TYPE_SMALLINT . ' NOT NULL',
            'morning'       => Schema::TYPE_BOOLEAN  . ' NOT NULL DEFAULT false',
            'afternoon'     => Schema::TYPE_BOOLEAN  . ' NOT NULL DEFAULT false',
            'evening'       => Schema::TYPE_BOOLEAN  . ' NOT NULL DEFAULT false'
            ]);
        $this->createIndex('idx_user_id_of_freetime', 'jz_freetimes', 'user_id');
    }

    public function down()
    {
        $this->dropTable('jz_freetimes');
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
