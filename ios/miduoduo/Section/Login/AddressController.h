//
//  AddressController.h
//  miduoduo
//
//  Created by chongdd on 15/6/13.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MDDViewController.h"
#import <CoreLocation/CLLocation.h>

@interface AddressController : MDDViewController

@property (nonatomic, assign)   CLLocationCoordinate2D location;
@property (nonatomic, retain)   NSString    *locationCity;
@end
