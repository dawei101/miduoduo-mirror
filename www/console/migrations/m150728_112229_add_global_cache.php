<?php

use yii\db\Schema;
use console\BaseMigration;

class m150728_112229_add_global_cache extends BaseMigration
{
    public function up()
    {

        $this->dropTable('jz_cache_for_api');
        $this->dropTable('jz_cache_for_backend');
        $this->dropTable('jz_cache_for_frontend');
        $this->dropTable('jz_cache_for_m');
        $this->dropTable('jz_cache_for_corp');
        $sqls = "
CREATE TABLE jz_cache (
    id char(128) NOT NULL PRIMARY KEY,
    expire int(11),
    data LONGBLOB
);
        ";

        return $this->execSqls($sqls);
    }

    public function down()
    {
        echo "m150728_112229_add_global_cache cannot be reverted.\n";

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
