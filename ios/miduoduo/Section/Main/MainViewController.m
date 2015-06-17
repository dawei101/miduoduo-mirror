//
//  MainViewController.m
//  miduoduo
//
//  Created by chongdd on 15/6/10.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MainViewController.h"

@interface MainViewController ()

@end

@implementation MainViewController

- (void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
    
    
    
    UIButton *button = [[UIButton alloc]initWithFrame:CGRectMake(30, 70, 60, 40)];
    button.backgroundColor = [UIColor lightGrayColor];
    [button addTarget:self action:@selector(buttonClick:) forControlEvents:UIControlEventTouchUpInside];
    
    [self.view addSubview:button];
    
    
}

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    

}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}



- (void)buttonClick:(id)sender
{
//    [GuideView show];

//    [[UIApplication sharedApplication].keyWindow addSubview:controller.view];
    
//    GuideViewController *controller = [[GuideViewController alloc]init];
//    [self.navigationController pushViewController:controller animated:YES];
    
    [self.navigationController pushViewController:[[NSClassFromString(@"RecordViewController") alloc]init] animated:YES];
}


@end
