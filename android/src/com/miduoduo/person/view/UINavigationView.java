package com.miduoduo.person.view;

import android.content.Context;
import android.content.res.TypedArray;
import android.graphics.Color;
import android.util.AttributeSet;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.miduoduo.person.R;

public class UINavigationView extends LinearLayout {

	private Button btn_left;
	private Button btn_right;
	private TextView tv_title;
	private String strBtnLeft;
	private String strBtnRight;
	private String strTitle;
	private int left_drawable;
	private int right_drawable;
	
	private boolean btnLeftHidden = false;
	
	private OnClickListener listener = null;

	public UINavigationView(Context context) {
		super(context);
		initContent();
	}

	public UINavigationView(Context context, AttributeSet attrs) {
		super(context, attrs);
		initAttributes(attrs);
		initContent();
	}

	private void initAttributes(AttributeSet attributeSet) {

		if (null != attributeSet) {

			final int attrIds[] = new int[] {R.attr.btn_left_hidden, R.attr.btn_leftText,
					R.attr.btn_rightText, R.attr.tv_title,
					R.attr.left_drawable, R.attr.right_drawable };

			Context context = getContext();

			TypedArray array = context.obtainStyledAttributes(attributeSet,
					attrIds);

			btnLeftHidden = array.getBoolean(0, false);
			CharSequence t1 = array.getText(1);
			CharSequence t2 = array.getText(2);
			CharSequence t3 = array.getText(3);
			left_drawable = array.getResourceId(4, 0);
			right_drawable = array.getResourceId(5, 0);

			array.recycle();

			if (null != t1) {
				strBtnLeft = t1.toString();
			}
			if (null != t2) {
				strBtnRight = t2.toString();

			}
			if (null != t3) {
				strTitle = t3.toString();
			}

			Log.i("coder", "t1 = " + t1);
			Log.i("coder", "t2 = " + t2);
			Log.i("coder", "t3 = " + t3);
			Log.i("coder", "left_res = " + left_drawable);
		}

	}

	private void initContent() {

		// 设置水平方向
		setOrientation(HORIZONTAL);
		setGravity(Gravity.CENTER_VERTICAL);
		// 设置背景
		
		setBackgroundColor(getResources().getColor(R.color.navigation_bg_color));
		Context context = getContext();
	
		btn_left = new Button(context);
		if (left_drawable != 0) {
			btn_left.setBackgroundResource(left_drawable);
		} else {

			btn_left.setBackgroundResource(R.drawable.ic_back);// 设置背景
		}
		
		btn_left.setOnClickListener(new View.OnClickListener() {
			
			@Override
			public void onClick(View v) {
				if (listener != null) {
					listener.onClick(v, true);
				}
				
			}
		});
		
		if (null != strBtnLeft) {
			LayoutParams btnLeftParams = new LayoutParams(
					LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT);
			btnLeftParams.setMargins(20, 0, 0, 0);
			btn_left.setLayoutParams(btnLeftParams);
			btn_left.setText(strBtnLeft);
			btn_left.setTextColor(Color.BLACK);// 字体颜色
			btn_left.setBackgroundColor(Color.TRANSPARENT);
		} else {
			LayoutParams btnLeftParams = new LayoutParams(13,21);
			btnLeftParams.setMargins(20, 0, 0, 0);
			btn_left.setLayoutParams(btnLeftParams);
		}
		if (btnLeftHidden == false) {
			addView(btn_left);
		}
		

		tv_title = new TextView(context);
		LayoutParams centerParam = new LayoutParams(0,
				LayoutParams.MATCH_PARENT);
		centerParam.weight = 1;
		tv_title.setLayoutParams(centerParam);
		tv_title.setTextColor(Color.BLACK);
		if (null != strTitle) {
			tv_title.setText(strTitle);
		}
		
		tv_title.setGravity(Gravity.CENTER);
		addView(tv_title);

		btn_right = new Button(context);
		
		btn_right.setTextColor(Color.BLACK);// 字体颜色
		if (right_drawable != 0) {
			btn_right.setBackgroundResource(right_drawable);
		} else {
			btn_right.setVisibility(View.INVISIBLE);
		}
		if (null != strBtnRight) {

			LayoutParams btnRightParams = new LayoutParams(
					LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT);
			btnRightParams.setMargins(0, 0, 10, 0);
			btn_right.setLayoutParams(btnRightParams);
			btn_right.setBackgroundColor(Color.TRANSPARENT);
			btn_right.setText(strBtnRight);
			btn_right.setVisibility(View.VISIBLE);
		} else {
			btn_right.setLayoutParams(new LayoutParams(30, 30));
		}

		btn_right.setOnClickListener(new View.OnClickListener() {
			
			@Override
			public void onClick(View v) {
				if(listener != null)
					listener.onClick(v, false);
			}
		});
		// 添加这个按钮
		addView(btn_right);

	}

	public Button getBtn_left() {
		return btn_left;
	}

	public Button getBtn_right() {
		return btn_right;
	}

	public TextView getTv_title() {
		return tv_title;
	}

	public String getStrBtnLeft() {
		return strBtnLeft;
	}

	public void setStrBtnLeft(String strBtnLeft) {
		this.strBtnLeft = strBtnLeft;
	}

	public String getStrBtnRight() {
		return strBtnRight;
	}

	public void setStrBtnRight(String strBtnRight) {
		this.strBtnRight = strBtnRight;
	}

	public String getStrTitle() {
		return strTitle;
	}

	public void setStrTitle(String strTitle) {
		this.strTitle = strTitle;
	}

	public int getLeft_drawable() {
		return left_drawable;
	}

	public void setLeft_drawable(int left_drawable) {
		this.left_drawable = left_drawable;
	}

	public int getRight_drawable() {
		return right_drawable;
	}

	public void setRight_drawable(int right_drawable) {
		this.right_drawable = right_drawable;
	}
	
	public void setListener(OnClickListener listener) {
		this.listener = listener;
	}
	
	public static interface OnClickListener {
        /**
         * Called when a view has been clicked.
         *
         * @param v The view that was clicked.
         */
        void onClick(View v,boolean isLeft);
    }

}