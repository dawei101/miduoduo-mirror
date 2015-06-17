//
//  MDDWebView.m
//  miduoduo
//
//  Created by chongdd on 15/6/14.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MDDWebView.h"
#import "WebViewJavascriptBridge.h"
#import "MessageInterceptor.h"

#import "MDDWebViewResponder.h"

#define kCustomProtocolScheme @"miduoduo"
#define kQueueHasMessage      @"__QUEUE_MESSAGE__"


@interface MDDWebView () <UIWebViewDelegate>
{
    MessageInterceptor *interceptor;
    WebViewJavascriptBridge *jsBridge;
    
    MDDWebViewResponder *responder;
}

@end

@implementation MDDWebView


- (id)init
{
    self = [super init];
    if (self) {
        [self config];
    }
    
    return self;
}

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        [self config];
    }

    return self;
}

- (void)awakeFromNib
{
    [self config];
}

- (void)config
{
    if (!jsBridge) {
       jsBridge = [[WebViewJavascriptBridge alloc] initBridgeForWebView:self defaultHandler:^(id data, BridgeResponseCallback responseCallback) {
           NSLog(@"%@",data);
//           responseCallback(@{@"result":@"app",@"msg":@"hello wrold"});
           
           [[MDDWebViewResponder instance] invoked:data callback:responseCallback];
           
       }];
    }
    
    if (!interceptor) {
        interceptor = [[MessageInterceptor alloc]init];
        interceptor.middleMan = self;
        interceptor.receiver = self.delegate;
        super.delegate = (id)interceptor;
    }
    
    responder = [MDDWebViewResponder instance];
}

- (void)setDelegate:(id<UIWebViewDelegate>)delegate
{
    interceptor.receiver = delegate;
    super.delegate = (id)interceptor;
}

- (void)registerHandler:(NSString*)name handler:(void (^)(id data,MDDCallback cb))handler
{
    [jsBridge registerHandler:name handler:^(id data, BridgeResponseCallback responseCallback) {
        handler(data,responseCallback);
    }];
}

- (void)send:(id)data withHandler:(NSString *)handler withResponse:(void (^)(id))response
{
    [jsBridge callHandler:handler data:data responseCallback:^(id responseData) {
        response(responseData);
    }];
}

- (void)send:(id)data withResponse:(void (^)(id))response
{
    [self send:data withHandler:nil withResponse:^(id data) {
        response(data);
    }];
}

#pragma mark -
#pragma mark - UIWebViewDelegate

- (BOOL)webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{
    NSLog(@"request: %@",request.URL);
    [jsBridge parseWithRequest:request];
    if ([interceptor.receiver respondsToSelector:@selector(webView:shouldStartLoadWithRequest:navigationType:)]) {
        [interceptor.receiver webView:webView shouldStartLoadWithRequest:request navigationType:navigationType];
    }
    
    return YES;
}

- (void)webViewDidStartLoad:(UIWebView *)webView
{
    if ([interceptor.receiver respondsToSelector:@selector(webViewDidStartLoad:)]) {
        [interceptor.receiver webViewDidStartLoad:webView];
    }
}

- (void)webViewDidFinishLoad:(UIWebView *)webView
{
    NSLog(@"webViewDidFinishLoad");
    
    [jsBridge loadJS];

    if ([interceptor.receiver respondsToSelector:@selector(webViewDidFinishLoad:)]) {
        [interceptor.receiver webViewDidFinishLoad:webView];
    }
}

- (void)webView:(UIWebView *)webView didFailLoadWithError:(NSError *)error
{
    if ([interceptor.receiver respondsToSelector:@selector(webView:didFailLoadWithError:)]) {
        [interceptor.receiver webView:webView didFailLoadWithError:error];
    }
}

@end
