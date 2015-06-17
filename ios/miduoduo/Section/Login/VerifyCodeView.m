//
//  VerifyCodeView.m
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "VerifyCodeView.h"
#import "NormalUtils.h"
#import "Api.h"

@interface VerifyCodeView ()
{
    UITextField *codeTextField;
    UILabel *hintLabel;
    UIButton    *fetchCodeBtn;
    BOOL    check;
    
    NSTimer *timer;
    int timeNumber;
}

@end

@implementation VerifyCodeView

- (id)initWithDelegate:(id<RegisterBaseViewDelegate>)delegate
{
    self = [super initWithDelegate:delegate];
    if (self) {
        timeNumber = 60;
    }
    
    return self;
}

- (void)updateView:(UIView *)firstCell withSecondCell:(UIView *)secondCell
{
    hintLabel = [[UILabel alloc]initWithFrame:CGRectMake(10, 0, firstCell.width - 20, firstCell.height)];
    [firstCell addSubview:hintLabel];
    
    fetchCodeBtn = [[UIButton alloc]initWithFrame:CGRectMake(secondCell.width - 10 - 108, 6, 108, secondCell.height - 12)];
    fetchCodeBtn.layer.borderColor = [UIColor greenColor].CGColor;
    fetchCodeBtn.layer.borderWidth = 1;
    fetchCodeBtn.layer.cornerRadius  =5;
    [fetchCodeBtn setTitle:@"重新获取" forState:UIControlStateNormal];
    [fetchCodeBtn setTitle:@"重新获取 60" forState:UIControlStateDisabled];
    [fetchCodeBtn setFont:[UIFont systemFontOfSize:14]];
    [fetchCodeBtn setTitleColor:[UIColor greenColor] forState:UIControlStateNormal];
    [fetchCodeBtn setTitleColor:[UIColor whiteColor] forState:UIControlStateDisabled];
    [fetchCodeBtn setBackgroundColor:[UIColor whiteColor]];
    [fetchCodeBtn addTarget:self action:@selector(fetchCodeBtnClick:) forControlEvents:UIControlEventTouchUpInside];
    [secondCell addSubview:fetchCodeBtn];
    
    
    codeTextField = [[UITextField alloc]initWithFrame:CGRectMake(10, 0, secondCell.width-10-fetchCodeBtn.x, secondCell.height)];
    codeTextField.placeholder = @"请输入验证码";
    codeTextField.keyboardType = UIKeyboardTypeDefault;
    
    [secondCell addSubview:codeTextField];
    
    UIButton *checkBox = [[UIButton alloc]initWithFrame:CGRectMake(20, secondCell.maxY + 20, 20, 20)];
    [checkBox setImage:[UIImage imageNamed:@"btn_check_off"] forState:UIControlStateNormal];
    [checkBox setImage:[UIImage imageNamed:@"btn_check_on"] forState:UIControlStateSelected];
    [checkBox addTarget:self action:@selector(checkBoxClick:) forControlEvents:UIControlEventTouchUpInside];
    checkBox.selected = YES;
    check = YES;
    [self addSubview:checkBox];
    
    UIButton *readProtocol = [[UIButton alloc]initWithFrame:CGRectMake(checkBox.maxX+10, secondCell.maxY + 20, self.width-checkBox.maxX, 20)];
    readProtocol.contentHorizontalAlignment = UIControlContentHorizontalAlignmentLeft;
    [readProtocol setBackgroundColor:[UIColor clearColor]];
    [readProtocol setTitle:@"阅读并同意米多多用户协议" forState:UIControlStateNormal];
    [readProtocol setTitleColor:[UIColor lightGrayColor] forState:UIControlStateNormal];
    [readProtocol addTarget:self action:@selector(readUserProtocolClick:) forControlEvents:UIControlEventTouchUpInside];
    [self addSubview:readProtocol];
    
    UIButton *nextBtn = [[UIButton alloc]initWithFrame:CGRectMake(10, checkBox.maxY + 20, self.width - 20, 40)];
    [nextBtn setTitleColor:[UIColor blackColor] forState:UIControlStateNormal];
    [nextBtn setTitle:@"下一步" forState:UIControlStateNormal];
    [nextBtn addTarget:self action:@selector(nextBtnClick:) forControlEvents:UIControlEventTouchUpInside];
    nextBtn.backgroundColor = COLOR_THEME;
    nextBtn.layer.cornerRadius = 5;
    [self addSubview:nextBtn];
    
}

- (void)setHintSting:(NSString *)hintSting
{
    hintLabel.text = hintSting;
}

- (void)checkBoxClick:(UIButton *)sender
{
    sender.selected = !sender.selected;
    check = sender.selected;
}

- (void)readUserProtocolClick:(id)sender
{
    if ([self.delegate respondsToSelector:@selector(registerBaseView:withParams:)]) {
        [self.delegate registerBaseView:self withParams:nil];
    }
}

- (void)fetchCodeBtnClick:(id)sender
{
    if (![timer isValid]) {
        timer = [NSTimer scheduledTimerWithTimeInterval:1 target:self selector:@selector(timeout) userInfo:nil repeats:YES];
    }
    
    fetchCodeBtn.enabled = NO;
    fetchCodeBtn.backgroundColor = [UIColor lightGrayColor];
    fetchCodeBtn.layer.borderColor = [UIColor lightGrayColor].CGColor;
    
    [self sendVerifyCode];
}

- (void)nextBtnClick:(id)sender
{
    NSString *code = codeTextField.text;
    [self endEditing:YES];
    if (!check) {
        [UIUtils showAlertView:self withText:@"请同意米多多用户协议"];
    } else if ([code isEmpty]) {
        [UIUtils showAlertView:self withText:@"请输入验证码"];
    } else {
        [self stopTimer];
        if ([self.delegate respondsToSelector:@selector(registerBaseView:withParams:)]) {
            [self.delegate registerBaseView:self withParams:code];
        }
    }

}

- (void)stopTimer
{
    timeNumber = 60;
    [timer invalidate];
    fetchCodeBtn.enabled = YES;
    [fetchCodeBtn setTitle:@"重新获取 60" forState:UIControlStateDisabled];
    fetchCodeBtn.backgroundColor = [UIColor whiteColor];
    fetchCodeBtn.layer.borderColor = [UIColor greenColor].CGColor;
}

- (void)timeout
{
    
    if ( --timeNumber == 0) {
        timeNumber = 60;
        [timer invalidate];
        fetchCodeBtn.enabled = YES;
        fetchCodeBtn.backgroundColor = [UIColor whiteColor];
        fetchCodeBtn.layer.borderColor = [UIColor greenColor].CGColor;
    }
    
    NSString *text = [NSString stringWithFormat:@"重新获取 %i",timeNumber];
    NSLog(@"%@",text);
    [fetchCodeBtn setTitle:text forState:UIControlStateDisabled];
}

- (void)show
{

}

- (void)hidden
{
    
}


- (void)sendVerifyCode
{
    [[Api instance] requestWithApi:API_VCONDE parameters:@{@"phonenum":self.phoneNumber} success:^(AFHTTPRequestOperation *operation, id responseObject) {
        NSLog(@"%@",responseObject);
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"%@",error);
    }];
}

@end
