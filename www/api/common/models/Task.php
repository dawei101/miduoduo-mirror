<?php

namespace api\common\models;

class Task extends \common\models\Task
{

    public static function primaryKey()
    {
        return ['gid'];
    }

}
