//
//  RegisterBaseView.m
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "RegisterBaseView.h"


@interface RegisterBaseView ()
{
    UIView  *firstCell;
    UIView  *secondCell;
    
}

@end
@implementation RegisterBaseView

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        self.backgroundColor = COLOR_DEFAULT_BG;
        [self initView];
    }
    
    return self;
}

- (id)initWithDelegate:(id<RegisterBaseViewDelegate>)delegate
{
    self = [self initWithFrame:CGRectMake(0, 0, SCREEN_WIDTH, SCREEN_HEIGHT)];
    if (self) {
        self.delegate = delegate;
    }
    
    return self;
}

- (void)initView {
    firstCell = [[UIView alloc]initWithFrame:CGRectMake(0, 0, self.width, 55)];
    firstCell.backgroundColor = [UIColor whiteColor];
    [self addSubview:firstCell];
    
    
    secondCell = [[UIView alloc]initWithFrame:CGRectMake(0, firstCell.maxY+1, self.width, 55)];
    secondCell.backgroundColor = [UIColor whiteColor];
    [self addSubview:secondCell];
    
    [self updateView:firstCell withSecondCell:secondCell];
}

- (void)updateView:(UIView *)firstCell withSecondCell:(UIView *)secondCell
{

}

- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event
{
    [self endEditing:YES];
}

@end
