//
//  MDDViewController.h
//  miduoduo
//
//  Created by chongdd on 15/6/8.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface MDDViewController : UIViewController



@property (nonatomic, assign)   UIView    *leftBarView;
@property (nonatomic, assign)   UIView    *rightBarView;


- (BOOL)hiddenBackBar;
- (NSString *)leftBarTitle;
- (NSString *)rightBarTitle;

- (void)leftBarClick;
- (void)rightBarClick;

- (void)backBarClick;


@end
