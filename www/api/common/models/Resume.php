<?php

namespace api\common\models;

class Resume extends \common\models\Resume
{
    public static function primaryKey()
    {
        return ['user_id'];
    }
}
