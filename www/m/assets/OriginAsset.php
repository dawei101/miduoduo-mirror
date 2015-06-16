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
class OriginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
    ];
    public $js = [
        'static/origin/js/angularjs/1.3.16/angular.min.js',
        'static/origin/js/angularjs/1.3.16/angular-resource.min.js',
        'static/origin/js/angularjs/1.3.16/angular-route.min.js',
        'static/origin/js/services.js',
        'static/origin/js/app.js',
    ];
    public $depends = [
    ];
}
