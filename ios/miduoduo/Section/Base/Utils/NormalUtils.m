//
//  NormalUtils.m
//  miduoduo
//
//  Created by chongdd on 15/6/10.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "NormalUtils.h"
#import "Reachability.h"

@implementation NormalUtils


+(BOOL)networkAvailable
{
    if ([[Reachability reachabilityForLocalWiFi] currentReachabilityStatus] != NotReachable) {
        return YES;
    }
    if ([[Reachability reachabilityForInternetConnection] currentReachabilityStatus] != NotReachable) {
        return YES;
    }
    return NO;
}


@end
