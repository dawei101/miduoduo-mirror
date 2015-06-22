//
//  UIColor+HexColor.h
//  Mom
//
//  Created by lver on 15-3-11.
//  Copyright (c) 2015年 273.cn. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface UIColor (HexColor)

/**
 * hex format:
 * 1. @"FFFFFF"
 * 2. @"0XFFFFFF"
 * 3. @"#FFFFFF"
 */
+ (UIColor *)colorFromHexString:(NSString *)hex;
/**
 * hex value:
 * - 0xFFFFFF
 */
+ (UIColor *)colorFromHexNumber:(unsigned int)hex;
/**
 * rgb value
 */
+ (UIColor *)colorFromR:(unsigned char)r G:(unsigned char)g B:(unsigned char)b;

@end
