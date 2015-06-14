//
//  UIView+UserInfo.m
//  miduoduo
//
//  Created by chongdd on 15/6/12.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "UIView+UserInfo.h"
#import <objc/runtime.h>

@implementation UIView (UserInfo)

// Dynamic OBJECT property
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


DEF_DYNAMIC_PROPERTY(userInfo, setUserInfo, id)

@end
