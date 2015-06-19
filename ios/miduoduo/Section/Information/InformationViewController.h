//
//  InformationViewController.h
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "MDDViewController.h"

@interface InformationRecord : NSObject

@property (nonatomic, strong)   id          userInfo;

@property (nonatomic, strong)   NSString    *title;
@property (nonatomic, strong)   id          content;

@property (nonatomic, strong)   NSString    *clsName;
@property (nonatomic, strong)   id          hintObject;


@end

@interface InformationViewController : MDDViewController

@end
