<?php

use yii\db\Schema;
use yii\db\Migration;

class m150705_071505_task_pool_of_spider extends Migration
{
    public function up()
    {
        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_task_pool_white_list` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `company_name` VARCHAR(200) NOT NULL,
  `examined_time` TIMESTAMP NOT NULL DEFAULT current_timestamp,
  `slug` VARCHAR(100) NULL,
  `examined_by` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `company_name_UNIQUE` (`company_name` ASC))
ENGINE = InnoDB;

    alter table jz_task_pool add created_time timestamp not null default current_timestamp;
            ";
        $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150709_105659_task_pool_white_list cannot be reverted.\n";

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
