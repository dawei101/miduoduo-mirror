//
//  MDDModel.m
//  miduoduo
//
//  Created by chongdd on 15/6/9.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MDDModel.h"
#import <objc/runtime.h>
#import <objc/NSObject.h>

static const char * kClassPropertiesKey = "key";

@interface MDDModelClassProperty ()

@property (nonatomic, copy)   NSString *name;
@property (nonatomic, copy)   NSString *type;
@property (nonatomic, copy)   NSString *protocolName;

@end

@implementation MDDModelClassProperty


@end

@implementation MDDModel

- (id)init {
    self = [super init];
    
    if (self) {
        
        [self __inspectProperties];
    }
    
    return self;
}

- (void)__inspectProperties
{
    
    if (objc_getAssociatedObject(self.class, kClassPropertiesKey)) {
        // 已经初始化过
        return;
    }
    
    NSMutableDictionary *ppDictionary = [[NSMutableDictionary alloc] init];
    
    
    unsigned int i = 0;
    unsigned int nProperty = 0;
    objc_property_t *properties = class_copyPropertyList(self.class, &nProperty);
    for (; i < nProperty; i++) {
        objc_property_t p = properties[i];
        const char *s_name = property_getName(p);
        if (strcmp(s_name, "debugDescription") == 0 ||
            //strcmp(s_name, "description") == 0 ||
            strcmp(s_name, "hash") == 0 ||
            strcmp(s_name, "superclass") == 0) {
            // iOS8.0+
            continue;
        }
        
        NSString *propertyType = @(property_getAttributes(p));
        
        NSArray *attributeItems = [propertyType componentsSeparatedByString:@","];
        
        NSScanner *scanner = [NSScanner scannerWithString:attributeItems[0]];
        [scanner scanUpToString:@"T" intoString: nil];
        [scanner scanString:@"T" intoString:nil];
        
        MDDModelClassProperty *clsProperty = [MDDModelClassProperty new];
        
        NSString *type = nil;
        NSString *protocolName= nil;
        if ([scanner scanString:@"@\"" intoString:nil]) {
            [scanner scanUpToCharactersFromSet:[NSCharacterSet characterSetWithCharactersInString:@"\"<"] intoString:&type];
            if ([scanner scanString:@"<" intoString:nil]) {
                [scanner scanUpToString:@">" intoString:&protocolName];
            }
            
        } else {
            [scanner scanUpToString:@"," intoString:&type];
        }
        
        clsProperty.name = @(s_name);
        clsProperty.type = type;
        clsProperty.protocolName = protocolName;
        
        [ppDictionary setObject:clsProperty forKey:@(s_name)];
    }
    
    objc_setAssociatedObject(self.class, kClassPropertiesKey, ppDictionary, OBJC_ASSOCIATION_COPY_NONATOMIC);
}


- (id)initWithDictionary:(NSDictionary *)data
{
    [self __inspectProperties];

    NSDictionary *clsPropertyDic = objc_getAssociatedObject(self.class, kClassPropertiesKey);
    NSArray *allKeys = [clsPropertyDic allKeys];
    
    for (NSString *key in allKeys) {
        MDDModelClassProperty *clsProperty = [clsPropertyDic objectForKey:key];
        if (clsProperty.protocolName) {
            NSArray *itemsData = [data objectForKey:key];
            
            if (itemsData == nil || itemsData.count == 0) {
                continue;
            }
            
            NSMutableArray *items = [[NSMutableArray alloc]initWithCapacity:itemsData.count];
            
            Class cls = NSClassFromString(clsProperty.protocolName);
            for (NSDictionary *item in itemsData) {
                id obj = [[cls alloc]initWithDictionary:item];
                [items addObject:obj];
            }
            
            [self setValue:items forKey:key];
            
        } else if([NSClassFromString(clsProperty.type) isSubclassOfClass:[MDDModel class]]) {
            Class cls = NSClassFromString(clsProperty.type);
            id item = [data valueForKey:key];
            if (item == nil) {
                continue;
            }
            
            id obj = [[cls alloc]initWithDictionary:item];
            [self setValue:obj forKey:key];
        } else {
            id obj = [data valueForKey:key];
            if (obj != nil) {
                [self setValue:obj forKey:key];
            }
            
        }
    }
    
    return self;
}

- (id)initWithString:(NSString *)json
{
    self = [self init];
    
    NSError *error;
    NSData *data = [json dataUsingEncoding:NSUTF8StringEncoding];
    id obj = [NSJSONSerialization JSONObjectWithData:data options:NSJSONReadingMutableContainers error:&error];
    
    if (data) {
        return [self initWithDictionary:obj];
    } else {
        return nil;
    }
    
    return self;
}

- (NSDictionary *)toDictionary
{
    [self __inspectProperties];
    
    NSDictionary *clsPropertyDic = objc_getAssociatedObject(self.class, kClassPropertiesKey);
    NSArray *allKeys = [clsPropertyDic allKeys];
    NSMutableDictionary *result = [[NSMutableDictionary alloc]initWithCapacity:allKeys.count];
    
    for (NSString *key in allKeys) {
        MDDModelClassProperty *clsProperty = [clsPropertyDic objectForKey:key];
        if (clsProperty.protocolName) {
            NSArray *itemsData = [self valueForKey:key];
            
            if (itemsData == nil || itemsData.count == 0) {
                continue;
            }
            
            NSMutableArray *items = [[NSMutableArray alloc]initWithCapacity:itemsData.count];
            
            for (id item in itemsData) {
                id obj = [item toDictionary];
                [items addObject:obj];
            }
            
            [result setValue:items forKey:key];
            
        } else if([NSClassFromString(clsProperty.type) isSubclassOfClass:[MDDModel class]]) {

            id item = [self valueForKey:key];
            if (item == nil) {
                continue;
            }
            
            NSDictionary *temp = [item toDictionary];
            
            [result setValue:temp forKey:key];
            
        } else {
            id obj = [self valueForKey:key];
            if (obj != nil) {
                [result setValue:obj forKey:key];
            }
            
        }
    }
    
    return result;
}

- (NSString *)toJsonString
{
    NSDictionary *dict = [self toDictionary];
    NSData *data = [NSJSONSerialization dataWithJSONObject:dict options:0 error:nil];
    NSString *jsonStr = [[NSString alloc]initWithData:data encoding:NSUTF8StringEncoding];
    
    return jsonStr;
}

+ (NSMutableArray *)arrayOfModelsFromJson:(NSString *)json
{
    NSError *error;
    NSData *data = [json dataUsingEncoding:NSUTF8StringEncoding];
    NSArray *objectList = [NSJSONSerialization JSONObjectWithData:data options:NSJSONReadingMutableContainers error:&error];
    
    if ([objectList isKindOfClass:[NSArray class]]) {
        NSMutableArray *result = [[NSMutableArray alloc]initWithCapacity:objectList.count];
        for (NSDictionary *object in objectList) {
            id item = [[self alloc]initWithDictionary:object];
            [result addObject:item];
        }
        return result;
    }
    
    return nil;
}

+ (NSMutableArray *)arrayOfDictionariesFromModels:(NSArray *)models
{
    
    NSMutableArray *result = [[NSMutableArray alloc]initWithCapacity:models.count];
    for (id object in models) {
        if ([[object class] isSubclassOfClass:[MDDModel class]]) {
            [result addObject:[object toDictionary]];
        }
    }
    
    return  result;
}

+ (NSString *)jsonFromModels:(NSArray *)models
{
    NSMutableArray *objects = [self arrayOfDictionariesFromModels:models];
    
    NSData *data = [NSJSONSerialization dataWithJSONObject:objects options:0 error:nil];
    NSString *jsonStr = [[NSString alloc]initWithData:data encoding:NSUTF8StringEncoding];
    
    return jsonStr;
}

@end
