//
//  NormalUtils.m
//  miduoduo
//
//  Created by chongdd on 15/6/10.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "NormalUtils.h"

@implementation NormalUtils

+ (BOOL)isFirstRun
{
    return ![[NSUserDefaults standardUserDefaults]boolForKey:@"is_first_run"];
}

+ (void)setFirstRun:(BOOL)isFirst
{
    [[NSUserDefaults standardUserDefaults]setBool:!isFirst forKey:@"is_first_run"];
}

+ (CGFloat)getY:(CGRect) frame{
    return frame.origin.y;
}

+ (CGFloat)getX:(CGRect) frame{
    return frame.origin.x;
}

+ (CGFloat)getWidth:(CGRect) frame {
    return frame.size.width;
}

+ (CGFloat)getHeight:(CGRect) frame{
    return frame.size.height;
}


+ (CGFloat)getViewY:(UIView *) view {
    return [self getY:view.frame];
}

+ (CGFloat)getViewX:(UIView *) view {
    return [self getX:view.frame];
}

+ (CGFloat)getViewWidth:(UIView *) view {
    return [self getWidth:view.frame];
}

+ (CGFloat)getViewHeight:(UIView *) view {
    return [self getHeight:view.frame];
}


@end
