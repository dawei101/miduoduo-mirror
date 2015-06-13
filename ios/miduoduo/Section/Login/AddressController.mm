//
//  AddressController.m
//  miduoduo
//
//  Created by chongdd on 15/6/13.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "AddressController.h"
#import <BaiduMapAPI/BMapKit.h>
#import <CoreGraphics/CoreGraphics.h>
#import <CoreLocation/CoreLocation.h>
#import "DropDownListView.h"
#import "UISearchBar+Extension.h"

@interface AddressController () <BMKPoiSearchDelegate,BMKMapViewDelegate,BMKGeoCodeSearchDelegate
                                    ,UITableViewDataSource,UITableViewDelegate
                                    ,DropDownListViewDataSource,DropDownListViewDelegate>
{
    BMKPoiSearch  *_poisearch;
    BMKGeoCodeSearch *_geocodesearch;
    UIImageView     *indicatorView;
    
    NSMutableArray *dataSource;
    NSMutableArray *dropDataSource;
    
    BOOL            isThinkPoi;
    
}

@property (weak, nonatomic) IBOutlet UISearchBar *searchBar;
@property (weak, nonatomic) IBOutlet BMKMapView *mapView;
@property (weak, nonatomic) IBOutlet UITableView *tableView;
@property (weak, nonatomic) IBOutlet DropDownListView *dropView;

@end

@implementation AddressController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    [self initView];
    
    
    // 设置地图级别
    [_mapView setZoomLevel:13];
    _mapView.isSelectedAnnotationViewFront = NO;
    [_mapView setCenterCoordinate:self.location];
    _geocodesearch = [[BMKGeoCodeSearch alloc]init];
    _poisearch = [[BMKPoiSearch alloc]init];
    [self geocodesearch:self.location];
}

- (void)initView
{
    
    self.view.backgroundColor = COLOR_DEFAULT_BG;
    indicatorView = [[UIImageView alloc]initWithFrame:CGRectMake(100, 100, 20, 20)];
    indicatorView.image = [UIImage imageNamed:@"pin_red.png"];
    CGPoint center = _mapView.center;
    center.y -= 10;
    indicatorView.center = center;
    [self.view addSubview:indicatorView];
    dataSource = [[NSMutableArray alloc]init];
    dropDataSource = [[NSMutableArray alloc]init];
    
    _dropView.dataSource = self;
    _dropView.delegate = self;
    //    self.searchBar.showsCancelButton = YES;
    _searchBar.cancelButtonTitle = @"取消";
    _searchBar.placeholder = @"请输入搜索内容";
    _searchBar.backgroundImage = [UIImage new];
    _searchBar.backgroundColor = [UIColor whiteColor];
}

- (CLLocationCoordinate2D)location
{
    if (_location.latitude == 0 && _location.longitude == 0) {
        return CLLocationCoordinate2D{39.927321,116.434821};
    }
   
    return _location;
}

- (NSString *)locationCity
{
    if (_locationCity == nil) {
        _locationCity = @"北京";
    }
    
    return _locationCity;
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

-(void)viewWillAppear:(BOOL)animated {
    [_mapView viewWillAppear];
    _mapView.delegate = self; // 此处记得不用的时候需要置nil，否则影响内存的释放
    _poisearch.delegate = self; // 此处记得不用的时候需要置nil，否则影响内存的释放
    _geocodesearch.delegate = self;
    [self.view bringSubviewToFront:_dropView];
}

-(void)viewWillDisappear:(BOOL)animated {
    [_mapView viewWillDisappear];
    _mapView.delegate = nil; // 不用时，置nil
    _poisearch.delegate = nil; // 不用时，置nil
    _geocodesearch.delegate = nil; // 不用时，置nil
}

- (NSString *)LocationCoordinateString:(CLLocationCoordinate2D) location
{
    NSString *text = [NSString stringWithFormat:@"%f,%f",location.latitude,location.longitude];
    return text;
}

- (BOOL)geocodesearch:(CLLocationCoordinate2D)location
{
    BMKReverseGeoCodeOption *reverseGeocodeSearchOption = [[BMKReverseGeoCodeOption alloc]init];
    reverseGeocodeSearchOption.reverseGeoPoint = location;
    BOOL flag = [_geocodesearch reverseGeoCode:reverseGeocodeSearchOption];
    if(flag) {
        NSLog(@"反geo检索发送成功");
    } else {
        NSLog(@"反geo检索发送失败");
    }
    
    return flag;
}

- (BOOL)poiSearchWithKeyword:(NSString *)keyword
{
    BMKCitySearchOption *citySearchOption = [[BMKCitySearchOption alloc]init];
//    citySearchOption.pageCapacity = 10;
    citySearchOption.city= self.locationCity;
    citySearchOption.keyword = keyword;
    BOOL flag = [_poisearch poiSearchInCity:citySearchOption];
    if(flag)
    {
        NSLog(@"城市内检索发送成功");
    }
    else
    {
        NSLog(@"城市内检索发送失败");
    }
    
    return flag;
}

#pragma mark -
#pragma mark - BMKMapViewDelegate
- (void)mapView:(BMKMapView *)mapView regionDidChangeAnimated:(BOOL)animated
{
    [self geocodesearch:mapView.centerCoordinate];
}

- (void)mapView:(BMKMapView *)mapView regionWillChangeAnimated:(BOOL)animated
{
    // 清楚屏幕中所有的annotation
    NSArray* array = [NSArray arrayWithArray:_mapView.annotations];
    [_mapView removeAnnotations:array];
}

#pragma mark -
#pragma mark - BMKGeoCodeSearchDelegate
-(void) onGetReverseGeoCodeResult:(BMKGeoCodeSearch *)searcher result:(BMKReverseGeoCodeResult *)result errorCode:(BMKSearchErrorCode)error
{
    if (error == 0) {
        
        NSLog(@"%@,%@",result.address,[self LocationCoordinateString:result.location]);
        
        [dataSource removeAllObjects];
        [dataSource addObjectsFromArray:result.poiList];
        [_tableView reloadData];
    }
}

#pragma mark -
#pragma mark implement BMKSearchDelegate
- (void)onGetPoiResult:(BMKPoiSearch *)searcher result:(BMKPoiResult*)result errorCode:(BMKSearchErrorCode)error
{
    // 清楚屏幕中所有的annotation
    NSArray* array = [NSArray arrayWithArray:_mapView.annotations];
    [_mapView removeAnnotations:array];
    
    if (error == BMK_SEARCH_NO_ERROR) {
        if (isThinkPoi) {
            [dropDataSource removeAllObjects];
            [dropDataSource addObjectsFromArray:result.poiInfoList];
            [_dropView reloadDropDownListView];
        } else {
            for (int i = 0; i < result.poiInfoList.count; i++) {
                BMKPoiInfo* poi = [result.poiInfoList objectAtIndex:i];
                BMKPointAnnotation* item = [[BMKPointAnnotation alloc]init];
                item.coordinate = poi.pt;
                item.title = poi.name;
                [_mapView addAnnotation:item];
            }
        }

    } else if (error == BMK_SEARCH_AMBIGUOUS_ROURE_ADDR){
        NSLog(@"起始点有歧义");
    } else {
        // 各种情况的判断。。。
    }
}


#pragma mark -
#pragma mark - UITableViewDataSource
- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    return dataSource.count;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"cell"];
    if (!cell) {
        cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleSubtitle reuseIdentifier:@"cell"];
    }
    
    BMKPoiInfo *item = dataSource[indexPath.row];
    cell.textLabel.text = item.name;
    cell.detailTextLabel.text = item.address;
    
    return cell;
}

#pragma mark -
#pragma mark - UITableViewDelegate
- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{

}


#pragma mark -- DropDownListViewDataSource
- (NSInteger)numberOfRowsAtDropDownListView:(UIView *)view {
    
    return dropDataSource.count;
}

- (void)dropDownListView:(UIView *)view cell:(UITableViewCell *)cell IndexPath:(NSIndexPath *)indexPath {
    BMKPoiInfo *poiInfo = dropDataSource[indexPath.row];
    
    cell.textLabel.text = [NSString stringWithFormat:@"%@",poiInfo.name];
}

#pragma mark -- DropDownListViewDelegate

- (void)dropDownListView:(UIView *)view didSelectRowAtIndexPath:(NSIndexPath *)indexPath {
    NSLog(@"select: %li",indexPath.row);
    
    
    BMKPoiInfo *poiInfo = dropDataSource[indexPath.row];
    NSString *searchStr = poiInfo.name;
    isThinkPoi = NO;
    [self poiSearchWithKeyword:searchStr];
    [self endEditing:YES];
}

- (BOOL)dropDownListVIew:(UIView *)view searchBar:(UISearchBar *)searchBar shouldChangeTextInRange:(NSRange)range replacementText:(NSString *)text {
    
    NSString *searchStr = [NSString stringWithFormat:@"%@%@",searchBar.text,text];
    isThinkPoi = YES;
    [self poiSearchWithKeyword:searchStr];
    return YES;
}

- (void)dropDownListVIew:(UIView *)view searchBarSearchButtonClicked:(UISearchBar *)searchBar
{
    NSString *searchStr = searchBar.text;
    isThinkPoi = NO;
    [self poiSearchWithKeyword:searchStr];
}

- (BOOL)endEditing:(BOOL)force
{
    _searchBar.text = @"";
    [dropDataSource removeAllObjects];
    [_searchBar resignFirstResponder];
    return YES;
//    return [self.view endEditing:YES];
}

@end
