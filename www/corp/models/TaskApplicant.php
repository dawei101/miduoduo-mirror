<?php
namespace corp\models;

class TaskApplicant extends \common\models\TaskApplicant
{
    public static $STATUSES = [
        0 => '未处理',
        10 => '已接受',
        20 => '不合适',
    ];
}
