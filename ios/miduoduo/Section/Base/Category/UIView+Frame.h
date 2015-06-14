//
//  UIView+Frame.h
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface UIView (Frame)

- (CGFloat)x;
- (CGFloat)y;

- (CGFloat)width;
- (CGFloat)height;


- (CGFloat)maxX;
- (CGFloat)maxY;

- (void)setX:(CGFloat)x;
- (void)setY:(CGFloat)y;
- (void)setWidth:(CGFloat)width;
- (void)setHeight:(CGFloat)height;

- (void)offsetX:(CGFloat)x;
- (void)offsetY:(CGFloat)y;
- (void)offsetWidth:(CGFloat)width;
- (void)offsetHeight:(CGFloat)height;



@end
