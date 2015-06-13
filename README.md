米多多
===============================

用到的工具与开发环境
-------------------------------
##[Ubuntu14.04](http://www.ubuntu.com/server)

##[php5.5.9](http://php.net/)

##[Mysql5.6.19](https://www.mysql.com/)

##[composer](https://getcomposer.org/)

##[Yii2](http://www.yiiframework.com/doc-2.0/)

##(Yii2 经典模板)https://github.com/yiisoft/yii2-app-advanced

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-app-advanced/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-app-advanced/downloads.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

##[bootstrap](http://getbootstrap.com/css/)
项目中bootstrap在pc端，和手机m端最初版本用了很多。

##[jQuery](https://jquery.com/)


Git
-------------------------------
##[git 版本控制器与Github](https://github.com/)


代码结构
===============================

```
bin                          包含命令行工具，自动安装部署等
    composer.phar
    install
    ....
ios
android
www                          Yii2经典模板结构
    common
        config/              共享 configurations
        mail/                e-mails 模板
        models/              共享models
    console
        config/              contains console configurations
        controllers/         contains console controllers (commands)
        migrations/          contains database migrations
        models/              contains console-specific model classes
        runtime/             contains files generated during runtime
    backend                  dashboard 后台管理代码
        assets/              contains application assets such as JavaScript and CSS
        config/              contains backend configurations
        controllers/         contains Web controller classes
        models/              contains backend-specific model classes
        runtime/             contains files generated during runtime
        views/               contains view files for the Web application
        web/                 contains the entry script and Web resources
    frontend                 m端代码
        assets/              contains application assets such as JavaScript and CSS
        config/              contains frontend configurations
        controllers/         contains Web controller classes
        models/              contains frontend-specific model classes
        runtime/             contains files generated during runtime
        views/               contains view files for the Web application
        web/                 contains the entry script and Web resources
        widgets/             contains frontend widgets
    m                        m端代码(包含App嵌入的html)
        assets/              contains application assets such as JavaScript and CSS
        config/              contains m configurations
        controllers/         contains Web controller classes
        models/              contains m-specific model classes
        runtime/             contains files generated during runtime
        views/               contains view files for the Web application
        web                  contains the entry script and Web resources
            origin/          手机app运行的所有代码
        widgets/             contains m widgets
    api                      api 模块
        common
            models           api内共用到的models
        config               api configurations
        modules              不同api的版本都在此
            v*               版本 如v1
                controllers  v* 的controllers
                models       v* 的特殊models
                Module.php   
    vendor/                  contains dependent 3rd-party packages
    environments/            contains environment-based overrides
    tests                    contains various tests for the advanced application
        codeception/         contains tests developed with Codeception PHP Testing Framework
```

数据结构图
===============================
![alt tag](http://7xjr6t.com1.z0.glb.clouddn.com/sql-struct.png)

