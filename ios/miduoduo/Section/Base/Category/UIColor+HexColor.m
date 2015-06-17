//
//  UIColor+HexColor.m
//  Mom
//
//  Created by lver on 15-3-11.
//  Copyright (c) 2015年 273.cn. All rights reserved.
//

#import "UIColor+HexColor.h"

@implementation UIColor (HexColor)

+ (UIColor *)colorFromHexString:(NSString *)hex
{
    NSString *cString = [[hex stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]] uppercaseString];
    // String should be 6 or 8 characters
    
    if ([cString length] < 6) return [UIColor blackColor];
    // strip 0X if it appears
    if ([cString hasPrefix:@"0X"]) cString = [cString substringFromIndex:2];
    if ([cString hasPrefix:@"#"]) cString = [cString substringFromIndex:1];
    if ([cString length] != 6) return [UIColor blackColor];
    
    // Separate into r, g, b substrings
    
    NSRange range;
    range.location = 0;
    range.length = 2;
    NSString *rString = [cString substringWithRange:range];
    range.location = 2;
    NSString *gString = [cString substringWithRange:range];
    range.location = 4;
    NSString *bString = [cString substringWithRange:range];
    // Scan values
    unsigned int r, g, b;
    
    [[NSScanner scannerWithString:rString] scanHexInt:&r];
    [[NSScanner scannerWithString:gString] scanHexInt:&g];
    [[NSScanner scannerWithString:bString] scanHexInt:&b];
    
    return [self colorFromR:r G:g B:b];
}

+ (UIColor *)colorFromHexNumber:(unsigned int)hex
{
    /**
     * mac内存存储为小端：FFFFFF00 <-高位在后
     */
    unsigned char r, g, b;
    r = (hex & 0xFF0000) >> 16;
    g = (hex & 0x00FF00) >> 8;
    b = (hex & 0x0000FF);
    return [self colorFromR:r G:g B:b];
}

+ (UIColor *)colorFromR:(unsigned char)r G:(unsigned char)g B:(unsigned char)b
{
    return [UIColor colorWithRed:((float) r / 255.0f)
                           green:((float) g / 255.0f)
                            blue:((float) b / 255.0f)
                           alpha:1.0f];
}

@end
