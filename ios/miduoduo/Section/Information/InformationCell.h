//
//  InformationCell.h
//  miduoduo
//
//  Created by chongdd on 15/6/12.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface InformationCell : UITableViewCell

@property (weak, nonatomic) IBOutlet UILabel *titleLabel;

@property (weak, nonatomic) IBOutlet UILabel *hintLabel;

@property (weak, nonatomic) IBOutlet UIImageView *headPicture;


@property (weak, nonatomic) IBOutlet UIImageView *indicateImageView;

@end
