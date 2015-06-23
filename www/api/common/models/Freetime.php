<?php

namespace api\common\models;

class Freetime extends \common\models\Freetime
{
    public static function primaryKey()
    {
        return ['user_id', 'dayofweek'];
    }
}
