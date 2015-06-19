//
//  PushController.h
//  miduoduo
//
//  Created by chongdd on 15/6/18.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MDDViewController.h"
#import "MDDWebView.h"

@interface PushController : MDDViewController

@property (weak, nonatomic) IBOutlet MDDWebView *webView;


@property (strong, nonatomic)   NSString    *url;
@property (strong, nonatomic)   NSDictionary    *params;


@end
