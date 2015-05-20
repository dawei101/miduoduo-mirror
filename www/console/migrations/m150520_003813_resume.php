<?php

use yii\db\Schema;
use yii\db\Migration;

class m150520_003813_resume extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('jz_resumes', [
            'id'            => Schema::TYPE_PK,
            'user_id'       => Schema::TYPE_STRING   . ' NOT NULL',
            'name'          => Schema::TYPE_STRING   . ' NOT NULL',
            'phonenum'      => Schema::TYPE_STRING   . '(100) NOT NULL',
            'gender'        => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'birthdate'     => Schema::TYPE_STRING   . ' NOT NULL',
            'degree'        => Schema::TYPE_SMALLINT . ' NOT NULL',
            'nation'        => Schema::TYPE_STRING   . ' NOT NULL',
            'height'        => Schema::TYPE_STRING   . ' NOT NULL',
            'is_student'    => Schema::TYPE_BOOLEAN  . ' NOT NULL default true',
            'college'       => Schema::TYPE_STRING   . '(500) NOT NULL',
            'avatar'        => Schema::TYPE_STRING   . '(2048) NOT NULL',
            'gov_id'        => Schema::TYPE_STRING   . '(50)',
            'grade'         => Schema::TYPE_SMALLINT . ' default 0',
            'worker_type'   => Schema::TYPE_SMALLINT,
            'status'        => Schema::TYPE_INTEGER  . ' NOT NULL default 0',
            // MySQL (before version 5.6.5) does not allow functions to be used for default DateTime values. 
            // http://stackoverflow.com/questions/168736/how-do-you-set-a-default-value-for-a-mysql-datetime-column
            'created_time'  => Schema::TYPE_DATETIME . ' default CURRENT_TIMESTAMP',
            'updated_time'  => Schema::TYPE_DATETIME . '  ON UPDATE CURRENT_TIMESTAMP',

        ], $tableOptions);
        $this->createIndex('idx_user_id_of_resume', 'jz_resumes', 'user_id');

    }

    public function down()
    {
        $this->dropTable('jz_resumes');
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
