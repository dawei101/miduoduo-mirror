package com.miduoduo.person.activity;

import android.app.Activity;
import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.Window;
import android.widget.LinearLayout;

import com.miduoduo.person.R;
import com.miduoduo.person.view.UINavigationView;

public abstract class BaseActivity extends Activity {

	public UINavigationView navigation;
	private LinearLayout llContainer;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);// 去掉标题栏
		// setTheme(R.style.ActivityTheme); // 设置Activity的主题
		setContentView(R.layout.activity_base);

		navigation = (UINavigationView) findViewById(R.id.base_title_bar);

		// setTitleBarVisible();
	}

	// private void setTitleBarVisible() {
	// titleBarView.setTitleBarViewVisibility(View.VISIBLE, View.VISIBLE,
	// View.VISIBLE);
	// }

	/** 设置标题栏左侧标题 */
	// public void setTitleBarLeftButton(int leftIconResId, String leftTxtRes,
	// OnClickListener leftListener) {
	// titleBarView.setTitleBarLeftButton(leftIconResId, leftTxtRes);
	// titleBarView.setTitleBarLeftBtnOnclickListener(leftListener);
	// };

	/** 设置导航栏标题 */
	public void setNavigationViewTitle(String leftTitleRes, int titleResId,
			String rightTitle) {
		// titleBarView.setTitleBarCenterTitle(titleResId);
		navigation.setStrBtnLeft(rightTitle);
		navigation.getTv_title().setText(titleResId);
		navigation.setStrBtnRight(rightTitle);

	}

	/** 设置导航栏点击监听 */
	public void setNavigationViewListener(
			UINavigationView.OnClickListener listener) {
		navigation.setListener(listener);
	}

	/** 设置导航栏点击监听 */
	public void setNavigationViewDrable(int leftIconResId, int rightIconResId) {
		if (leftIconResId != 0) {
			navigation.setLeft_drawable(leftIconResId);
		}
		if (rightIconResId != 0) {
			navigation.setRight_drawable(rightIconResId);
		}

	}

	/** 设置标题栏右侧侧标题 */
	// public void setTitleBarRightButton(int rightIconResId, String
	// rightTxtRes,
	// OnClickListener rightListener) {
	// if (rightIconResId == 0) {
	// titleBarView.setTitleBarRightTitle(rightTxtRes);
	// } else {
	// titleBarView.setTitleBarRightButton(rightIconResId, rightTxtRes);
	// }
	// titleBarView.setTitleBarRightBtnOnclickListener(rightListener);
	// };

	/** 设置要显示的内容 */
	public void setBaseContentView(int layoutID) {
		llContainer = (LinearLayout) findViewById(R.id.base_ll_container);
		LayoutInflater inflater = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		View view = inflater.inflate(layoutID, null);
		llContainer.addView(view);

		setNavigationView();

		findView();

		init();

	}

	/** 设置标题栏 */
	public abstract void setNavigationView();

	/** 查找控件 */
	public abstract void findView();

	/** 初始化 */
	public abstract void init();

}
