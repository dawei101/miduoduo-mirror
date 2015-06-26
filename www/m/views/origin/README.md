Html5 for app
============================

* Url 格式
```
http://h5v版本.origin.主域名/文件名
# 例:
http://h5v1.origin.miduoduo.cn/task/view
```

* 目录结构与文件创建约定
    * 计： ORIGIN_ROOT = project_root/www/m/views/origin

    * 所有目录都不可在ORIGIN_ROOT 之外

    * 以访问的文件创建目录, 以[版本号+.php]为文件名称
        * http://h5v1.origin.miduoduo.cn/task/view -> ORIGIN_ROOT/task/view/1.php
        ```bash
        root@mose:/service/miduoduo/www/m/views/origin# tree
        .
        |-- index
        |   |-- 1.php
        |   `-- 20.php
        `-- task
            `-- view
                    |-- 10.php
                    |-- 1.php
                    `-- 5.php
        ```

    * 新版本只添加对应版本需要修改的文件,高版本文件找不到自动找最近的最高版本文件
        ```bash
        root@mose:/service/miduoduo/www/m/views/origin# ls task/view/
        1.php   5.php    10.php
        ```
        * task/view + version 10
        ```
            http://h5v10.origin.miduoduo.cn/task/view -> ORIGIN_ROOT/task/view/1.php
        ```
        * task/view + version 9
        ```
            http://h5v9.origin.miduoduo.cn/task/view -> ORIGIN_ROOT/task/view/5.php
        ```
