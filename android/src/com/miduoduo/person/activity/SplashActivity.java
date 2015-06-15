package com.miduoduo.person.activity;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.Log;

import cn.jpush.android.api.JPushInterface;

import com.miduoduo.person.Constants;
import com.miduoduo.person.R;
import com.miduoduo.person.util.SharedPreferencesUtils;

/**
 * <ul>
 * <li>类描述：启动界面
 * <li>创建时间： 2015-6-11 上午10:39:49
 * <li>创建人：liyunlong
 * </ul>
 */
public class SplashActivity extends Activity {

	boolean isFirstIn = false;
	private static final int GO_HOME = 1000;
	private static final int GO_GUIDE = 1001;

	/**
	 * Handler:跳转到不同界面
	 */
	@SuppressLint("HandlerLeak")
	private Handler mHandler = new Handler() {

		@Override
		public void handleMessage(Message msg) {
			switch (msg.what) {
			case GO_HOME:
				goHome();
				break;
			case GO_GUIDE:
				goGuide();
				break;
			}
			super.handleMessage(msg);
		}
	};

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_splash);

		init();
	}

	private void init() {
		String registrationID = JPushInterface
				.getRegistrationID(getApplicationContext());
		Log.i("TAG", "registrationID=" + registrationID);
		isFirstIn = SharedPreferencesUtils.getBoolean(getApplicationContext(),
				Constants.Config.ISFIRSTRUN, true);

		if (!isFirstIn) {
			// 登陆界面
			mHandler.sendEmptyMessageDelayed(GO_HOME, 3000);
		} else {
			// 引导页
			mHandler.sendEmptyMessageDelayed(GO_GUIDE, 3000);
		}

	}

	@Override
	protected void onResume() {
		super.onResume();
		JPushInterface.onResume(getApplicationContext());
	}

	@Override
	protected void onPause() {
		super.onPause();
		JPushInterface.onPause(getApplicationContext());
	}

	private void goHome() {
		Intent intent = new Intent(SplashActivity.this, LoginActivity.class);
		SplashActivity.this.startActivity(intent);
		SplashActivity.this.finish();
	}

	private void goGuide() {
		Intent intent = new Intent(SplashActivity.this, GuideActivity.class);
		SplashActivity.this.startActivity(intent);
		SplashActivity.this.finish();
	}
}
