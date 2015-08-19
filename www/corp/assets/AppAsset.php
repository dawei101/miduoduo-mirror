<?php

namespace corp\assets;

class AppAsset extends BaseAsset
{
    public $basePath = '@webroot';

    public $css = [
        'static/font/iconfont.css',
        'static/css/bootstrap.min.css',
        'static/css/miduoduo-qy.css',
        'static/js/data/daterangepicker-bs3.css',
    ];

    public $js = [
        'static/js/jquery.min.js',
        'static/js/bootstrap.min.js',
        'static/js/miduoduo.js',
        'static/js/data/moment.js',
        'static/js/data/daterangepicker.js',
        'static/js/fuwenben/bootstrap-wysiwyg.js',
        'static/js/fuwenben/external/jquery.hotkeys.js',
        'static/js/jquery.tagbox.js',
    ];

    public $depends = [];
}
