<?php

use yii\db\Schema;
use console\BaseMigration;

class m150826_113514_wechat_red_packet extends BaseMigration
{
    public function up()
    {
        $sqls = "
ALTER TABLE `jz_weichat_user_info` ADD `erweima_ticket` VARCHAR(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '生成的二维码船票，用这个就能得到二维码了';
ALTER TABLE `jz_weichat_user_info` ADD `erweima_date` DATE DEFAULT '2015-01-01' COMMENT '二维码生成日期';
            ";
        return $this->execSqls($sqls);

    }

    public function down()
    {
        echo "m150826_113514_wechat_red_packet cannot be reverted.\n";

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
