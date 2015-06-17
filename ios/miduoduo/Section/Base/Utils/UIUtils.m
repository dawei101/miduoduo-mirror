//
//  UIUtils.m
//  miduoduo
//
//  Created by chongdd on 15/6/9.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "UIUtils.h"

@implementation UIUtils


+ (UIView *)createBackItemView
{
    UIView *view = [[UIView alloc]initWithFrame:CGRectMake(0, 0, 30, 30)];
    UIImageView *imageView = [[UIImageView alloc]initWithFrame:view.bounds];
    imageView.image = [UIImage imageNamed:@"back"];
    [view addSubview:imageView];
    
    
    return view;
}

+ (UIViewController *)viewController:(NSString *)viewController
{
    return [[NSClassFromString(viewController) alloc]init];
}

// 获取当前处于activity状态的view controller
+ (UIViewController *)activityViewController
{
    UIViewController* activityViewController = nil;
    
    UIWindow *window = [[UIApplication sharedApplication] keyWindow];
    if(window.windowLevel != UIWindowLevelNormal)
    {
        NSArray *windows = [[UIApplication sharedApplication] windows];
        for(UIWindow *tmpWin in windows)
        {
            if(tmpWin.windowLevel == UIWindowLevelNormal)
            {
                window = tmpWin;
                break;
            }
        }
    }
    
    NSArray *viewsArray = [window subviews];
    if([viewsArray count] > 0)
    {
        UIView *frontView = [viewsArray objectAtIndex:0];
        
        id nextResponder = [frontView nextResponder];
        
        if([nextResponder isKindOfClass:[UIViewController class]])
        {
            activityViewController = nextResponder;
        }
        else
        {
            activityViewController = window.rootViewController;
        }
    }
    
    return activityViewController;
}


+ (void)showAlertView:(UIView *)view withText:(NSString *)text
{
    MBProgressHUD *hud = [[MBProgressHUD alloc]initWithView:view];
    [view addSubview:hud];
    hud.mode = MBProgressHUDModeText;
    hud.labelText =  text;
    [hud show:YES];
    [hud hide:YES afterDelay:3];
}

+ (UIButton *)createNextButton
{
    UIButton *nextBtn = [[UIButton alloc]initWithFrame:CGRectMake(10, 20, SCREEN_WIDTH - 20, 40)];
    [nextBtn setTitleColor:[UIColor blackColor] forState:UIControlStateNormal];
    [nextBtn setTitle:@"下一步" forState:UIControlStateNormal];
    nextBtn.backgroundColor = COLOR_THEME;
    nextBtn.layer.cornerRadius = BUTTON_CORNERRADIUS;
    
    return nextBtn;
}

+ (UIView *)dateInputAccessoryViewWithTarget:(id)target action:(SEL)action
{
    UIToolbar *dateToolBar=[[UIToolbar alloc]init];
    dateToolBar.backgroundColor = COLOR_DEFAULT_BG;
    UIBarButtonItem *spaceBtn=[[UIBarButtonItem alloc]initWithBarButtonSystemItem:UIBarButtonSystemItemFlexibleSpace target:nil action:nil];
    UIBarButtonItem *doneBtn=[[UIBarButtonItem alloc]initWithTitle:@"完成" style:UIBarButtonItemStylePlain target:target action:action];
    dateToolBar.frame=CGRectMake(0, 0, 320, 38);
    dateToolBar.items=@[spaceBtn,doneBtn];
    
    return dateToolBar;
}

+ (UIDatePicker *)datePickerWithTarget:(id)target action:(SEL)action
{
    UIDatePicker *datePicker = [[UIDatePicker alloc]initWithFrame:CGRectZero];
    datePicker.backgroundColor = COLOR_DEFAULT_BG;
    datePicker.alpha = .4;
    datePicker.datePickerMode = UIDatePickerModeDate;
    [datePicker addTarget:target action:action forControlEvents:UIControlEventValueChanged];
    return datePicker;
}

@end
