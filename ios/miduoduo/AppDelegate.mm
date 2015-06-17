//
//  AppDelegate.m
//  miduoduo
//
//  Created by chongdd on 15/5/29.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "AppDelegate.h"
#import "NormalUtils.h"
#import "CustomURLCache.h"
#import "GuideView.h"
#import "LoginViewController.h"
#import "AddressController.h"
#import "MainViewController.h"
#import "NSUserDefaults+Convenient.h"
#import "CheckUpdate.h"

#import <ShareSDK/ShareSDK.h>
#import <UIKit/UIKit.h>

//第三方平台的SDK头文件，根据需要的平台导入。

#import <TencentOpenAPI/QQApi.h>
#import <TencentOpenAPI/QQApiInterface.h>
#import <TencentOpenAPI/TencentOAuth.h>

@interface AppDelegate () <UIAlertViewDelegate>

@end

@implementation AppDelegate

- (void)initializePlat
{
    [ShareSDK connectSMS];
    [ShareSDK connectQZoneWithAppKey:@"1104646657"
                           appSecret:@"EJm3UOlZqzSX8Frc"
                   qqApiInterfaceCls:[QQApiInterface class]
                     tencentOAuthCls:[TencentOAuth class]];
    
}

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions {
    // Override point for customization after application launch.

    // 设置 缓存区域
    CustomURLCache *urlCache = [[CustomURLCache alloc]initWithMemoryCapacity:200 * 1024 * 1024
                                                                diskCapacity:2000 * 1024 * 1024
                                                                    diskPath:nil
                                                                   cacheTime:0];
    [CustomURLCache setSharedURLCache:urlCache];
    
    //1.初始化ShareSDK应用,Appkey
    [ShareSDK registerApp:@"833fa5e712ad"];
    [self initializePlat];
    
    // 要使用百度地图，请先启动BaiduMapManager
    BMKMapManager *_mapManager = [[BMKMapManager alloc]init];
    if (![_mapManager start:@"l8u4uHf2tdwvzoArf6OdDYWH" generalDelegate:self]) {
        NSLog(@"manager start failed!");
    }

    LoginViewController *LC = [[LoginViewController alloc]init];
    UINavigationController *NC = [[UINavigationController alloc]initWithRootViewController:LC];
    
    LC.navigationController.navigationBarHidden = YES;
    self.window.rootViewController = NC;
    
    
//    self.window.rootViewController = [[UINavigationController alloc]initWithRootViewController:[[NSClassFromString(@"AddressController") alloc]init]];
    
    // 设置全局的导航栏和状态栏颜色
    [[UINavigationBar appearance] setBarTintColor:COLOR_THEME];
    [[UINavigationBar appearance] setTintColor:[UIColor blackColor]];
    
   [self.window makeKeyAndVisible];
    if ([NSUserDefaults isFirstRun]) {
        [GuideView show];
    }
    
    [self checkUpdate];

    return YES;
}

- (void)applicationWillResignActive:(UIApplication *)application {
    // Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
    // Use this method to pause ongoing tasks, disable timers, and throttle down OpenGL ES frame rates. Games should use this method to pause the game.
}

- (void)applicationDidEnterBackground:(UIApplication *)application {
    // Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later.
    // If your application supports background execution, this method is called instead of applicationWillTerminate: when the user quits.
}

- (void)applicationWillEnterForeground:(UIApplication *)application {
    // Called as part of the transition from the background to the inactive state; here you can undo many of the changes made on entering the background.
}

- (void)applicationDidBecomeActive:(UIApplication *)application {
    // Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
}

- (void)applicationWillTerminate:(UIApplication *)application {
    // Called when the application is about to terminate. Save data if appropriate. See also applicationDidEnterBackground:.
}

- (void)applicationDidReceiveMemoryWarning:(UIApplication *)application
{// 内存告警，清除缓存
    [[NSURLCache sharedURLCache] removeAllCachedResponses];
}

- (BOOL)application:(UIApplication *)application handleOpenURL:(NSURL *)url
{
    return [ShareSDK handleOpenURL:url wxDelegate:self];
}

- (BOOL)application:(UIApplication *)application openURL:(NSURL *)url sourceApplication:(NSString *)sourceApplication annotation:(id)annotation
{
    return [ShareSDK handleOpenURL:url sourceApplication:sourceApplication annotation:annotation wxDelegate:self];
}

- (void)onGetNetworkState:(int)iError
{
    if (0 == iError) {
        NSLog(@"联网成功");
    }
    else{
        NSLog(@"onGetNetworkState %d",iError);
    }
    
}

- (void)onGetPermissionState:(int)iError
{
    if (0 == iError) {
        NSLog(@"授权成功");
    }
    else {
        NSLog(@"onGetPermissionState %d",iError);
    }
}


- (void)checkUpdate
{
    [[CheckUpdate instance] checkUpdate:^(CheckUpdateInfo *info) {
        [[[UIAlertView alloc]initWithTitle:info.title message:info.msg delegate:self cancelButtonTitle:@"取消" otherButtonTitles:@"升级", nil] show];
    } error:^(NSError *error, id data) {
        [self performSelector:@selector(checkUpdate) withObject:nil afterDelay:3];
    }];
}

- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if (buttonIndex == 0) {
        [alertView removeFromSuperview];
    } else {
        NSURL *phoneURL = [NSURL URLWithString:[CheckUpdate instance].info.url];
        [[UIApplication sharedApplication] openURL:phoneURL];
    }
}
@end
