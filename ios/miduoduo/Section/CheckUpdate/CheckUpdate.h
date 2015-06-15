//
//  CheckUpdate.h
//  miduoduo
//
//  Created by chongdd on 15/6/17.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "MDDModel.h"

@interface CheckUpdateInfo : MDDModel

@property (nonatomic, strong)   NSString *msg;
@property (nonatomic, strong)   NSString *title;
@property (nonatomic, strong)   NSString *url;
@property (nonatomic, strong)   NSString *version;

@end

@interface CheckUpdate : NSObject

typedef void (^SuccessBlock)(CheckUpdateInfo *info);
typedef void (^ErrorBlock)(NSError *error,id data);

AS_SINGLETON(instance)


@property (nonatomic, strong)   CheckUpdateInfo *info;

- (void)checkUpdate:(SuccessBlock)success error:(ErrorBlock)error;


@end
