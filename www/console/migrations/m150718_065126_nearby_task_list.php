<?php

use yii\db\Schema;
use console\BaseMigration;

class m150718_065126_nearby_task_list extends BaseMigration
{
    public function up()
    {
        $sqls = "
CREATE TABLE `jz_user_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '用户ID',
  `latitude` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '坐标纬度latitude',
  `longitude` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '坐标经度longitude',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `use_nums` int(11) DEFAULT '0' COMMENT '位置使用次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER table `jz_task` ADD `order_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '默认排序时间';

ALTER table `jz_task` ADD `recommend` tinyint(4) DEFAULT '0' COMMENT '是否为优单';
        ";
        $this->execSqls($sqls);
    }

    public function down()
    {
        $this->dropTable('jz_user_location');
        return true;
    }
}
