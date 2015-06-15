//
//  MDDWebViewModel.h
//  miduoduo
//
//  Created by chongdd on 15/6/17.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MDDModel.h"
#import "WebViewJavascriptBridge.h"



@interface MDDWebViewModel : MDDModel

@property (nonatomic, assign)   NSInteger action;
@property (nonatomic, strong)   id      data;

@property (nonatomic, strong)   BridgeResponseCallback   callback;

@end

@interface MDDAlertModel : MDDModel

@property (nonatomic, assign)   NSInteger    type;
@property (nonatomic, strong)   NSString    *title;
@property (nonatomic, strong)   NSString    *message;
@property (nonatomic, assign)   NSInteger   delay;

@property (nonatomic, strong)   NSString    *cancel;
@property (nonatomic, strong)   NSString    *ok;

@end

@interface MDDAddressModel : MDDModel

@property (nonatomic, retain)   NSString    *title;

@property (nonatomic, assign)   double latitude;
@property (nonatomic, assign)   double longitude;
@property (nonatomic, retain)   NSString    *city;


@end
