//
//  UISearchBar+Extension.m
//  SearchBarDemo
//
//  Created by mac273 on 15/1/30.
//  Copyright (c) 2015年 mac273. All rights reserved.
//

#import "UISearchBar+Extension.h"


@implementation UISearchBar (Extension)


- (void)drawRect:(CGRect)rect {
    [super drawRect:rect];
    UITextField *textField = [self searchBarTextField];
    if (textField) {
        CGRect frame = textField.frame;
//        if (self.showsCancelButton) {
//            frame.size.height = self.frame.size.height;
//        }
//        frame.size.width = textField.frame.size.width;
//        frame.origin.x = textField.frame.origin.x;
//        frame.origin.y = 0;
        textField.frame = frame;
        
        textField.layer.borderColor = [UIColor darkGrayColor].CGColor;
        textField.layer.borderWidth = 0.5;
        textField.layer.cornerRadius = textField.frame.size.height/2.0;
        
        [textField setValue:[UIColor darkTextColor] forKeyPath:@"_placeholderLabel.textColor"];
        
    }

    // 只有这样，backgroundColor 的设置有效
//    [self setBackgroundImage:[UIImage new]];
    
    UIButton *button = [self searchBarCancelButton];
    if (button) {
//        [button setTitle:@"select" forState:UIControlStateSelected];
//        [button setTitle:@"height" forState:UIControlStateHighlighted];
//        [button setTitle:@"normal" forState:UIControlStateNormal];
        
//        [button addObserver:self forKeyPath:@"titleLabel.textColor" options:NSKeyValueObservingOptionNew|NSKeyValueObservingOptionOld context:nil];
    }
    
    UIView *view = [self searchBarBackground];
    if (view) {
        view.backgroundColor = [UIColor clearColor];
    }
}


- (void)observeValueForKeyPath:(NSString *)keyPath ofObject:(id)object change:(NSDictionary *)change context:(void *)context {
//    NSLog(@"%@",change);
}

- (UITextField *)searchBarTextField {
    NSArray *views = self.subviews;
#if __IPHONE_OS_VERSION_MAX_ALLOWED > __IPHONE_6_1
    views = [[self contentView]subviews];
#endif
    
    for (id item in views) {
        if ([item isKindOfClass:[UITextField class]]) {
            return item;
        }
    }
    
    return nil;
}

- (UIView *)searchBarBackground {
    NSArray *views = self.subviews;
#if __IPHONE_OS_VERSION_MAX_ALLOWED > __IPHONE_6_1
    views = [[self contentView]subviews];
#endif
    
    for (id item in views) {
        if ([item isKindOfClass:[UIView class]]) {
            return item;
        }
    }
    
    return nil;
}

- (UIButton *)searchBarCancelButton {
    NSArray *views = self.subviews;
#if __IPHONE_OS_VERSION_MAX_ALLOWED > __IPHONE_6_1
    views = [[self contentView]subviews];
#endif
    
    for (id item in views) {
        if ([item isKindOfClass:[UIButton class]]) {
            return item;
        }
    }
    
    return nil;
}

- (UIView *)contentView
{
    if ([[[UIDevice currentDevice] systemVersion] floatValue] >= 7.0) {
        return self.subviews[0];
    } else {
        return self;
    }
}

- (UIButton *)cancelButton {
    return [self searchBarCancelButton];
}
- (void)setCancelButtonTitle:(NSString *)cancelButtonTitle {

    UIButton *cancel = [self searchBarCancelButton];
    [cancel setTitle:cancelButtonTitle forState:UIControlStateNormal];
}

- (void)setCancelButtonTitleColor:(UIColor *) cancelButtonTitleColor{
    UIButton   *button = [self searchBarCancelButton];
    if (button) {
        if (cancelButtonTitleColor == nil) {
            cancelButtonTitleColor = [UIColor darkTextColor];
        }
        
        [button setTitleColor:cancelButtonTitleColor forState:UIControlStateNormal];
//        [button setTitleColor:[UIColor redColor] forState:UIControlStateHighlighted];
    }
}



- (BOOL)textFieldShouldClear:(UITextField *)textField {
    return YES;
}

@end
