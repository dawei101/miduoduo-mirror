//
//  RegisterBaseView.h
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <UIKit/UIKit.h>

@protocol RegisterBaseViewDelegate <NSObject>

- (void)registerBaseView:(UIView *)view withParams:(id)params;

@end

@interface RegisterBaseView : UIView

@property (nonatomic, assign) id<RegisterBaseViewDelegate> delegate;

- (id)initWithDelegate:(id<RegisterBaseViewDelegate>)delegate;

- (void)initView;

- (void)updateView:(UIView *)firstCell withSecondCell:(UIView *)secondCell;


@end
