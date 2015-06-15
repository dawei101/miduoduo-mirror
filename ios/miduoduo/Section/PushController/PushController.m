//
//  PushController.m
//  miduoduo
//
//  Created by chongdd on 15/6/18.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "PushController.h"
#import "MDDWebViewModel.h"

@interface PushController () <UIWebViewDelegate>

@end

@implementation PushController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view from its nib.
    
    self.webView.url = self.url;
    self.webView.delegate =self;
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


- (void)backBarClick
{
    MDDWebViewModel *webModel = self.userInfo;
    if (webModel.callback) {
        
//        webModel.callback(@{@"action": @(7)});
     }
    
    [self.webView send:@{@"action": @(7)} withResponse:^(id data) {
        BOOL result = [[data valueForKey:@"result"] boolValue];
        if (result) {
            [super backBarClick];
            [UIUtils showAlertView:self.view withText:@"html 允许返回"];
        } else {
            [UIUtils showAlertView:self.view withText:@"html 不允许返回"];
        }
    }];

    
}


- (void)webViewDidFinishLoad:(UIWebView *)webView
{
    NSLog(@"...................")  ;
}


- (void)webView:(UIWebView *)webView didFailLoadWithError:(NSError *)error
{
    NSLog(@"%@",error);
}

@end
