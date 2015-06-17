//
//  UIView+Frame.m
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "UIView+Frame.h"

@implementation UIView (Frame)

- (CGFloat)x {
    return self.frame.origin.x;
}

- (CGFloat)y {
    return self.frame.origin.y;
}

- (CGFloat)width {
    return self.frame.size.width;
}

- (CGFloat)height {
    return self.frame.size.height;
}

- (CGFloat)maxX {
    return self.frame.origin.x + self.frame.size.width;
}

- (CGFloat)maxY {
    return self.frame.origin.y + self.frame.size.height;
}

- (void)setX:(CGFloat)x {
    CGRect frame = self.frame;
    frame.origin.x = x;
    self.frame = frame;
}

- (void)setY:(CGFloat)y {
    CGRect frame = self.frame;
    frame.origin.y = y;
    self.frame = frame;
}

- (void)setWidth:(CGFloat)width {
    CGRect frame = self.frame;
    frame.size.width = width;
    self.frame = frame;
}

- (void)setHeight:(CGFloat)height {
    CGRect frame = self.frame;
    frame.size.height = height;
    self.frame = frame;
}

- (void)offsetX:(CGFloat)x {
    CGRect frame = self.frame;
    frame.origin.x += x;
    self.frame = frame;
}

- (void)offsetY:(CGFloat)y {
    CGRect frame = self.frame;
    frame.origin.y += y;
    self.frame = frame;
}

- (void)offsetWidth:(CGFloat)width {
    CGRect frame = self.frame;
    frame.size.width += width;
    self.frame = frame;
}

- (void)offsetHeight:(CGFloat)height {
    CGRect frame = self.frame;
    frame.size.height += height;
    self.frame = frame;
}


@end
