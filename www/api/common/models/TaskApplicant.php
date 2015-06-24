<?php

namespace api\common\models;

class TaskApplicant extends \common\models\TaskApplicant
{

    public static function primaryKey()
    {
        return ['user_id', 'task_id'];
    }

}
