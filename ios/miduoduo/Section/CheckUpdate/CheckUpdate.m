//
//  CheckUpdate.m
//  miduoduo
//
//  Created by chongdd on 15/6/17.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "CheckUpdate.h"
#import "NetworkDefine.h"

@implementation CheckUpdateInfo



@end

@implementation CheckUpdate

DEF_SINGLETON(instance)

- (void)checkUpdate:(SuccessBlock)success error:(ErrorBlock)error
{
    
    AFHTTPRequestSerializer *requestSerializer = [AFHTTPRequestSerializer serializer];
    [requestSerializer setValue:@"application/json" forHTTPHeaderField:@"Accept"];
    [requestSerializer setValue:@"application/json" forHTTPHeaderField:@"Content-Type"];
    
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    manager.requestSerializer = requestSerializer;
    
    [manager POST:CheckUpdateUrl parameters:nil success:^(AFHTTPRequestOperation *operation, id responseObject) {
        if (responseObject) {
            self.info = [[CheckUpdateInfo alloc]initWithDictionary:responseObject];
            if (![self.info.version isEmpty]) {
                success(self.info);
                return ;
            }
        }
        
        error(nil,nil);
    } failure:^(AFHTTPRequestOperation *operation, NSError *err) {
        error(err,nil);
    }];
    
}


@end
