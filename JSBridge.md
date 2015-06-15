#Js Bridge

我们Js Bridge的实现是基于开源[JsBridge](https://github.com/lzyzsd/JsBridge)
原理为,在webview中，js通过添加iframe 节点，在ios/android可以捕获对应的事件，然后进行处理。

##action: 

* 导航栏配置
* 隐藏导航栏
* 提示框
* 确认提示
* push 新的页面
* pop 
* 返回按钮
* 地图位置获取
* 城市切换



data：
1、nvshow：0:隐藏、1:显示；left：返回／其他text；title：text；right：text  （如果要配置图片，要添加 png 后缀名）
2、
3、type：1、刷新界面；2、加载中；3、文字提示；4、点击view 以外区域消失；title：txt；message：txt；delay：秒；button［显示文字：回传文字；如：ok：1；cancel：2］
4、
5、url：txt；params：json
6、nvshow：0:隐藏、1:显示；
7、


返回格式：
action：txt
result：txt


8／9
name：txt
address：txt
city：txt
location：｛39.927321,116.434821｝


checkupdate
in:

out:
title:txt
msg:txt:
version:txt
url:txt

checkversion
in:

out:
version:txt


