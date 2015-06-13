//
//  MDDViewController.m
//  miduoduo
//
//  Created by chongdd on 15/6/8.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MDDViewController.h"

@interface MDDViewController ()

@end

@implementation MDDViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    [self initContentView];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


- (void)initContentView {
    
    
    if ([UIDevice currentDevice].systemVersion.doubleValue >= 7.0) {
        self.edgesForExtendedLayout = UIRectEdgeNone;
    }
    self.view.backgroundColor = [UIColor whiteColor];


    
    if (![self hiddenBackBar]) {
        UIBarButtonItem *leftItem = [[UIBarButtonItem alloc]initWithImage:[UIImage imageNamed:@"back"] style:UIBarButtonItemStyleDone target:self action:@selector(backBarClick)];
        
        self.navigationItem.leftBarButtonItem = leftItem;
        
    }

    [self.navigationItem setHidesBackButton:YES];
    
    UIBarButtonItem *rightBar = nil;
    if (self.rightBarTitle != nil) {
        rightBar = [[UIBarButtonItem alloc]initWithTitle:self.rightBarTitle style:UIBarButtonItemStyleDone target:self action:@selector(rightBarClick)];
    } else {
        
    }
    
    self.navigationItem.rightBarButtonItem = rightBar;
}

- (UIStatusBarStyle)preferredStatusBarStyle {
    return UIStatusBarStyleDefault;
}

- (NSString *)leftBarTitle
{
    return @"";
}

- (NSString *)rightBarTitle
{
    return @"";
}

- (BOOL)hiddenBackBar
{
    return NO;
}

- (void)leftBarClick
{

}

- (void)rightBarClick
{

}

- (void)backBarClick
{
    [self.navigationController popViewControllerAnimated:YES];
}

@end
