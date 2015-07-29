<?php
namespace console;


class JobRequest extends \yii\base\Request
{

    public $route; // 如 'job/sync-file'
    public $params;

    public function resolve()
    {
        return [$this->route, $this->params];
    }

}
