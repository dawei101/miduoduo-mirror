//
//  InformationSegmentedCell.h
//  miduoduo
//
//  Created by chongdd on 15/6/12.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface InformationSegmentedCell : UITableViewCell

@property (weak, nonatomic) IBOutlet UILabel *titleLabel;


@property (weak, nonatomic) IBOutlet UISegmentedControl *segmentedCtl;

@end
