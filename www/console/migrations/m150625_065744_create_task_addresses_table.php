<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_065744_create_task_addresses_table extends Migration
{
    public function up()
    {

        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_task_address` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `province` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `district` VARCHAR(45) NULL,
  `lat` DOUBLE NOT NULL,
  `lng` DOUBLE NOT NULL,
  `task_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_lng_of_task_address` (`lng` ASC),
  INDEX `idx_lat_of_task_address` (`lng` ASC),
  INDEX `fk_jz_task_address_jz_task1_idx` (`task_id` ASC),
  INDEX `fk_jz_task_address_jz_user1_idx` (`user_id` ASC)
)
ENGINE = InnoDB";
    }

    public function down()
    {
        echo "m150625_065744_create_task_addresses_table cannot be reverted.\n";
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
