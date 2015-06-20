//
//  NSUserDefaults+Convenient.h
//  miduoduo
//
//  Created by chongdd on 15/6/16.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface NSUserDefaults (Convenient)


+ (BOOL)isFirstRun;
+ (BOOL)isFirstRun:(BOOL)run;


+ (NSString *)version;
+ (BOOL)version:(NSString *)version;

@end
