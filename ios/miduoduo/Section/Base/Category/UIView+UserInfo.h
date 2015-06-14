//
//  UIView+UserInfo.h
//  miduoduo
//
//  Created by chongdd on 15/6/12.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface UIView (UserInfo)

#define AS_DYNAMIC_PROPERTY(_getter_, _setter_, _type_) \
- (void)_setter_:(_type_)v;  \
- (_type_)_getter_;

AS_DYNAMIC_PROPERTY(userInfo, setUserInfo, id)

@end
