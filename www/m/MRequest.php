<?php

namespace m;


class MRequest extends \yii\web\Request
{

    public function is_wechat()
    {
        return stripos($this->getUserAgent(), 'MicroMessenger') !== false;
    }

}
