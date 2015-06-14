//
//  UserModel.h
//  miduoduo
//
//  Created by chongdd on 15/5/29.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "JSONModel.h"

@interface UserModel : JSONModel


@property (nonatomic) NSString * auth_key;
@property (nonatomic) NSString * created_time;
@property (nonatomic) NSString * email;
@property (nonatomic) int id;
@property (nonatomic) NSString * name;
@property (nonatomic) NSString * password_hash;
@property (nonatomic) NSString * password_reset_token;
@property (nonatomic) int status;
@property (nonatomic) NSString * updated_time;
@property (nonatomic) NSString * username;

@end
