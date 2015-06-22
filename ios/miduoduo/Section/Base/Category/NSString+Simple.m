//
//  NSString+Simple.m
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "NSString+Simple.h"

@implementation NSString (Simple)

- (BOOL)isEmpty {
    if (self == nil || [self isEqualToString:@""]) {
        return YES;
    }
    
    return NO;
}
@end
