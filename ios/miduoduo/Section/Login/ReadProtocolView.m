//
//  ReadProtocolView.m
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "ReadProtocolView.h"

@implementation ReadProtocolView

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        self.backgroundColor = COLOR_DEFAULT_BG;
        [self initView];
    }
    
    return self;
}

- (id)init
{
    self = [self initWithFrame:CGRectMake(0, 0, SCREEN_WIDTH, SCREEN_HEIGHT)];
    if (self) {
        
    }
    
    return self;
}

- (void)initView
{
    UITextView *textView = [[UITextView alloc]initWithFrame:self.bounds];
    textView.text = @"米多多 用户协议 .......";
    
    [self addSubview:textView];
}

@end
