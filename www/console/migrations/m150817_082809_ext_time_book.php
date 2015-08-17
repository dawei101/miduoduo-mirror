<?php

use yii\db\Schema;
use yii\db\Migration;

class m150817_082809_ext_time_book extends Migration
{
    public function up()
    {

        $sqls = "

CREATE TABLE IF NOT EXISTS `miduoduo`.`ext_time_book_schedule` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` VARCHAR(200) NULL,
  `task_id` VARCHAR(200) NULL,
  `from_datetime` TIMESTAMP NOT NULL,
  `to_datetime` TIMESTAMP NOT NULL,
  `allowable_distance_offset` INT NOT NULL DEFAULT 500,
  `lat` DECIMAL(10,8) NULL,
  `lng` DECIMAL(10,8) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `miduoduo`.`ext_time_book_record` (
  `id` INT NOT NULL,
  `lng` DECIMAL(10,8) NOT NULL,
  `lat` DECIMAL(10,8) NOT NULL,
  `event_type` SMALLINT NULL,
  `created_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` VARCHAR(200) NULL,
  `schedule_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ext_time_book_record_ext_time_book_schedule1_idx` (`schedule_id` ASC),
  CONSTRAINT `fk_ext_time_book_record_ext_time_book_schedule1`
    FOREIGN KEY (`schedule_id`)
    REFERENCES `miduoduo`.`ext_time_book_schedule` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB ;
            ";
    }

    public function down()
    {
        echo "m150817_082809_ext_time_book cannot be reverted.\n";

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
