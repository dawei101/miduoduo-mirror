<?php

use yii\db\Schema;
use console\BaseMigration;

class m150606_210900_company extends BaseMigration
{
    public function up()
    {

        $sqls = "
CREATE TABLE IF NOT EXISTS `jz_company` (
  `id` INT NOT NULL,
  `name` VARCHAR(500) NOT NULL COMMENT '企业名',
  `avatar` VARCHAR(1000) NULL COMMENT 'Logo',
  `license_id` VARCHAR(500) NULL COMMENT '营业执照号',
  `license_img` VARCHAR(500) NULL COMMENT '营业执照',
  `examined_time` TIMESTAMP NULL COMMENT '审核日期',
  `status` SMALLINT NULL DEFAULT 0 COMMENT '状态',
  `examined_by` INT NOT NULL DEFAULT 0 COMMENT '审核人',
  `user_id` INT NOT NULL DEFAULT 0 COMMENT '用户',
  `address_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_p_company_jz_user1_idx` (`user_id` ASC),
  INDEX `fk_p_company_jz_user2_idx` (`examined_by` ASC),
  INDEX `fk_jz_company_jz_address1_idx` (`address_id` ASC)
)
ENGINE = InnoDB";
        return $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150606_210900_company cannot be reverted.\n";

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
