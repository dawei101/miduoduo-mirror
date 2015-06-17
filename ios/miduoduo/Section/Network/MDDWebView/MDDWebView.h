//
//  MDDWebView.h
//  miduoduo
//
//  Created by chongdd on 15/6/14.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "WebViewJavascriptBridge.h"

@interface MDDWebView : UIWebView

typedef void (^MDDCallback)(id data);

- (void)registerHandler:(NSString*)name handler:(void (^)(id data,MDDCallback cb))handler;

- (void)send:(id)data withHandler:(NSString *)handler withResponse:(void (^)(id data))response;
- (void)send:(id)data withResponse:(void (^)(id data))response;

@end
