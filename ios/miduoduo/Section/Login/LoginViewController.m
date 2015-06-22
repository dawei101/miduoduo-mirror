//
//  LoginViewController.m
//  miduoduo
//
//  Created by chongdd on 15/6/8.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "LoginViewController.h"
#import "NormalUtils.h"
#import "RegisterViewController.h"

@interface LoginViewController () <UITextFieldDelegate >
{
    NSString    *userName;
    NSString    *password;
}


@end

@implementation LoginViewController

- (void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
    
}

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view from its nib.

    [self initView];

}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)initView
{
    UIImageView *bgImageView = [[UIImageView alloc]initWithFrame:self.view.bounds];
    bgImageView.image = [UIImage imageNamed:@"login_bg"];
    [self.view addSubview:bgImageView];
    
    UIButton *jumpBtn = [[UIButton alloc]initWithFrame:CGRectMake(SCREEN_WIDTH - 70, 43, 40, 30)];
    jumpBtn.backgroundColor = [UIColor clearColor];
    [jumpBtn setTitle:@"跳过" forState:UIControlStateNormal];
    jumpBtn.alpha = .5;
    [jumpBtn addTarget:self action:@selector(jumpBtnClick:) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:jumpBtn];
    
    UIImageView *beginImageView = [[UIImageView alloc]initWithFrame:CGRectMake(0, 185, SCREEN_WIDTH, 17)];
    beginImageView.image = [UIImage imageNamed:@"login_start"];
    [self.view addSubview:beginImageView];
    
    
    UIButton *registerBtn = [[UIButton alloc]initWithFrame:CGRectMake(20, SCREEN_HEIGHT - 65 -36, SCREEN_WIDTH - 40, 36)];
    registerBtn.backgroundColor = [UIColor colorFromHexString:@"#00B564"];
    [registerBtn addTarget:self action:@selector(registerBtnClick:) forControlEvents:UIControlEventTouchUpInside];
    [registerBtn setTitle:@"注册" forState:UIControlStateNormal];
    registerBtn.layer.cornerRadius = 5.0;
    [self.view addSubview:registerBtn];
    
    UIImageView *orImageView = [[UIImageView alloc]initWithFrame:CGRectMake(20, registerBtn.y-15-9, registerBtn.frame.size.width, 9)];
    orImageView.image = [UIImage imageNamed:@"login_or"];
    [self.view addSubview:orImageView];
    
    UIButton *loginBtn = [[UIButton alloc]initWithFrame:CGRectMake(20, orImageView.y - 15 - 36, registerBtn.frame.size.width, 36)];
    loginBtn.backgroundColor = COLOR_THEME;
    [loginBtn addTarget:self action:@selector(loginBtnClick:) forControlEvents:UIControlEventTouchUpInside];
    [loginBtn setTitleColor:[UIColor blackColor] forState:UIControlStateNormal];
    [loginBtn setTitle:@"登录" forState:UIControlStateNormal];
    loginBtn.layer.cornerRadius = 5.0;
    [self.view addSubview:loginBtn];
    
    UIButton *forgetPwdBtn = [[UIButton alloc]initWithFrame:CGRectMake(SCREEN_WIDTH - 100,loginBtn.y - 10 -15, 80, 15)];
    forgetPwdBtn.backgroundColor = [UIColor clearColor];
    [forgetPwdBtn setTitle:@"忘记密码" forState:UIControlStateNormal];
    [forgetPwdBtn setFont:[UIFont systemFontOfSize:12]];
    forgetPwdBtn.alpha = .5;
    [forgetPwdBtn addTarget:self action:@selector(forgetPwdBtnClick:) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:forgetPwdBtn];
    
    UIView *viewbg = [[UIView alloc]initWithFrame:CGRectMake(20, forgetPwdBtn.y - 13 - 81, SCREEN_WIDTH - 40, 81)];
    [viewbg.layer setBorderColor:[UIColor whiteColor].CGColor];
    viewbg.layer.borderWidth = 1;
    viewbg.alpha = .3;
    viewbg.layer.cornerRadius = 5;
    [self.view addSubview:viewbg];
    
    UIView *view = [[UIView alloc]initWithFrame:CGRectMake(21, forgetPwdBtn.y - 13 - 80, SCREEN_WIDTH - 42, 79)];
    view.backgroundColor = [UIColor whiteColor];
        view.alpha = .1;
    view.layer.cornerRadius = 5;
    [self.view addSubview:view];
    
    UIView *loginView = [[UIView alloc]initWithFrame:view.frame];
    loginView.backgroundColor= [UIColor clearColor];
    [self.view addSubview:loginView];
    
    UIView *line = [[UIView alloc]initWithFrame:CGRectMake(0, loginView.height/2-.5, loginView.width, 1)];
    line.backgroundColor = [UIColor whiteColor];
    line.alpha = .3;
    [loginView addSubview:line];
    
    UIImageView *man = [[UIImageView alloc]initWithFrame:CGRectMake(3, 5, 30, 30)];
    man.image = [UIImage imageNamed:@"login_man"];
    [loginView addSubview:man];
    
    UITextField *userTextField = [[UITextField alloc]initWithFrame:CGRectMake(man.maxX + 10, 5, loginView.width-man.maxX-20, 30)];
    userTextField.placeholder = @"请输入手机号码";
    userTextField.textColor = [UIColor whiteColor];
    userTextField.clearButtonMode = UITextFieldViewModeWhileEditing;
    userTextField.keyboardType = UIKeyboardTypeNumberPad;
    userTextField.alpha = .5;
    userTextField.delegate= self;
    userTextField.tag = 1;
    [userTextField setFont:[UIFont systemFontOfSize:12]];
    [loginView addSubview:userTextField];
    
    UIImageView *lock = [[UIImageView alloc]initWithFrame:CGRectMake(3,line.y + 6, 30, 30)];
    lock.image = [UIImage imageNamed:@"login_lock"];
    [loginView addSubview:lock];
    
    UITextField *pwd = [[UITextField alloc]initWithFrame:CGRectMake(lock.maxX + 10, lock.y, loginView.width-lock.maxX-20, 30)];
    pwd.placeholder = @"请输入登录密码";
    pwd.textColor = [UIColor whiteColor];
    pwd.clearButtonMode = UITextFieldViewModeWhileEditing;
    pwd.keyboardType = UIKeyboardTypeDefault;
    pwd.secureTextEntry = YES;
    pwd.alpha = .5;
    pwd.delegate = self;
    pwd.tag = 2;
    [pwd setFont:[UIFont systemFontOfSize:12]];
    [loginView addSubview:pwd];
    
}

- (UIViewController *)createTabBarItem:(NSString *)viewController title:(NSString *)title imageName:(NSString *)imageName selectedImageName:(NSString *)selectedImageName
{
    UIViewController *controller = [[NSClassFromString(viewController) alloc]init];
    
    UINavigationController *navigationController = [[UINavigationController alloc]initWithRootViewController:controller];
    
    UIImage *image = [[UIImage imageNamed:imageName] imageWithRenderingMode:UIImageRenderingModeAlwaysOriginal];
    UIImage *selectedImage = [[UIImage imageNamed:selectedImageName] imageWithRenderingMode:UIImageRenderingModeAlwaysOriginal];
    UITabBarItem *tabBarItem = [[UITabBarItem alloc]initWithTitle:title image:image selectedImage:selectedImage];
    navigationController.tabBarItem = tabBarItem;
    
    [navigationController.navigationBar setTintColor:[UIColor lightGrayColor]];
    [navigationController.navigationBar setTranslucent:NO];
    return navigationController;
}

- (void)gotoMainView:(id)sender
{
    UIViewController *mainViewController = [self createTabBarItem:@"MainViewController" title:@"首页" imageName:@"tab_item_1_d" selectedImageName:@"tab_item_1_n"];
    UIViewController *recordViewController = [self createTabBarItem:@"RecordViewController" title:@"接单记录" imageName:@"tab_item_2_d" selectedImageName:@"tab_item_2_n"];
    UIViewController *miViewController = [self createTabBarItem:@"MiViewController" title:@"米园" imageName:@"tab_item_3_d" selectedImageName:@"tab_item_3_n"];
    
    UITabBarController *tabBarController = [[UITabBarController alloc]init];
    tabBarController.viewControllers = @[mainViewController,recordViewController,miViewController];
    // 把 tabBar 的特效去掉，反正在viewcontroller 切换时，会出现闪烁,同理导航栏
    [tabBarController.tabBar setTranslucent:NO];
    
//    [self presentModalViewController:tabBarController animated:YES];
    [self.navigationController pushViewController:tabBarController animated:YES];
}


- (void)loginBtnClick:(id)sender
{
    [self.view endEditing:NO];
    
    NSLog(@"%@,%@",userName,password);
    
    [self gotoMainView:nil];
}

- (void)registerBtnClick:(id)sender
{
    RegisterViewController *controller = [[RegisterViewController alloc]init];
    self.navigationController.navigationBarHidden = NO;
    [self.navigationController pushViewController:controller animated:YES];
}

- (void)forgetPwdBtnClick:(id)sender
{
    RegisterViewController *controller = [[RegisterViewController alloc]init];
    controller.isForgetPwd = YES;
    self.navigationController.navigationBarHidden = NO;
    [self.navigationController pushViewController:controller animated:YES];
}

- (void)jumpBtnClick:(id)sender
{
    
}

- (BOOL)textFieldShouldEndEditing:(UITextField *)textField
{
    if (textField.tag == 1) {
        userName = textField.text;
    } else {
        password = textField.text;
    }
    
    return YES;
}


@end
