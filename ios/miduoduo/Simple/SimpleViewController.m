//
//  SimpleViewController.m
//  TableViewDemo
//
//  Created by chongdd on 15/4/27.
//  Copyright (c) 2015年 mac273. All rights reserved.
//

#import "SimpleViewController.h"
#import "AFNetworking.h"
#import "UserModel.h"

#import "MyTestModel.h"

@interface SimpleViewController ()
{
    NSMutableArray  *dataSource;
    
}

@property (nonatomic, retain)   UITableView *tableView;


@end

@implementation SimpleViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    NSData *data = [NSData dataWithContentsOfURL:[NSURL URLWithString:@"http://192.168.1.217/json.php"]];
    
    NSString *jsonText = [[NSString alloc]initWithData:data encoding:NSUTF8StringEncoding];
    OrderModel *model = [[OrderModel alloc]initWithString:jsonText];
    NSString *json = [model toJsonString];
    

    data = [NSData dataWithContentsOfURL:[NSURL URLWithString:@"http://192.168.1.217/json_array.php"]];
    jsonText = [[NSString alloc]initWithData:data encoding:NSUTF8StringEncoding];
    NSArray *modelArray = [MyTestModel arrayOfModelsFromJson:jsonText];
    
    json = [MyTestModel jsonFromModels:modelArray];
    
    
    OrderModel *temp = [[OrderModel alloc]init];
    temp.total = 1234567;
    temp.msg  =@"hello json .....";
    ProductModel *product = [[ProductModel alloc]init];
    product.code = @"code_1";
    product.name = @"name_1";
    product.ddd  =@"ddd_1";
    temp.product = product;
    
    ProductModel *product2 = [[ProductModel alloc]init];
    product2.code = @"code_2";
    product2.name = @"name_2";
    product2.ddd  =@"ddd_2";
    
    ProductModel *product3 = [[ProductModel alloc]init];
    product3.code = @"code_3";
    product3.name = @"name_3";
    product3.ddd  =@"ddd_3";
    
    temp.address = @[product,product2,product3];
    
    NSDictionary *dic = [temp toDictionary];
    
    NSString *jsonStr = [temp toJsonString];
    
    
    NSString *url = @"http://api.chongdd.cn/v1/auth/vcode";
  
    AFHTTPRequestSerializer *requestSerializer = [AFHTTPRequestSerializer serializer];
    [requestSerializer setValue:@"application/json" forHTTPHeaderField:@"Accept"];
    [requestSerializer setValue:@"application/json" forHTTPHeaderField:@"Content-Type"];
//    [requestSerializer setValue:@"phonenum" forHTTPHeaderField:@"15101681550"];
//    [requestSerializer setAuthorizationHeaderFieldWithUsername:@"18661775819" password:@"61860533"];
//
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    manager.requestSerializer = requestSerializer;
    
    NSString *num = @"phonenum";
    NSString *phonenum = @"15101681550";
    [manager POST:url parameters:@{num:phonenum} constructingBodyWithBlock:^(id<AFMultipartFormData> formData) {
//        [formData appendPartWithFormData:[phonenum dataUsingEncoding:NSUTF8StringEncoding] name:num];
        
    } success:^(AFHTTPRequestOperation *operation, id responseObject) {
        
        NSLog(@"JSON: %@", responseObject);
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"Error: %@,statusCode: %i", error,operation.response.statusCode);
    }];
    


}


@end
