<?php

use yii\db\Schema;
use console\BaseMigration;

class m150730_112020_task_queue extends BaseMigration
{
    public function up()
    {

        $sqls = "
            create table jz_task_queue 
            (
                `id` INT NOT NULL AUTO_INCREMENT,
                `task_name` varchar(100) not null,
                `params` LONGBLOB,
                `retry_times` smallint not null default 2,
                `start_time` timestamp not null default CURRENT_TIMESTAMP,
                `priority` smallint not null default 2,
                `status` smallint not null default 0,
                PRIMARY KEY (`id`),
                INDEX `idx_hot_task` (`status`)
            );
            ";
        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150730_112020_task_queue cannot be reverted.\n";

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
