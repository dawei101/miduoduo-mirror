//
//  InputPhoneNumberView.m
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "InputPhoneNumberView.h"
#import "NormalUtils.h"

@interface InputPhoneNumberView ()
{
    UILabel *hintLabel;
    UITextField *phoneTextField;
}

@end

@implementation InputPhoneNumberView



- (void)updateView:(UIView *)firstCell withSecondCell:(UIView *)secondCell
{

    hintLabel = [[UILabel alloc]initWithFrame:CGRectMake(10, 0, self.width-10, firstCell.height)];
    [firstCell addSubview:hintLabel];

    
    phoneTextField = [[UITextField alloc]initWithFrame:CGRectMake(10, 0, secondCell.width - 20, secondCell.height)];
    phoneTextField.placeholder = @"请输入手机号码";
    phoneTextField.keyboardType = UIKeyboardTypePhonePad;
    [secondCell addSubview:phoneTextField];
    
    UIButton *nextBtn = [[UIButton alloc]initWithFrame:CGRectMake(10, secondCell.maxY + 20, self.width - 20, 40)];
    [nextBtn setTitleColor:[UIColor blackColor] forState:UIControlStateNormal];
    [nextBtn setTitle:@"下一步" forState:UIControlStateNormal];
    [nextBtn addTarget:self action:@selector(nextBtnClick:) forControlEvents:UIControlEventTouchUpInside];
    nextBtn.backgroundColor = COLOR_THEME;
    nextBtn.layer.cornerRadius = 5;
    [self addSubview:nextBtn];
}

- (void)setHintSting:(NSString *)hintSting
{
    hintLabel.text  = hintSting;
}

- (void)nextBtnClick:(id)sender
{
    [self endEditing:YES];
    NSString * phoneNumber = phoneTextField.text;
    
    if ([phoneNumber isEmpty]) {
        [UIUtils showAlertView:self withText:@"手机号码不能为空！"];
        
        return;
    }
    
    
    if ([self.delegate respondsToSelector:@selector(registerBaseView:withParams:)]) {
        [self.delegate registerBaseView:self withParams:phoneNumber];
    }
}


@end
