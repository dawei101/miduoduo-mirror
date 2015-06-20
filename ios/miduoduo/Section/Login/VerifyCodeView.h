//
//  VerifyCodeView.h
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "RegisterBaseView.h"

typedef void (^SendVerifyCodeAction)(void);

@interface VerifyCodeView : RegisterBaseView

@property (nonatomic, strong) NSString  *hintSting;

@property (nonatomic, retain) NSString *phoneNumber  ;

- (void)show;

- (void)hidden;

@end
