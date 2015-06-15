//
//  MDDWebViewResponder.h
//  miduoduo
//
//  Created by chongdd on 15/6/15.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "WebViewJavascriptBridge.h"

@interface MDDWebViewResponder : NSObject

AS_SINGLETON(instance)

- (void)invoked:(NSDictionary *)json callback:(BridgeResponseCallback) callback;

@end