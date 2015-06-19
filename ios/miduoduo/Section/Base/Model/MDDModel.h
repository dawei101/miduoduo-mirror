//
//  MDDModel.h
//  miduoduo
//
//  Created by chongdd on 15/6/9.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface MDDModelClassProperty : NSObject 

@end

@interface MDDModel : NSObject

- (id)initWithDictionary:(NSDictionary *)data;

- (id)initWithString:(NSString *)json;

- (NSDictionary *)toDictionary;

- (NSString *)toJsonString;

+ (NSArray *)arrayOfModelsFromJson:(NSString *)json;

+ (NSMutableArray *)arrayOfDictionariesFromModels:(NSArray *)models;

+ (NSString *)jsonFromModels:(NSArray *)models;

@end
