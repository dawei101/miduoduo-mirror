//
//  Api.m
//  miduoduo
//
//  Created by chongdd on 15/6/10.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "Api.h"
#import "NSUserDefaults+Convenient.h"


@interface Api ()
{
    
}

@end
@implementation Api

DEF_SINGLETON(instance)

- (id)init
{
    self = [super init];
    if (self) {
        
    }
    
    return self;
}

- (NSString *)url:(NSString *)api
{
    NSString *text = [NSString stringWithFormat:@"%@/%@/%@",BASE_URL,[NSUserDefaults version],api];
    
    return text;
}


- (void)requestWithApi:(NSString *)api
            parameters:(NSDictionary *)parameters
               success:(void (^)(AFHTTPRequestOperation *operation, id responseObject))success
               failure:(void (^)(AFHTTPRequestOperation *operation, NSError *error))failure
{
    AFHTTPRequestSerializer *requestSerializer = [AFHTTPRequestSerializer serializer];
    [requestSerializer setValue:@"application/json" forHTTPHeaderField:@"Accept"];
    [requestSerializer setValue:@"application/json" forHTTPHeaderField:@"Content-Type"];
    
    NSString *url = [self url:api];
    
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    manager.requestSerializer = requestSerializer;
    [manager POST:url parameters:parameters success:success failure:failure];
    
}


@end
