<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace m\assets;

use yii\web\AssetBundle;

/**
 * @author dawei
 */
class BootstrapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'static/css/bootstrap.min.css',
        'static/css/bootstrap-theme.min.css',
        'static/css/midd.css',
    ];
    public $js = [
        'static/js/bootstrap.min.js',
        'static/js/fastclick.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
