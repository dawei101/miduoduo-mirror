<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace m\assets;

use Yii;

/**
 * @author dawei
 */
class BaseAsset extends \yii\web\AssetBundle
{

    public $basePath = '@webroot';

    public function init()
    {
        $this->baseUrl = Yii::$app->params['baseurl.static.m'];
        parent::init();
    }
}
