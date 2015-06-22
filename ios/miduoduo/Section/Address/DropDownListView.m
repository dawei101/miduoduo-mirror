//
//  DropDownListView.m
//  SearchBarDemo
//
//  Created by mac273 on 15/1/31.
//  Copyright (c) 2015年 mac273. All rights reserved.
//

#import "DropDownListView.h"

@interface DropDownListView() 
{
    UITableView *dropTable;
    NSString    *cellIdentifier;
    NSString    *_cellName;
    
    CGRect      originFrame;
}

@end

@implementation DropDownListView

- (id)initWithFrame:(CGRect)frame {
    self = [super initWithFrame:frame];
    if (self) {
        [self config];
        
        [self addSubview:dropTable];
    }
    
    return self;
}

- (id)init {
    self = [super init];
    if (self) {
        [self config];
    }
    
    return self;
}

- (void)awakeFromNib {
    [self config];
}

- (void)config {
    cellIdentifier = @"DropDownListCell";
    dropTable = [[UITableView alloc]initWithFrame:self.bounds];
    dropTable.dataSource = self;
    dropTable.delegate = self;
    
    [self addSubview:dropTable];
    
    originFrame = self.frame;
    self.hidden = YES;
    
    if (self.searchBar) {
        self.searchBar.delegate = self;
    }
}

- (void)setSearchBar:(UISearchBar *)searchBar {
    _searchBar = searchBar;
    _searchBar.delegate = self;
    
}

- (void)setCellName:(NSString *)cellName {
    
    _cellName = cellName;
    [dropTable registerClass:[NSClassFromString(cellName) class] forCellReuseIdentifier:cellIdentifier];
}

- (NSString *)cellName {
    if (_cellName == nil) {
        return @"UITableViewCell";
    }
    
    return _cellName;
}

- (void)reloadDropDownListView {
    [dropTable reloadData];
}
#pragma mark -- UITableViewDataSource
- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    NSInteger rows = 0;
    if ([self.dataSource respondsToSelector:@selector(numberOfRowsAtDropDownListView:)]) {
        rows = [self.dataSource numberOfRowsAtDropDownListView:self];
    }
    
    return rows;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath {
    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:cellIdentifier];
    if (cell == nil) {

        cell = [[NSClassFromString(self.cellName) alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:cellIdentifier];
    }
    
    if ([self.dataSource respondsToSelector:@selector(dropDownListView:cell:IndexPath:)]) {
        [self.dataSource dropDownListView:self cell:cell IndexPath:indexPath];
    }
    
    return cell;
}

#pragma mark -- UITableViewDelegate
- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath {
    
    if ([self.delegate respondsToSelector:@selector(dropDownListView:didSelectRowAtIndexPath:)]) {
        [self.delegate dropDownListView:self didSelectRowAtIndexPath:indexPath];
    }
}

#pragma mark -- 显示下拉框
- (void)showDropDownListView {
    self.hidden = NO;
}

#pragma mark -- 隐藏下拉框
- (void)hiddenDropDowmListView {
    self.hidden = YES;
}

#pragma mark -- UISearchBarDelegate
- (BOOL)searchBarShouldBeginEditing:(UISearchBar *)searchBar {
    BOOL ret = YES;
    
    searchBar.showsCancelButton = YES;
    [self showDropDownListView];
    if ([self.delegate respondsToSelector:@selector(dropDownListVIew:searchBarBeginEditing:)]) {
        ret = [self.delegate dropDownListVIew:self searchBarBeginEditing:searchBar];
    }
    
    return ret;
}

- (BOOL)searchBarShouldEndEditing:(UISearchBar *)searchBar {
    BOOL ret = YES;
    
    searchBar.showsCancelButton = NO;
    [searchBar resignFirstResponder];
    [self hiddenDropDowmListView];
    if ([self.delegate respondsToSelector:@selector(dropDownListVIew:searchBarEndEditing:)]) {
        ret = [self.delegate dropDownListVIew:self searchBarEndEditing:searchBar];
    }
    
    return ret;
}

- (void)searchBar:(UISearchBar *)searchBar textDidChange:(NSString *)searchText
{
    BOOL ret = YES;
    
    if ([self.delegate respondsToSelector:@selector(dropDownListVIew:searchBar:shouldChangeTextInRange:replacementText:)]) {
        NSRange range = NSMakeRange(0, 0);
        ret = [self.delegate dropDownListVIew:self searchBar:searchBar shouldChangeTextInRange:range replacementText:@""];
    }
}

- (BOOL)searchBar:(UISearchBar *)searchBar shouldChangeTextInRange:(NSRange)range replacementText:(NSString *)text {

    BOOL ret = YES;
    
    if ([self.delegate respondsToSelector:@selector(dropDownListVIew:searchBar:shouldChangeTextInRange:replacementText:)]) {
        ret = [self.delegate dropDownListVIew:self searchBar:searchBar shouldChangeTextInRange:range replacementText:text];
    }
    
    return ret;
}

- (void)searchBarCancelButtonClicked:(UISearchBar *)searchBar {
    [searchBar resignFirstResponder];
    [self hiddenDropDowmListView];
    if ([self.delegate respondsToSelector:@selector(dropDownListVIew:searchBarCancelButtonClicked:)]) {
        [self.delegate dropDownListVIew:self searchBarCancelButtonClicked:searchBar];
    }
}

- (void)searchBarSearchButtonClicked:(UISearchBar *)searchBar {
    
    [searchBar resignFirstResponder];
    [self hiddenDropDowmListView];
    if ([self.delegate respondsToSelector:@selector(dropDownListVIew:searchBarSearchButtonClicked:)]) {
        [self.delegate dropDownListVIew:self searchBarSearchButtonClicked:searchBar];
    }
}

@end
