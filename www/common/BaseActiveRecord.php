<?php
namespace common;


use yii\db\ActiveRecord;


class BaseActiveRecord extends ActiveRecord
{

    public static $STATUSES = [
        'ACTIVE' => 0,
        'DELETE' => 10,
    ];
    public static $STATUS_LABELS = [0=>'正常',
        10=>'已删除'];


}
