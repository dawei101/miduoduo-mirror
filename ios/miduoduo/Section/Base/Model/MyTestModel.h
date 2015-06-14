//
//  MyTestModel.h
//  miduoduo
//
//  Created by chongdd on 15/6/9.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MDDModel.h"

@protocol ProductModel
@end

@protocol MyTestModel
@end

@interface MyTestModel : MDDModel

@property (assign, nonatomic) NSString *text;
@property (assign, nonatomic) int       id;
@property (assign, nonatomic) float     price;

@end



@interface ProductModel : MDDModel

@property (assign, nonatomic) NSString *code;
@property (strong, nonatomic) NSString *name;
@property (assign, nonatomic) NSString *addr;
@property (assign, nonatomic) NSString *col4;

@property (assign, nonatomic) NSString *ddd;

@property (strong, nonatomic) NSArray<MyTestModel>* myTestList;

@end



@interface OrderModel : MDDModel

@property (assign, nonatomic) int total;
@property (assign, nonatomic) NSString *msg;
@property (strong, nonatomic) NSArray<ProductModel>* address;

@property (strong, nonatomic) NSArray<ProductModel>* address33;
@property (strong, nonatomic) ProductModel *product;

@property (strong, nonatomic) MyTestModel *myTest;
@property (assign, nonatomic) int temp;

@property (strong, nonatomic) NSArray<MyTestModel>* myTestList;
@end