package com.miduoduo.person.activity;

import android.app.Activity;
import android.app.Fragment;
import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.widget.ImageButton;

import com.miduoduo.person.R;
import com.miduoduo.person.fragment.HomeFragment;
import com.miduoduo.person.fragment.MiFragment;
import com.miduoduo.person.fragment.RecordFragment;

public class MainActivity extends Activity {

	private ImageButton mBar1, mBar2, mBar3;
	private View currentButton;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);// 去掉标题栏
		setContentView(R.layout.activity_main);

		initButtomBar();
	}
	
	private void initButtomBar() {
		mBar1 = (ImageButton) findViewById(R.id.buttom_bar1);
		mBar2 = (ImageButton) findViewById(R.id.buttom_bar2);
		mBar3 = (ImageButton) findViewById(R.id.buttom_bar3);

		mBar1.setOnClickListener(onClickListener);
		mBar2.setOnClickListener(onClickListener);
		mBar3.setOnClickListener(onClickListener);
		// 调用此控件的点击事件
		mBar1.performClick();
	}

	/** 底部功能栏的监听器 */
	private OnClickListener onClickListener = new OnClickListener() {
		@Override
		public void onClick(View v) {
			// 设置当前视图启用状态
			setButton(v);
			switch (v.getId()) {
			case R.id.buttom_bar1:
				replaceFragment(new HomeFragment());
				break;
			case R.id.buttom_bar2:
				replaceFragment(new RecordFragment());
				break;
			case R.id.buttom_bar3:
				replaceFragment(new MiFragment());
				break;
			default:
				break;
			}

		}

		/** 更新替换Fragment */
		private void replaceFragment(Fragment fragment) {
			FragmentManager fManager = getFragmentManager();
			FragmentTransaction fTransaction = fManager.beginTransaction();
			fTransaction.replace(R.id.fl_content, fragment);
			fTransaction.commit();
		}

		/** 设置当前视图启用状态 */
		private void setButton(View view) {
			if (currentButton != null && currentButton.getId() != view.getId()) {
				currentButton.setEnabled(true);
			}
			view.setEnabled(false);
			currentButton = view;
		}
	};

}
