//
//  MiViewController.m
//  miduoduo
//
//  Created by chongdd on 15/6/10.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MiViewController.h"

@interface MiViewController ()
{
    MBProgressHUD *HUD;
}

@end

@implementation MiViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    UIButton *button = [[UIButton alloc]initWithFrame:CGRectMake(10, 10, 300, 30)];
    button.backgroundColor = [UIColor lightGrayColor];
    [button addTarget:self action:@selector(showTextDialog:) forControlEvents:UIControlEventTouchDown];
    [self.view addSubview:button];
    
    button = [[UIButton alloc]initWithFrame:CGRectMake(10, 50, 300, 30)];
    button.backgroundColor = [UIColor lightGrayColor];
    [button addTarget:self action:@selector(showProgressDialog2:) forControlEvents:UIControlEventTouchDown];
    [self.view addSubview:button];
    
    button = [[UIButton alloc]initWithFrame:CGRectMake(10, 100, 300, 30)];
    button.backgroundColor = [UIColor lightGrayColor];
    [button addTarget:self action:@selector(showCustomDialog:) forControlEvents:UIControlEventTouchDown];
    [self.view addSubview:button];
    
    button = [[UIButton alloc]initWithFrame:CGRectMake(10, 150, 300, 30)];
    button.backgroundColor = [UIColor lightGrayColor];
    [button addTarget:self action:@selector(showAllTextDialog:) forControlEvents:UIControlEventTouchDown];
    [self.view addSubview:button];
    
    button = [[UIButton alloc]initWithFrame:CGRectMake(10, 200, 300, 30)];
    button.backgroundColor = [UIColor lightGrayColor];
    [button addTarget:self action:@selector(showProgressDialog:) forControlEvents:UIControlEventTouchDown];
    [self.view addSubview:button];
    
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)showTextDialog:(id)sender {
    //初始化进度框，置于当前的View当中
    HUD = [[MBProgressHUD alloc] initWithView:self.view];
    [self.view addSubview:HUD];
    
    //如果设置此属性则当前的view置于后台
    HUD.dimBackground = YES;
    
    //设置对话框文字
    HUD.labelText = @"请稍等";
    
//    [HUD show:YES];
    //显示对话框
    [HUD showAnimated:YES whileExecutingBlock:^{
        //对话框显示时需要执行的操作
        sleep(3);
    } completionBlock:^{
        //操作执行完后取消对话框
        [HUD removeFromSuperview];
        HUD = nil;
    }];
}

- (IBAction)showProgressDialog:(id)sender {
    HUD = [[MBProgressHUD alloc] initWithView:self.view];
    [self.view addSubview:HUD];
    HUD.labelText = @"正在加载";
    
    //设置模式为进度框形的
    HUD.mode = MBProgressHUDModeDeterminate;
    [HUD showAnimated:YES whileExecutingBlock:^{
        float progress = 0.0f;
        while (progress < 1.0f) {
            progress += 0.01f;
            HUD.progress = progress;
            usleep(50000);
        }
    } completionBlock:^{
        HUD = nil;
    }];
}

- (IBAction)showProgressDialog2:(id)sender {
    HUD = [[MBProgressHUD alloc] initWithView:self.view];
    [self.view addSubview:HUD];
    HUD.labelText = @"正在加载";
    HUD.mode = MBProgressHUDModeAnnularDeterminate;
    
    [HUD showAnimated:YES whileExecutingBlock:^{
        float progress = 0.0f;
        while (progress < 1.0f) {
            progress += 0.01f;
            HUD.progress = progress;
            usleep(50000);
        }
    } completionBlock:^{
        [HUD removeFromSuperview];
        HUD = nil;
    }];
}

- (IBAction)showCustomDialog:(id)sender {
    HUD = [[MBProgressHUD alloc] initWithView:self.view];
    [self.view addSubview:HUD];
    HUD.labelText = @"操作成功";
    HUD.mode = MBProgressHUDModeCustomView;
    HUD.customView = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"Checkmark"]];
    [HUD showAnimated:YES whileExecutingBlock:^{
        sleep(2);
    } completionBlock:^{
        [HUD removeFromSuperview];
        HUD = nil;
    }];
    
}

- (IBAction)showAllTextDialog:(id)sender {
    HUD = [[MBProgressHUD alloc] initWithView:self.view];
    [self.view addSubview:HUD];
    HUD.labelText = @"操作成功";
    HUD.mode = MBProgressHUDModeText;
    
    //指定距离中心点的X轴和Y轴的偏移量，如果不指定则在屏幕中间显示
    //    HUD.yOffset = 150.0f;
    //    HUD.xOffset = 100.0f;
    
    [HUD showAnimated:YES whileExecutingBlock:^{
        sleep(2);
    } completionBlock:^{
        [HUD removeFromSuperview];
        HUD = nil;
    }];
}



@end
