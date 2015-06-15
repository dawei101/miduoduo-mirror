//
//  UIApplication+ControllerFinder.m
//  miduoduo
//
//  Created by chongdd on 15/6/17.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "UIApplication+ControllerFinder.h"

@implementation UIApplication (ControllerFinder)

- (UIViewController *)activeViewController
{
    UIWindow *window = [self.delegate window];
    return [self topController:window.rootViewController];
}

- (UIViewController *)topController:(UIViewController *)vc {
    if ([vc isKindOfClass:[UITabBarController class]]) {
        UITabBarController *tc = (id)vc;
        return [self topController:tc.selectedViewController];
    } else if ([vc isKindOfClass:[UINavigationController class]]) {
        id controller = [(UINavigationController *)vc topViewController];
        return [self topController:controller];
    } else if ([vc isKindOfClass:[UIViewController class]]) {
        return vc;
    }
    
    return nil;
}

@end
