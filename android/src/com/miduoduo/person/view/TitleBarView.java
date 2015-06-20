package com.miduoduo.person.view;

import android.content.Context;
import android.graphics.drawable.Drawable;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.widget.Button;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.miduoduo.person.R;
import com.miduoduo.person.util.SystemMethod;

public class TitleBarView extends RelativeLayout {

	private Context mContext;
	private Button btnLeft;
	private Button btnRight;
	private TextView tvCenter;

	public TitleBarView(Context context) {
		super(context);
		mContext = context;
		initView();
	}

	public TitleBarView(Context context, AttributeSet attrs) {
		super(context, attrs);
		mContext = context;
		initView();
	}

	private void initView() {
		LayoutInflater.from(mContext).inflate(R.layout.title_bar_view, this);
		btnLeft = (Button) findViewById(R.id.title_btn_left);
		btnRight = (Button) findViewById(R.id.title_btn_right);
		tvCenter = (TextView) findViewById(R.id.title_txt);

	}

	/** 设置标题栏各个控件是否显示 */
	public void setTitleBarViewVisibility(int LeftVisibility,
			int centerVisibility, int rightVisibility) {
		btnLeft.setVisibility(LeftVisibility);
		btnRight.setVisibility(rightVisibility);
		tvCenter.setVisibility(centerVisibility);

	}

	/** 设置标题栏中间的标题文本 */
	public void setTitleBarCenterTitle(CharSequence txt) {
		tvCenter.setText(txt);
	}

	/** 设置标题栏中间的标题文本 */
	public void setTitleBarCenterTitle(int txtResId) {
		tvCenter.setText(txtResId);
	}

	/** 设置标题栏左侧、中间、右侧的标题文本 */
	public void setTitleBarTitle(CharSequence leftTxt, CharSequence centerTxt,
			CharSequence rightTxt) {
		btnLeft.setText(leftTxt);
		tvCenter.setText(centerTxt);
		btnRight.setText(rightTxt);
	}

	/** 设置标题栏左侧、中间、右侧的标题文本 */
	public void setTitleBarTitle(int leftResId, int centerResId, int rightResId) {
		btnLeft.setText(leftResId);
		tvCenter.setText(centerResId);
		btnRight.setText(rightResId);
	}

	/** 设置标题栏左侧按钮的文本 */
	public void setTitleBarLeftTitle(int txtResId) {
		btnLeft.setText(txtResId);
	}

	/** 设置标题栏左侧按钮的文本 */
	public void setTitleBarLeftTitle(CharSequence txt) {
		btnLeft.setText(txt);
	}

	/** 设置标题栏左侧按钮的icon和文本 */
	public void setTitleBarLeftButton(int iconResId, int txtResId) {
		Drawable img = mContext.getResources().getDrawable(iconResId);
		int height = SystemMethod.dip2px(mContext, 20);
		int width = img.getIntrinsicWidth() * height / img.getIntrinsicHeight();
		img.setBounds(0, 0, width, height);
		btnLeft.setText(txtResId);
		btnLeft.setCompoundDrawables(img, null, null, null);
	}
	
	/** 设置标题栏左侧按钮的icon和文本 */
	public void setTitleBarLeftButton(int iconResId, String txtRes) {
		Drawable img = mContext.getResources().getDrawable(iconResId);
		int height = SystemMethod.dip2px(mContext, 20);
		int width = img.getIntrinsicWidth() * height / img.getIntrinsicHeight();
		img.setBounds(0, 0, width, height);
		btnLeft.setText(txtRes);
		btnLeft.setCompoundDrawables(img, null, null, null);
	}

	/** 设置标题栏左侧按钮的文本 */
	public void setTitleBarRightTitle(int txtResId) {
		btnRight.setText(txtResId);
	}

	/** 设置标题栏左侧按钮的文本 */
	public void setTitleBarRightTitle(CharSequence txt) {
		btnRight.setText(txt);
	}

	/** 设置标题栏右侧按钮的icon和文本 */
	public void setTitleBarRightButton(int iconResId, int txtResId) {
		Drawable img = mContext.getResources().getDrawable(iconResId);
		int height = SystemMethod.dip2px(mContext, 30);
		int width = img.getIntrinsicWidth() * height / img.getIntrinsicHeight();
		img.setBounds(0, 0, width, height);
		btnRight.setText(txtResId);
		btnRight.setCompoundDrawables(img, null, null, null);
	}
	
	/** 设置标题栏右侧按钮的icon和文本 */
	public void setTitleBarRightButton(int iconResId, String txtRes) {
		Drawable img = mContext.getResources().getDrawable(iconResId);
		int height = SystemMethod.dip2px(mContext, 30);
		int width = img.getIntrinsicWidth() * height / img.getIntrinsicHeight();
		img.setBounds(0, 0, width, height);
		btnRight.setText(txtRes);
		btnRight.setCompoundDrawables(img, null, null, null);
	}

	/** 设置标题栏左侧按钮的监听事件 */
	public void setTitleBarLeftBtnOnclickListener(OnClickListener listener) {
		btnLeft.setOnClickListener(listener);
	}

	/** 设置标题栏右侧按钮的监听事件 */
	public void setTitleBarRightBtnOnclickListener(OnClickListener listener) {
		btnRight.setOnClickListener(listener);
	}

	/** 将标题栏左侧和右侧的按钮和中间标题的文本置空 */
	public void destoryView() {
		btnLeft.setText(null);
		tvCenter.setText(null);
		btnRight.setText(null);
	}

}
