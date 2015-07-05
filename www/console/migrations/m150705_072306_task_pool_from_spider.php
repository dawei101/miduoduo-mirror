<?php

use yii\db\Schema;
use console\BaseMigration;

class m150705_072306_task_pool_from_spider extends BaseMigration
{
    public function up()
    {
        $sqls = "
    alter table jz_task_pool add status smallint not null default 0;
            ";
        $this->execSqls($sqls);



    }

    public function down()
    {
        echo "m150705_072306_task_pool_from_spider cannot be reverted.\n";

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
