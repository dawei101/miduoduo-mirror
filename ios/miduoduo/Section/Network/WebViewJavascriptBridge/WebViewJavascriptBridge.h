//
//  WebViewJavascriptBridge.h
//  miduoduo
//
//  Created by chongdd on 15/6/13.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <Foundation/Foundation.h>

#define kCustomProtocolScheme @"miduoduo"
#define kQueueHasMessage      @"__QUEUE_MESSAGE__"

typedef void (^BridgeResponseCallback)(id responseData);
typedef void (^BridgeHandler)(id data, BridgeResponseCallback responseCallback);

@interface WebViewJavascriptBridge : NSObject <UIWebViewDelegate>

//初始化
- (id)initBridgeForWebView:(UIWebView *)webView defaultHandler:(BridgeHandler)handler;

//注册 oc方法，供 js调用
- (void)registerHandler:(NSString*)handlerName handler:(BridgeHandler)handler;

// oc调用 js方法
- (void)callHandler:(NSString*)handlerName data:(id)data responseCallback:(BridgeResponseCallback)responseCallback;

- (void)loadJS;

- (BOOL)parseWithRequest:(NSURLRequest *)request;

@end
