//
//  MainViewController.m
//  miduoduo
//
//  Created by chongdd on 15/6/10.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MainViewController.h"
#import "MDDWebView.h"
#import "UIWebView+AFNetworking.h"

@interface MainViewController () <UIWebViewDelegate>
{
    MDDWebView      *webView;
}

@end

@implementation MainViewController

- (void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
    
    webView = [[MDDWebView alloc]initWithFrame:self.view.bounds];
    [self.view addSubview:webView];
    
    webView.delegate = self;
    
    NSString* htmlPath = [[NSBundle mainBundle] pathForResource:@"ExampleApp" ofType:@"html"];
    NSString* appHtml = [NSString stringWithContentsOfFile:htmlPath encoding:NSUTF8StringEncoding error:nil];
//    [webView loadHTMLString:appHtml baseURL:nil];
    
    NSURL *url = [NSURL URLWithString:@"http://www.csdn.net/"];
    NSURLRequest *request = [[NSURLRequest alloc]initWithURL:url];
    [webView loadRequest:request];
    
    
    UIButton *button = [[UIButton alloc]initWithFrame:CGRectMake(20, 100, 280, 40)];
    button.backgroundColor = [UIColor lightGrayColor];
    [button setTitle:@"向 html 发送消息" forState:UIControlStateNormal];
    [button addTarget:self action:@selector(buttonClick:) forControlEvents:UIControlEventTouchUpInside];
    
    [self.view addSubview:button];

    [webView registerHandler:@"confirm" handler:^(id data, void (^callback)(id data)) {
        NSLog(@"%@",data);
        callback(@"kkkkkkkkkkkkk");
    }];
    
}

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    

}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)webViewDidFinishLoad:(UIWebView *)webView
{
    NSLog(@"main -- webViewDidFinishLoad");
}

- (void)buttonClick:(id)sender
{
    
    [[NSURLCache sharedURLCache] removeAllCachedResponses];
    id data = @{ @"data": @"Hi there, JS!" };
    
    [webView send:data withHandler:@"titleClick" withResponse:^(id data) {
        NSLog(@"titleClick handler: %@",data);
    }];
    
    data = @"dddddddddddddddd";
    
//    [webView send:data withResponse:^(id data) {
//        NSLog(@" ----- %@",data);
//    }];
}


#pragma mark - UIAlertViewDelegate
- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex
{
//    if (buttonIndex == 0)
//    {
//        _callback(@{@"result": @YES,@"msg":@"hello yes"});
//    }
//    else
//    {
//        _callback(@{@"result": @NO,@"msg":@"hello no"});
//    }
}

@end
