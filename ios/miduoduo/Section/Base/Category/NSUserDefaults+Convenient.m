//
//  NSUserDefaults+Convenient.m
//  miduoduo
//
//  Created by chongdd on 15/6/16.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "NSUserDefaults+Convenient.h"

@implementation NSUserDefaults (Convenient)


+ (BOOL)isFirstRun
{
    return ![[NSUserDefaults standardUserDefaults] boolForKey:@"user_key_is_first_run"];
}

+ (BOOL)isFirstRun:(BOOL)run
{
    [[NSUserDefaults standardUserDefaults] setValue:@(!run) forKey:@"user_key_is_first_run"];
    return [[NSUserDefaults standardUserDefaults] synchronize];
}


+ (NSString *)version
{
    NSString *text = [[NSUserDefaults standardUserDefaults] stringForKey:@"user_key_version"];
    if (text == nil) {
        [self version:@"v1"];
        return @"v1";
    }
    
    return text;
}

+ (BOOL)version:(NSString *)version
{
    [[NSUserDefaults standardUserDefaults] setValue:version forKey:@"user_key_version"];
    return [[NSUserDefaults standardUserDefaults] synchronize];
}


@end
