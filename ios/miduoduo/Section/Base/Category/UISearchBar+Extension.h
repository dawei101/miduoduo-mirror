//
//  UISearchBar+Extension.h
//  SearchBarDemo
//
//  Created by mac273 on 15/1/30.
//  Copyright (c) 2015年 mac273. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface UISearchBar (Extension) <UITextFieldDelegate>


@property (nonatomic, copy) NSString   *cancelButtonTitle;
@property (nonatomic, copy) UIColor     *cancelButtonTitleColor;

@property (nonatomic, retain) UIButton      *cancelButton;

@end
