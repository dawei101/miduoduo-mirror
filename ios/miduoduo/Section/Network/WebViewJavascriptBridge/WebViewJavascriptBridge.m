//
//  WebViewJavascriptBridge.m
//  miduoduo
//
//  Created by chongdd on 15/6/13.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "WebViewJavascriptBridge.h"

@implementation WebViewJavascriptBridge
{
    UIWebView *_webView;
    NSMutableDictionary *_responseCallbackDic;
    NSMutableDictionary *_messageHandlerDic;
    long _uniqueId;
    
    BridgeHandler   defaultHandler;
}

#pragma mark - public
//初始化
- (id)initBridgeForWebView:(UIWebView *)webView defaultHandler:(BridgeHandler)handler
{
    self = [super init];
    if (self) {
        _webView = webView;
        _messageHandlerDic = [[NSMutableDictionary alloc] init];
        _responseCallbackDic = [[NSMutableDictionary alloc] init];
        _uniqueId = 0;
        
        defaultHandler = handler;
    }
    
    return self;
}

//注册oc方法，供js调用
- (void)registerHandler:(NSString *)handlerName handler:(BridgeHandler)handler
{
    [_messageHandlerDic setObject:handler forKey:handlerName];
}

//oc调用 js方法
- (void)callHandler:(NSString *)handlerName data:(id)data responseCallback:(BridgeResponseCallback)responseCallback
{
    NSMutableDictionary *message = [[NSMutableDictionary alloc] init];
    if (data) {
        [message setObject:data forKey:@"data"];
    }
    
    if (responseCallback) {
        NSString *callbackId = [NSString stringWithFormat:@"objc_cb_%ld", ++_uniqueId];
        [_responseCallbackDic setObject:responseCallback forKey:callbackId];
        [message setObject:callbackId forKey:@"callbackId"];
    }
    
    if (handlerName) {
        [message setObject:handlerName forKey:@"handlerName"];
    }
    
    [self queueMessage:message];
}

#pragma mark - private
//运行消息队列
- (void)queueMessage:(NSDictionary *)message
{
    //序列化JSON
    NSString *messageJSON = [self serializeMessage:message];
    
    messageJSON = [messageJSON stringByReplacingOccurrencesOfString:@"\\" withString:@"\\\\"];
    messageJSON = [messageJSON stringByReplacingOccurrencesOfString:@"\"" withString:@"\\\""];
    messageJSON = [messageJSON stringByReplacingOccurrencesOfString:@"\'" withString:@"\\\'"];
    messageJSON = [messageJSON stringByReplacingOccurrencesOfString:@"\n" withString:@"\\n"];
    messageJSON = [messageJSON stringByReplacingOccurrencesOfString:@"\r" withString:@"\\r"];
    messageJSON = [messageJSON stringByReplacingOccurrencesOfString:@"\f" withString:@"\\f"];
    
    NSString *javascriptCommand = [NSString stringWithFormat:@"WebViewJavascriptBridge._handleMessageFromNative('%@');", messageJSON];
    if ([[NSThread currentThread] isMainThread])
    {
        [_webView stringByEvaluatingJavaScriptFromString:javascriptCommand];
    }
}

//刷新消息队列
- (void)refreshMessageQueue
{
    NSString *messageQueueString = [_webView stringByEvaluatingJavaScriptFromString:@"WebViewJavascriptBridge._fetchQueue();"];
    
    //反序列化JSON
    id messages = [self deserializeMessageJSON:messageQueueString];
    if (![messages isKindOfClass:[NSArray class]])
    {
        return;
    }
    
    for (NSDictionary *message in messages)
    {
        if (![message isKindOfClass:[NSDictionary class]])
        {
            continue;
        }
        
        NSString *responseId = [message objectForKey:@"responseId"];
        if (responseId)
        {
            BridgeResponseCallback responseCallback = [_responseCallbackDic objectForKey:responseId];
            responseCallback([message objectForKey:@"responseData"]);
            [_responseCallbackDic removeObjectForKey:responseId];
        }
        else
        {
            BridgeResponseCallback responseCallback = NULL;
            NSString *callbackId = [message objectForKey:@"callbackId"];
            if (callbackId)
            {
                responseCallback = ^(id responseData)
                {
                    NSDictionary* msg = @{ @"responseId":callbackId, @"responseData":responseData };
                    [self queueMessage:msg];
                };
            }
            else
            {
                responseCallback = ^(id ignoreResponseData)
                {
                    // Do nothing
                };
            }
            
            BridgeHandler handler;
            if ([message objectForKey:@"handlerName"])
            {
                handler = [_messageHandlerDic objectForKey:[message objectForKey:@"handlerName"]];
                if (!handler) {
                    return responseCallback(@{});
                }
            }
            else
            {
                handler = defaultHandler;
            }
            
            @try
            {
                id data = [message objectForKey:@"data"];
                handler(data, responseCallback);
            }
            @catch (NSException *exception)
            {
                NSLog(@"WebViewJavascriptBridge: WARNING: objc handler threw. %@ %@", message, exception);
            }
        }
    }
}

//序列化JSON
- (NSString *)serializeMessage:(id)message
{
    return [[NSString alloc] initWithData:[NSJSONSerialization dataWithJSONObject:message options:0 error:nil] encoding:NSUTF8StringEncoding];
}

//反序列化JSON
- (NSArray *)deserializeMessageJSON:(NSString *)messageJSON
{
    return [NSJSONSerialization JSONObjectWithData:[messageJSON dataUsingEncoding:NSUTF8StringEncoding] options:NSJSONReadingAllowFragments error:nil];
}

#pragma mark - 
#pragma mark - 

- (void)loadJS
{
    if (![[_webView stringByEvaluatingJavaScriptFromString:@"typeof WebViewJavascriptBridge == 'object'"] isEqualToString:@"true"])
    {
        NSString *filePath = [[NSBundle mainBundle] pathForResource:@"WebViewJavascriptBridge" ofType:@"js"];
        NSString *js = [NSString stringWithContentsOfFile:filePath encoding:NSUTF8StringEncoding error:nil];
        [_webView stringByEvaluatingJavaScriptFromString:js];
    }
}

- (BOOL)parseWithRequest:(NSURLRequest *)request
{
    NSURL *url = [request URL];
    if ([[url scheme] isEqualToString:kCustomProtocolScheme])
    {
        if ([[url host] isEqualToString:kQueueHasMessage])
        {
            [self refreshMessageQueue];
        }
        else
        {
            NSLog(@"WebViewJavascriptBridge: WARNING: Received unknown WebViewJavascriptBridge command %@://%@", kCustomProtocolScheme, [url path]);
        }
        
        return NO;
    }
    else
    {
        return YES;
    }
}


@end
