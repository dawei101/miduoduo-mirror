//
//  GuideView2.m
//  miduoduo
//
//  Created by chongdd on 15/6/10.
//  Copyright (c) 2015年 miduoduo. All rights reserved.
//

#import "GuideView.h"
#import "NSUserDefaults+Convenient.h"


@implementation GuideView

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        [self initView];
    }
    
    return self;
}

- (void)initView
{
    self.scrollView = [[UIScrollView alloc]initWithFrame:self.bounds];
    self.scrollView.contentSize = CGSizeMake(SCREEN_WIDTH * 4, SCREEN_HEIGHT);
    self.scrollView.userInteractionEnabled = YES;
    self.scrollView.pagingEnabled = YES;
    self.scrollView.showsHorizontalScrollIndicator = NO;
    self.scrollView.showsVerticalScrollIndicator = NO;
    self.scrollView.bounces = NO;
    
    for (int i = 0; i < 4; i++) {
        UIImageView *imageView = [[UIImageView alloc]initWithFrame:CGRectMake(SCREEN_WIDTH * i, 0, SCREEN_WIDTH, SCREEN_HEIGHT)];
        imageView.image = [UIImage imageNamed:[NSString stringWithFormat:@"guide_%i",i+1]];
        [self.scrollView addSubview:imageView];
        
        if (i == 3) {
            imageView.userInteractionEnabled = YES;
            self.control = [[UIButton alloc]initWithFrame:CGRectMake(100, SCREEN_HEIGHT-68, SCREEN_WIDTH-200, 40)];
            self.control.backgroundColor = [UIColor clearColor];
            [self.control addTarget:self action:@selector(goMainView) forControlEvents:UIControlEventTouchDown];
            [imageView addSubview:self.control];
        }
    }
    
    [self addSubview:self.scrollView];
    
}


- (void)goMainView{
    
    CGRect frame = self.frame;
    frame.origin.y += self.frame.size.height;
    
    [UIView animateWithDuration:.3 animations:^{
        self.frame = frame;
    } completion:^(BOOL finished) {
        [self removeFromSuperview];
        [NSUserDefaults isFirstRun:NO];
    }];
}


+ (UIWindow *)mainWindow
{
    UIApplication *app = [UIApplication sharedApplication];
    if ([app.delegate respondsToSelector:@selector(window)])
    {
        return [app.delegate window];
    }
    else
    {
        return [app keyWindow];
    }
}

+ (void)showGuide
{
    
    GuideView *guide = [[GuideView alloc]initWithFrame:[UIScreen mainScreen].bounds];
    CGRect frame = guide.frame;
    frame.origin.y -= frame.size.height;
    guide.frame = frame;
    
    [[self mainWindow] addSubview:guide];
    [UIView animateWithDuration:1 animations:^{
        guide.frame = [UIScreen mainScreen].bounds;
    }];
    
//    [UIView beginAnimations:nil context:nil];
//    [UIView setAnimationRepeatCount:1];
//    [UIView setAnimationDuration:1];
//    [UIView setAnimationCurve:UIViewAnimationCurveEaseIn];
//    [UIView setAnimationTransition:UIViewAnimationTransitionCurlDown forView:activityView cache:YES];
//    NSArray *subViews = [UIUtils activityViewController].view.subviews;
//    NSUInteger first = [subViews indexOfObject:activityView];
//    NSUInteger second = [subViews indexOfObject:self.view];
//    [activityView exchangeSubviewAtIndex:first withSubviewAtIndex:second];
//    [UIView commitAnimations];
}

+ (void)show {
    [NSTimer scheduledTimerWithTimeInterval:.1 target:self selector:@selector(showGuide) userInfo:nil repeats:NO];
}
@end
