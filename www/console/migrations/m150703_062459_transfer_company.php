<?php

use yii\db\Schema;
use yii\db\Migration;

class m150703_062459_transfer_company extends Migration
{
    public function up()
    {
        $sqls = "
            insert into jz_company (name, introduction) 
                select DISTINCT (company_name) company_name, company_introduction from jz_task;
                update jz_task set company_id = (select id from jz_company where jz_company.name=jz_task.company_name) where 1=1;
                
            ";

    }

    public function down()
    {
        echo "m150703_062459_transfer_company cannot be reverted.\n";

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
