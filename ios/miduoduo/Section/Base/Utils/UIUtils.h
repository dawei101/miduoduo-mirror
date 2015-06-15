//
//  UIUtils.h
//  miduoduo
//
//  Created by chongdd on 15/6/9.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "MBProgressHUD.h"
typedef void (^ResultBlock)(NSString *text);

@interface UIUtils : NSObject

+ (UIWindow *)mainWindow;

+ (UIViewController *)activityViewController;

+ (UIView *)createBackItemView;

+ (UIViewController *)viewController:(NSString *)viewController;

+ (UIViewController *)activityViewController;

+ (void)showAlertView:(UIView *)view text:(NSString *)text delay:(NSInteger)delay;
+ (void)showAlertView:(UIView *)view withText:(NSString *)text;
+ (MBProgressHUD *)showAlertView:(UIView *)view text:(NSString *)text;
+ (void)showRefreshView:(UIView *)view text:(NSString *)text;
+ (void)hiddenAlertView:(UIView *)view;

+ (UIButton *)createNextButton;

+ (UIView *)dateInputAccessoryViewWithTarget:(id)target action:(SEL)action;
+ (UIDatePicker *)datePickerWithTarget:(id)target action:(SEL)action;


@end
