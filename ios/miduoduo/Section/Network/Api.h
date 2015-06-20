//
//  Api.h
//  miduoduo
//
//  Created by chongdd on 15/6/10.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "NetworkDefine.h"

#import <Foundation/Foundation.h>

@interface Api : NSObject

AS_SINGLETON(instance)


- (void)requestWithApi:(NSString *)api
            parameters:(NSDictionary *)parameters
               success:(void (^)(AFHTTPRequestOperation *operation, id responseObject))success
               failure:(void (^)(AFHTTPRequestOperation *operation, NSError *error))failure;


@end
