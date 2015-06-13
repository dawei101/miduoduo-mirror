//
//  InformationViewController.m
//  miduoduo
//
//  Created by chongdd on 15/6/11.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "InformationViewController.h"
#import "InformationCell.h"
#import "InformationInputCell.h"
#import "InformationSegmentedCell.h"

#import "AddressController.h"

#define UPLOAD_PHOTO        0
#define NAME                1
#define BIRTHDATE           2
#define SEX                 3

#define TYPE                0
#define SCHOOL              1
#define LIVE_ADDR           2



@implementation InformationRecord

@end

@interface InformationViewController () <UITableViewDataSource,UITableViewDelegate,UITextFieldDelegate,UIActionSheetDelegate,UIImagePickerControllerDelegate,UINavigationControllerDelegate>
{
    UITableView *_tableView;
    
    NSMutableArray  *dataSource;
    
    UITextField     *tempTextField;
}

@end

@implementation InformationViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
    self.title = @"填写基本资料";
    self.view.backgroundColor = COLOR_DEFAULT_BG;
    
    dataSource = [[NSMutableArray alloc]init];
    NSMutableArray *firstSection = [[NSMutableArray alloc]init];
    NSMutableArray *secondSection = [[NSMutableArray alloc]init];
    NSArray *title = @[@"照片",@"姓名",@"出生年月",@"性别",@"人员类型",@"学校",@"居住地点"];
    NSArray *cls = @[@"InformationCell",@"InformationInputCell",@"InformationCell",@"InformationSegmentedCell",@"InformationSegmentedCell",@"InformationInputCell",@"InformationCell"];
    NSArray *hint = @[@"请上传个人照片",@"请输入真实姓名",@"请选择出生日期",@[@"男",@"女"],@[@"在校生",@"社会人员"],@"请输入院校名称",@"请选择居住地点"];
    for (int i = 0; i < 4 ; i++) {
        InformationRecord *record = [[InformationRecord alloc]init];
        record.title = title[i];
        record.clsName = cls[i];
        record.hintObject = hint[i];
        if (i == SEX) {
            record.userInfo = @"sex";
        }
        [firstSection addObject:record];
    }
    [dataSource addObject:firstSection];
    
    for (int i = 0; i < 3 ; i++) {
        int index = i + 4;
        InformationRecord *record = [[InformationRecord alloc]init];

        record.title = title[index];
        record.clsName = cls[index];
        record.hintObject = hint[index];
        [secondSection addObject:record];
    }
    [dataSource addObject:secondSection];
    
    [self initView];
    
}

- (void)initView
{
    UILabel *hintLabel = [[UILabel alloc]initWithFrame:CGRectMake(10, 0, SCREEN_WIDTH-20, 30)];
    hintLabel.text = @"填写基本资料，开启收（zhuan）米（qian）模式！";
    [hintLabel setFont:[UIFont systemFontOfSize:12]];
    [self.view addSubview:hintLabel];
    
    _tableView = [[UITableView alloc]initWithFrame:CGRectMake(0, hintLabel.maxY, SCREEN_WIDTH, CONTENT_NO_TAB_HEIGHT - hintLabel.maxY)];
    _tableView.delegate = self;
    _tableView.dataSource = self;
    _tableView.backgroundColor = COLOR_DEFAULT_BG;
    _tableView.separatorStyle = UITableViewCellSeparatorStyleNone;
    [_tableView registerNib:[UINib nibWithNibName:@"InformationCell" bundle:nil] forCellReuseIdentifier:@"InformationCell"];
    [_tableView registerNib:[UINib nibWithNibName:@"InformationInputCell" bundle:nil] forCellReuseIdentifier:@"InformationInputCell"];
    [_tableView registerNib:[UINib nibWithNibName:@"InformationSegmentedCell" bundle:nil] forCellReuseIdentifier:@"InformationSegmentedCell"];
    [self.view addSubview:_tableView];
    
    UIView *view = [[UIView alloc]initWithFrame:CGRectMake(0, 0, SCREEN_WIDTH, 80)];
    view.backgroundColor = COLOR_DEFAULT_BG;
    UIButton *button = [UIUtils createNextButton];
    [button addTarget:self action:@selector(next:) forControlEvents:UIControlEventTouchUpInside];
    [view addSubview:button];
    
    _tableView.tableFooterView = view;
    
    
}

- (NSString *)rightBarTitle
{
    return @"跳过";
}

- (BOOL)hiddenBackBar
{
    return YES;
}

- (void)rightBarClick
{
    NSLog(@"right ,,,,,,,,");
}

- (void)next:(id)sender
{
    [self.view endEditing:YES];

}

#pragma mark -
#pragma mark - UITableViewDataSource

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return dataSource.count;
}


- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    NSMutableArray *data = dataSource[section];
    return data.count;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    NSMutableArray *section = dataSource[indexPath.section];
    InformationRecord *record = section[indexPath.row];
    
    UITableViewCell *aCell = [tableView dequeueReusableCellWithIdentifier:record.clsName];
    if (!aCell) {
        aCell = [[NSClassFromString(record.clsName) alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:record.clsName];
    }
    
    aCell.selectionStyle = UITableViewCellSelectionStyleNone;
    
    if (indexPath.section == 0) {
        if (indexPath.row == UPLOAD_PHOTO || indexPath.row == BIRTHDATE) {
            InformationCell *cell = (id)aCell;
            cell.titleLabel.text = record.title;
            
            if ([record.content isKindOfClass:[UIImage class]] ) {
                cell.headPicture.image = record.content;
                cell.hintLabel.hidden = YES;
                cell.headPicture.hidden = NO;
            } else if ([record.content isKindOfClass:[NSString class]]) {
                cell.hintLabel.text = record.content;
            } else {
                cell.hintLabel.text = record.hintObject;
            }
        } else if (indexPath.row == NAME) {
            InformationInputCell *cell = (id)aCell;
            cell.titleLabel.text = record.title;
            cell.textField.placeholder = record.hintObject;
            cell.textField.delegate = self;
            cell.textField.userInfo = record;

        } else if (indexPath.row == SEX) {
            InformationSegmentedCell *cell = (id)aCell;
            cell.titleLabel.text = record.title;
            NSArray *object = record.hintObject;
            [cell.segmentedCtl setTitle:object[0] forSegmentAtIndex:0];
            [cell.segmentedCtl setTitle:object[1] forSegmentAtIndex:1];
            [cell.segmentedCtl addTarget:self action:@selector(segmentedValueChange:) forControlEvents:UIControlEventValueChanged];
        
            cell.segmentedCtl.userInfo = record;
        }

    } else if (indexPath.section == 1) {
        if (indexPath.row == TYPE) {
            InformationSegmentedCell *cell = (id)aCell;
            cell.titleLabel.text = record.title;
            [cell.segmentedCtl setTitle:[record.hintObject objectAtIndex:0] forSegmentAtIndex:0];
            [cell.segmentedCtl setTitle:[record.hintObject objectAtIndex:1] forSegmentAtIndex:1];
            [cell.segmentedCtl addTarget:self action:@selector(segmentedValueChange:) forControlEvents:UIControlEventValueChanged];
            cell.segmentedCtl.userInfo = record;
        } else if (indexPath.row == SCHOOL) {
            InformationInputCell *cell = (id)aCell;
            cell.titleLabel.text = record.title;
            if (record.content != nil) {
                cell.textField.text = record.content;
            }
            cell.textField.placeholder = record.hintObject;
            cell.textField.delegate = self;
            cell.textField.userInfo = record;
        } else if (indexPath.row == LIVE_ADDR) {
            InformationCell *cell = (id)aCell;
            cell.titleLabel.text = record.title;
            cell.hintLabel.text = record.hintObject;
        }
    }
    
    return aCell;
}


#pragma mark -
#pragma mark - UITableViewDelegate

- (CGFloat)tableView:(UITableView *)tableView heightForHeaderInSection:(NSInteger)section
{
    if (section == 0) {
        return 0;
    }
    return 10;
}

- (UIView *)tableView:(UITableView *)tableView viewForFooterInSection:(NSInteger)section
{
    UIView *view = [[UIView alloc]initWithFrame:CGRectMake(0, 0, SCREEN_WIDTH, 20)];
    view.backgroundColor = COLOR_DEFAULT_BG;
    return view;
}

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (indexPath.section == 1 && indexPath.row == SCHOOL) {
        InformationRecord *record = [dataSource[1] objectAtIndex:TYPE];
        if ([record.content integerValue]) {
            return 0;
        }
    }
    return 60;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (indexPath.section == 0 ) {
        if (indexPath.row == UPLOAD_PHOTO) {
            UIActionSheet *action = [[UIActionSheet alloc]initWithTitle:@"图片选择" delegate:self cancelButtonTitle:@"返回" destructiveButtonTitle:@"拍照" otherButtonTitles:@"相册", nil];
            action.actionSheetStyle = UIActionSheetStyleBlackOpaque;
            [action showInView:self.view];
        } else if (indexPath.row == BIRTHDATE) {
            
            tempTextField = [[UITextField alloc]initWithFrame:CGRectZero];
            tempTextField.inputAccessoryView = [UIUtils dateInputAccessoryViewWithTarget:self action:@selector(datePickerDone:)];
            tempTextField.inputView = [UIUtils datePickerWithTarget:self action:@selector(datePickerValueChange:)];
            [self.view addSubview:tempTextField];
            [tempTextField becomeFirstResponder];
            
        } else {
            [tempTextField resignFirstResponder];
        }
    } else {
        if (indexPath.row == LIVE_ADDR) {
            [self.navigationController pushViewController:[[AddressController alloc]init] animated:YES];
            
        }
        [tempTextField resignFirstResponder];
    }
    
}

- (void)segmentedValueChange:(UISegmentedControl *)segment
{
    InformationRecord *record = segment.userInfo;
    NSNumber *number = [NSNumber numberWithInteger:segment.selectedSegmentIndex];
    record.content = number;
    
    NSIndexPath *indexPath = [NSIndexPath indexPathForRow:SCHOOL inSection:1];
    [_tableView reloadRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationAutomatic];
}
#pragma mark -
#pragma mark - UIDatePicker

- (void)datePickerDone:(id)sender
{
    [tempTextField resignFirstResponder];
}

- (void)datePickerValueChange:(id)sender
{
    UIDatePicker *datePicker = sender;
    NSDateFormatter *formatter = [[NSDateFormatter alloc]init];
    [formatter setDateFormat:@"YYYY-MM-dd"];
    NSString *date = [formatter stringFromDate:datePicker.date];
    
    InformationRecord *record = [dataSource[0] objectAtIndex:BIRTHDATE];
    record.content = date;
    
    [_tableView reloadRowsAtIndexPaths:@[[NSIndexPath indexPathForRow:BIRTHDATE inSection:0]] withRowAnimation:UITableViewRowAnimationNone];
    NSLog(@"%@",date);
    
}


#pragma mark -
#pragma mark - UITextFieldDelegate

//开始编辑输入框的时候，软键盘出现，执行此事件
-(void)textFieldDidBeginEditing:(UITextField *)textField
{
    CGRect frame = [textField convertRect:[UIScreen mainScreen].bounds toView:nil];
    int offset = 216 - (SCREEN_HEIGHT-frame.origin.y) + 32 + NAVIGATION_HEIGHT;
    
    
    NSTimeInterval animationDuration = 0.30f;
    [UIView beginAnimations:@"ResizeForKeyboard" context:nil];
    [UIView setAnimationDuration:animationDuration];
    
    CGSize contentSize = _tableView.contentSize;
    contentSize.height  += 216  ;
    _tableView.contentSize = contentSize;
    
    //将视图的Y坐标向上移动offset个单位，以使下面腾出地方用于软键盘的显示
    if(offset > 0) {
       CGPoint contentOffset =  _tableView.contentOffset;
        contentOffset.y += offset;
        _tableView.contentOffset = contentOffset;
    }

    [UIView commitAnimations];
}

//当用户按下return键或者按回车键，keyboard消失
-(BOOL)textFieldShouldReturn:(UITextField *)textField
{
    [textField resignFirstResponder];
    return YES;
}

//输入框编辑完成以后，将视图恢复到原始状态
-(void)textFieldDidEndEditing:(UITextField *)textField
{
    CGSize contentSize = _tableView.contentSize;
    contentSize.height  -= 216  ;
    _tableView.contentSize = contentSize;
    
    InformationRecord *record = textField.userInfo;
    record.content = textField.text;
}

#pragma mark - 
#pragma mark - UIActionSheetDelegate
- (void)actionSheet:(UIActionSheet *)actionSheet clickedButtonAtIndex:(NSInteger)buttonIndex
{
    
    if (buttonIndex == 0) {
        [self showImagePickerControllerWithSourceType:UIImagePickerControllerSourceTypeCamera];
    } else if (buttonIndex == 1) {
        [self showImagePickerControllerWithSourceType:UIImagePickerControllerSourceTypePhotoLibrary];
    } else {
        
    }
    
    [actionSheet removeFromSuperview];
}


- (void)showImagePickerControllerWithSourceType:(UIImagePickerControllerSourceType)sourceType
{
    UIImagePickerController *imagePickerController = [[UIImagePickerController alloc]init];
    imagePickerController.delegate = self;
    imagePickerController.sourceType = sourceType;
    imagePickerController.modalTransitionStyle = UIModalTransitionStyleCoverVertical;
    imagePickerController.allowsEditing = YES;
    [self presentViewController:imagePickerController animated:YES completion:^{
        
    }];
}

- (void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info
{
    UIImage *image = [info objectForKey:UIImagePickerControllerOriginalImage];

    InformationRecord *record = [dataSource[0] objectAtIndex:0];
    record.content = image;
    
    NSData *imgData = UIImagePNGRepresentation(image);
    // todo  upload image data ......
    
    [_tableView reloadRowsAtIndexPaths:@[[NSIndexPath indexPathForRow:0 inSection:0]] withRowAnimation:UITableViewRowAnimationNone];
    
    [picker dismissViewControllerAnimated:YES completion:^{
        
        [UIView animateWithDuration:0.3 animations:^{
            
        }];
        
    }];
}
@end
