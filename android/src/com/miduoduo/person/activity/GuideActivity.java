package com.miduoduo.person.activity;

import java.util.ArrayList;
import java.util.List;

import android.app.Activity;
import android.os.Bundle;
import android.support.v4.view.ViewPager;
import android.support.v4.view.ViewPager.OnPageChangeListener;
import android.view.LayoutInflater;
import android.view.View;

import com.miduoduo.person.R;
import com.miduoduo.person.adapter.GuideViewPagerAdapter;

/**
 * <ul>
 * <li>类描述：引导页界面
 * <li>创建时间： 2015-6-11 上午10:59:23
 * <li>创建人：liyunlong
 * </ul>
 */
public class GuideActivity extends Activity implements OnPageChangeListener {

	private ViewPager mVP;
	private GuideViewPagerAdapter adapter;
	private List<View> views;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_guide);

		// 初始化页面
		initViews();
	}

	private void initViews() {
		LayoutInflater inflater = LayoutInflater.from(this);
		views = new ArrayList<View>();
		// 初始化引导图片列表
		View view1 = inflater.inflate(R.layout.guide_layout_one, null);
		views.add(view1);
		views.add(inflater.inflate(R.layout.guide_layout_two, null));
		views.add(inflater.inflate(R.layout.guide_layout_three, null));
		views.add(inflater.inflate(R.layout.guide_layout_four, null));

		// 初始化Adapter
		adapter = new GuideViewPagerAdapter(views, this);

		mVP = (ViewPager) findViewById(R.id.guide_viewpager);
		mVP.setAdapter(adapter);
		// 绑定回调
		mVP.setOnPageChangeListener(this);
	}

	// 当滑动状态改变时调用
	@Override
	public void onPageScrollStateChanged(int arg0) {
		
	}

	// 当当前页面被滑动时调用
	@Override
	public void onPageScrolled(int arg0, float arg1, int arg2) {

	}

	// 当新的页面被选中时调用
	@Override
	public void onPageSelected(int arg0) {
	}

}
