//
//  UIUtils.h
//  miduoduo
//
//  Created by chongdd on 15/6/9.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <Foundation/Foundation.h>

typedef void (^ResultBlock)(NSString *text);

@interface UIUtils : NSObject

+ (UIView *)createBackItemView;

+ (UIViewController *)viewController:(NSString *)viewController;

+ (UIViewController *)activityViewController;

+ (void)showAlertView:(UIView *)view withText:(NSString *)text;


+ (UIButton *)createNextButton;

+ (UIView *)dateInputAccessoryViewWithTarget:(id)target action:(SEL)action;
+ (UIDatePicker *)datePickerWithTarget:(id)target action:(SEL)action;


@end
