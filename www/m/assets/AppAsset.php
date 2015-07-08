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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'static/css/m-midd.css',
        'static/fonts/iconfont.css',
    ];
    public $js = [
        'static/js/fastclick.js',
        'static/js/jquery.min.js',
    ];
}
