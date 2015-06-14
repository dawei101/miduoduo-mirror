//
//  RegisterViewController.m
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "RegisterViewController.h"
#import "InputPhoneNumberView.h"
#import "VerifyCodeView.h"
#import "ReadProtocolView.h"
#import "SetPasswordView.h"
#import <objc/NSObject.h>
#import "InformationViewController.h"

@interface RegisterViewController () <RegisterBaseViewDelegate>
{
    InputPhoneNumberView *phoneView;
    VerifyCodeView      *verifyCodeView;
    ReadProtocolView    *protocolView;
    SetPasswordView     *setPwdView;
    
    NSArray     *titleList;
    
    NSString    *phoneNumber;
    NSString    *verifyCode;
}

@end

@implementation RegisterViewController


- (void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];

}

- (void)viewDidDisappear:(BOOL)animated
{
    [verifyCodeView hidden];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    phoneView = [[InputPhoneNumberView alloc]initWithDelegate:self];
    verifyCodeView = [[VerifyCodeView alloc]initWithDelegate:self];;
    protocolView = [[ReadProtocolView alloc]init];;
    setPwdView = [[SetPasswordView alloc]initWithDelegate:self];
    [self.view addSubview:phoneView];
    
    if (self.isForgetPwd) {
        titleList = @[@"找回密码",@"验证手机号",@"米多多用户协议",@"设置密码"];
        phoneView.hintSting = @"请填写接收短信的手机号(非注册号)";
        self.title = titleList[0];
    } else {
        titleList = @[@"欢迎注册",@"验证手机号",@"米多多用户协议",@"设置密码"];
        phoneView.hintSting = @"请填写你的注册手机号码";
        self.title = titleList[0] ;
    }
}

- (void)pushView:(UIView *)view
{
    [self.view endEditing:YES];
    if (view == verifyCodeView) {
        NSString *text = [NSString stringWithFormat:@"验证码已发送到： %@,请查收",phoneNumber];
        verifyCodeView.hintSting = text;
        self.title = titleList[1];
    } else if (view == protocolView) {
        self.title = titleList[2];
    } else if (view == setPwdView) {
        self.title = titleList[3];
    } else {
        return;
    }
    
    [self.view addSubview:view];
}

- (BOOL)popView:(UIView *)view
{
    if (view == verifyCodeView) {
        self.title = titleList[0];
    } else if (view == protocolView) {
        self.title = titleList[1];
    } else if (view == setPwdView) {
        self.title = titleList[2];
    } else {
        return NO;
    }
    
    [view removeFromSuperview];
    return YES;
}

#pragma mark --
#pragma mark -- RegisterBaseViewDelegate
- (void)registerBaseView:(UIView *)view withParams:(id)params
{
    if (view == phoneView) {
        phoneNumber = params;
        [self pushView:verifyCodeView];
    } else if (view == verifyCodeView) {
        if (params == nil) { //  阅读用户协议
            [self pushView:protocolView];
        } else { // 下一步
            verifyCode = params;
            [self pushView:setPwdView];
        }
        
    } else if (view == setPwdView) {
        if (!self.isForgetPwd) {
            InformationViewController *controller = [[InformationViewController alloc]init];
            [self.navigationController pushViewController:controller animated:YES];
        }

    }
    
}

- (void)backBarClick
{
    NSArray *subViews = self.view.subviews;
    
    if (subViews.count == 1 && subViews[0] == phoneView) {
        self.navigationController.navigationBarHidden = YES;
        [self.navigationController popViewControllerAnimated:YES];
    }
    
    for (NSInteger i = subViews.count - 1 ; i > 0; i--) {
        UIView *view = subViews[i];
        
        if ([self popView:view]) {
            break;
        }
        
        if ( view == phoneView) {
            [self.navigationController popViewControllerAnimated:YES];
        }
    }
    
    
}

@end
