<?php

namespace console;
use yii\db\Migration;


class BaseMigration extends Migration
{

    public function getSqlFile($filename)
    {
        return Yii::getAlias("@console") . '/sqls/' . $filename;
    }

    public function execFile($file)
    {
        $file_path = $this->getSqlFile($file);
    }

}
