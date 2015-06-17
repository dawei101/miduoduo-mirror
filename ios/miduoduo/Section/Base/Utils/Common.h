//
//  Common.h
//  miduoduo
//
//  Created by chongdd on 15/6/10.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#ifndef miduoduo_Common_h
#define miduoduo_Common_h

#define SCREEN_HEIGHT  [UIScreen mainScreen].bounds.size.height
#define SCREEN_WIDTH   [UIScreen mainScreen].bounds.size.width
#define NAVIGATION_HEIGHT       64

#define CONTENT_NO_TAB_HEIGHT       (SCREEN_HEIGHT-64)


#define COLOR_THEME     [UIColor colorFromHexString:@"#FED732"]
#define COLOR_DEFAULT_BG     [UIColor colorFromHexString:@"#EEEEEE"]

#define BUTTON_CORNERRADIUS         5


// 声明一个变量  get／set 等方法
#define AS_DYNAMIC_PROPERTY(_getter_, _setter_, _type_) \
- (void)_setter_:(_type_)v;  \
- (_type_)_getter_;

// 动态添加一个变量
#define DEF_DYNAMIC_OBJECT_PROPERTY(_getter_, _setter_, _type_, _objc_ass_)    \
static const NSString *KEY_##_getter_ = @#_getter_;  \
- (void)_setter_:(_type_)v {    \
objc_setAssociatedObject(self, &KEY_##_getter_, v, _objc_ass_);  \
}   \
- (_type_)_getter_ {    \
_type_ value = objc_getAssociatedObject(self, &KEY_##_getter_); \
return value;   \
}

// Dynamic OBJECT-RETAIN-NONATOMIC property
#define DEF_DYNAMIC_PROPERTY(_getter_, _setter_, _type_)    \
DEF_DYNAMIC_OBJECT_PROPERTY(_getter_, _setter_, _type_, OBJC_ASSOCIATION_RETAIN_NONATOMIC)


// 单例 声明
#define AS_SINGLETON(_name_)            _AS_SINGLETON(instancetype, _name_)
// 单例 定义
#define DEF_SINGLETON(_name_)           _DEF_SINGLETON(instancetype, self, _name_)

#define _AS_SINGLETON(_type_, _name_)  \
+ (_type_)_name_;

#define _DEF_SINGLETON(_type_, _class_, _name_) \
+ (_type_)_name_ { \
static id o = nil; \
static dispatch_once_t onceToken; \
dispatch_once(&onceToken, ^{ \
o = [[_class_ alloc] init]; \
}); \
return o; \
}


#endif
