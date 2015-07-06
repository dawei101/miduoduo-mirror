<?php

use yii\db\Schema;
use console\BaseMigration;

class m150705_184449_add_contact_name_to_company extends BaseMigration
{
    public function up()
    {

        $sqls = "
            alter table jz_company add column contact_name varchar(256) default null;
            ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150705_184449_add_contact_name_to_company cannot be reverted.\n";

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
