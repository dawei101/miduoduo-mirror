<?php

use yii\db\Schema;
use console\BaseMigration;

class m150707_101450_add_contact_name_to_company extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_company add contact_name varchar(200);
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150707_101450_add_contact_name_to_company cannot be reverted.\n";

        return false;
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
