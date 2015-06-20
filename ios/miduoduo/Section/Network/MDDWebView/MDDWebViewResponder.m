//
//  MDDWebViewResponder.m
//  miduoduo
//
//  Created by chongdd on 15/6/15.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MDDWebViewResponder.h"
#import "MDDWebViewModel.h"
#import "UIUtils.h"
#import "AddressController.h"
#import "PushController.h"

@interface MDDWebViewResponder () <UIAlertViewDelegate>

@end

@implementation MDDWebViewResponder

DEF_SINGLETON(instance)


- (void)invoked:(NSDictionary *)json callback:(BridgeResponseCallback) callback
{
    MDDWebViewModel *webModel = [[MDDWebViewModel alloc]init];
    
    webModel.action = [[json valueForKey:@"action"] integerValue];
    webModel.callback = callback;
    id data = [json valueForKey:@"data"];
    
    UIViewController *activityController = [[UIApplication sharedApplication]activeViewController];
    if (webModel.action == 3) {
        MDDAlertModel *model = [[MDDAlertModel alloc]initWithDictionary:data];
        if (!model) {
            return;
        }
        
        if (model.type == 1) {
            [UIUtils hiddenAlertView:activityController.view];
        } else if (model.type == 2) {
            [UIUtils showRefreshView:activityController.view text:[data valueForKey:@"message"]];
        } else if (model.type == 5) {
            UIViewController *activity = [UIUtils activityViewController];
            [UIUtils showAlertView:activity.view text:model.message delay:model.delay];
        } else {
            UIAlertView *alertView = [[UIAlertView alloc]initWithTitle:model.title message:model.message delegate:self cancelButtonTitle:model.cancel otherButtonTitles:model.ok, nil];
            webModel.data = model;
            alertView.userInfo = webModel;
            [alertView show];
        }

    } else if (webModel.action == 5) {
        PushController *pushController = [[PushController alloc]init];
        pushController.title = [data valueForKey:@"title"];
        pushController.url = [data valueForKey:@"url"];
        pushController.params = [data valueForKey:@"params"];
        pushController.userInfo = webModel;
        activityController.navigationController.navigationBarHidden = ![[data valueForKey:@"nvshow"] boolValue];
        [activityController.navigationController pushViewController:pushController animated:YES];
    } else if (webModel.action == 6) {
        BOOL nvshow = [[data valueForKey:@"nvshow"] boolValue];
        activityController.navigationController.navigationBarHidden = !nvshow;
        [activityController.navigationController popViewControllerAnimated:YES];
    }  else if (webModel.action == 8) {
        
        MDDAddressModel *model = [[MDDAddressModel alloc]initWithDictionary:data];
        AddressController *addressController = [[AddressController alloc]init];
        addressController.location = (CLLocationCoordinate2D){model.latitude,model.longitude};
        addressController.locationCity = model.city;
        addressController.title = model.title;
        addressController.back = ^(BMKPoiInfo *info) {
            NSDictionary *addr = @{@"name":info.name,
                                   @"address":info.address,
                                   @"city":info.city,
                                   @"latitude":@(info.pt.latitude),
                                   @"longitude":@(info.pt.longitude)};
            webModel.callback(addr);
            
            [activityController.navigationController popViewControllerAnimated:YES];
        };
        
        

        [activityController.navigationController pushViewController:addressController animated:YES];
    }
}


- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex
{
    MDDWebViewModel *webModel = alertView.userInfo;

    webModel.callback(@{@"action": @(webModel.action), @"result": @(buttonIndex)});
}

@end
