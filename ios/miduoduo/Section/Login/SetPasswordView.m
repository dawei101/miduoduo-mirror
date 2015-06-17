//
//  SetPasswordView.m
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "SetPasswordView.h"

@interface SetPasswordView ()
{
    UITextField *firstTextField;
    UITextField *secondTextField;
}

@end

@implementation SetPasswordView

- (void)updateView:(UIView *)firstCell withSecondCell:(UIView *)secondCell
{
    firstTextField = [[UITextField alloc]initWithFrame:CGRectMake(10, 0, secondCell.width - 20, secondCell.height)];
    firstTextField.placeholder = @"请设置登录密码";
    firstTextField.secureTextEntry = YES;
    [firstCell addSubview:firstTextField];
    
    secondTextField = [[UITextField alloc]initWithFrame:CGRectMake(10, 0, secondCell.width - 20, secondCell.height)];
    secondTextField.placeholder = @"再次确认密码";
    secondTextField.secureTextEntry = YES;
    [secondCell addSubview:secondTextField];
    
    UIButton *nextBtn = [[UIButton alloc]initWithFrame:CGRectMake(10, secondCell.maxY + 20, self.width - 20, 40)];
    [nextBtn setTitleColor:[UIColor blackColor] forState:UIControlStateNormal];
    [nextBtn setTitle:@"下一步" forState:UIControlStateNormal];
    [nextBtn addTarget:self action:@selector(nextBtnClick:) forControlEvents:UIControlEventTouchUpInside];
    nextBtn.backgroundColor = COLOR_THEME;
    nextBtn.layer.cornerRadius = 5;
    [self addSubview:nextBtn];
}

- (void)nextBtnClick:(id)sender
{
    [self endEditing:YES];
    NSString * first = firstTextField.text;
    NSString * second = secondTextField.text;
    
    if (![first isEqualToString:second]) {
        [UIUtils showAlertView:self withText:@"密码不一致 ！"];
    } else if([first isEmpty]   ) {
        [UIUtils showAlertView:self withText:@"密码不能为空！"];
    } else {
        if ([self.delegate respondsToSelector:@selector(registerBaseView:withParams:)]) {
            [self.delegate registerBaseView:self withParams:first];
        }
    }
}


@end
