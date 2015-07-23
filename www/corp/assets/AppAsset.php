<?php

namespace corp\assets;

class AppAsset extends BaseAsset
{
    public $basePath = '@webroot';

    public $css = [
        'css/site.css',
        // 'corp/web/css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
