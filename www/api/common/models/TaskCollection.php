<?php

namespace api\common\models;

class TaskCollection extends \common\models\TaskCollection
{
    public static function primaryKey()
    {
        return ['user_id', 'task_id'];
    }

}

