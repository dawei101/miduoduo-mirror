//
//  DropDownListView.h
//  SearchBarDemo
//
//  Created by mac273 on 15/1/31.
//  Copyright (c) 2015年 mac273. All rights reserved.
//

#import <UIKit/UIKit.h>

@protocol DropDownListViewDataSource <NSObject>

- (NSInteger)numberOfRowsAtDropDownListView:(UIView *)view;

- (void)dropDownListView:(UIView *)view cell:(UITableViewCell *)cell IndexPath:(NSIndexPath *)indexPath;

@end

@protocol DropDownListViewDelegate <NSObject>

- (void)dropDownListView:(UIView *)view didSelectRowAtIndexPath:(NSIndexPath *)indexPath;

- (BOOL)dropDownListVIew:(UIView *)view searchBarBeginEditing:(UISearchBar *)searchBar;
- (BOOL)dropDownListVIew:(UIView *)view searchBarEndEditing:(UISearchBar *)searchBar;
- (BOOL)dropDownListVIew:(UIView *)view searchBar:(UISearchBar *)searchBar shouldChangeTextInRange:(NSRange)range replacementText:(NSString *)text;

- (void)dropDownListVIew:(UIView *)view searchBarCancelButtonClicked:(UISearchBar *)searchBar;
- (void)dropDownListVIew:(UIView *)view searchBarSearchButtonClicked:(UISearchBar *)searchBar;

@end

@interface DropDownListView : UIView <UITableViewDelegate,UITableViewDataSource,UISearchBarDelegate>


@property (nonatomic, retain)   NSString    *cellName;
@property (nonatomic, retain) IBOutlet  UISearchBar     *searchBar;

@property (nonatomic, assign)   id<DropDownListViewDataSource> dataSource;
@property (nonatomic, assign)   id<DropDownListViewDelegate>    delegate;

- (void)reloadDropDownListView;

@end
