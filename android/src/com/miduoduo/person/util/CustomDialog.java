package com.miduoduo.person.util;


import com.miduoduo.person.R;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup.LayoutParams;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

/**
 * 自定义对话框
 * 
 * @author：liyunlong
 * @since：2015-5-11 下午4:40:40
 */
public class CustomDialog extends Dialog {

	public CustomDialog(Context context) {
		super(context);
	}

	public CustomDialog(Context context, int theme) {
		super(context, theme);
	}

	public static class Builder {
		/* 上下文对象 */
		private Context context;
		/* 对话框标题 */
		private String title;
		/* 对话框内容 */
		private String message;
		/* 【确定】按钮名称 */
		private String confirmBtnText;
		/* 【取消】按钮名称 */
		private String cancelBtnText; 
		/* 对话框中间加载的其他布局界面 */
		private View contentView;
		/* 【确定】按钮监听事件 */
		private DialogInterface.OnClickListener confirmBtnClickListener;
		/* 【取消】按钮监听事件 */
		private DialogInterface.OnClickListener cancelBtnClickListener;

		public Builder(Context context) {
			this.context = context;
		}

		/** 设置对话框的提示信息 */
		public Builder setMessage(String message) {
			this.message = message;
			return this;
		}

		/** 设置对话框的提示信息 */
		public Builder setMessage(int message) {
			this.message = (String) context.getText(message);
			return this;
		}

		/** 设置对话框的标题 */
		public Builder setTitle(int title) {
			this.title = (String) context.getText(title);
			return this;
		}

		/** 设置对话框的标题 */
		public Builder setTitle(String title) {
			this.title = title;
			return this;
		}

		/** 设置对话框自定义界面 */
		public Builder setContentView(View v) {
			this.contentView = v;
			return this;
		}

		/** 设置确定按钮的文本和点击监听 */
		public Builder setPositiveButton(int confirmBtnText,
				DialogInterface.OnClickListener listener) {
			this.confirmBtnText = (String) context.getText(confirmBtnText);
			this.confirmBtnClickListener = listener;
			return this;
		}

		/** 设置确定按钮的文本和点击监听 */
		public Builder setPositiveButton(String confirmBtnText,
				DialogInterface.OnClickListener listener) {
			this.confirmBtnText = confirmBtnText;
			this.confirmBtnClickListener = listener;
			return this;
		}

		/** 设置取消按钮的文本和点击监听 */
		public Builder setNegativeButton(int cancelBtnText,
				DialogInterface.OnClickListener listener) {
			this.cancelBtnText = (String) context.getText(cancelBtnText);
			this.cancelBtnClickListener = listener;
			return this;
		}

		/** 设置取消按钮的文本和点击监听 */
		public Builder setNegativeButton(String cancelBtnText,
				DialogInterface.OnClickListener listener) {
			this.cancelBtnText = cancelBtnText;
			this.cancelBtnClickListener = listener;
			return this;
		}

		/** 创建对话框 */
		public CustomDialog create() {
			LayoutInflater inflater = (LayoutInflater) context
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			// 根据自定义主题初始化对话框
			final CustomDialog dialog = new CustomDialog(context,
					R.style.customdialogstyle);
			// 对话框布局
			View layout = inflater.inflate(R.layout.customdialog, null);
			dialog.addContentView(layout, new LayoutParams(
					LayoutParams.MATCH_PARENT, LayoutParams.WRAP_CONTENT));
			
			// 设置对话框【标题】
			setTitle(layout);
			
			// 设置对话框【确定】按钮
			setConfirmButton(dialog, layout);
			
			// 设置对话框【取消】按钮
			setCancelButton(dialog, layout);
			
			// 设置对话框【提示信息】或【自定义布局】
			setMessageOrContentView(layout);
			
			dialog.setContentView(layout);
			dialog.setCancelable(true);
			return dialog;
		}

		/** 设置对话框【标题】 */
		private void setTitle(View layout) {
			((TextView) layout.findViewById(R.id.customdialog_title))
					.setText(title);
			// 设置对话框【标题】加粗
			// ((TextView) layout.findViewById(R.id.customdialog_title))
			// .getPaint().setFakeBoldText(true);
		}
		
		/** 设置对话框【提示信息】或【自定义布局】 */
		private void setMessageOrContentView(View layout) {
			// 对话框【提示信息】不为空
			if (message != null) {
				((TextView) layout.findViewById(R.id.customdialog_message))
						.setText(message);
			} else if (contentView != null) {
				// 设置对话框自定义界面
				((LinearLayout) layout.findViewById(R.id.customdialog_message))
						.removeAllViews();
				((LinearLayout) layout.findViewById(R.id.customdialog_message))
						.addView(contentView, new LayoutParams(
								LayoutParams.WRAP_CONTENT,
								LayoutParams.WRAP_CONTENT));
			}
		}
		
		/** 设置对话框【取消】按钮 */
		private void setCancelButton(final CustomDialog dialog, View layout) {
			// 如果取消按钮文本不为空
			if (cancelBtnText != null) {
				Button cancelBtn = ((Button) layout
						.findViewById(R.id.customdialog_cancel_btn));
				cancelBtn.setText(cancelBtnText);
				if (cancelBtnClickListener != null) {
					cancelBtn.setOnClickListener(new View.OnClickListener() {
						public void onClick(View v) {
							cancelBtnClickListener.onClick(dialog,
									DialogInterface.BUTTON_NEGATIVE);
							dialog.dismiss();
						}
					});
				} else {
					cancelBtn.setOnClickListener(new View.OnClickListener() {
						public void onClick(View v) {
							dialog.dismiss();
						}
					});
				}
			} else {
				// 如果取消按钮文本为空，则不显示取消按钮和分隔线
				layout.findViewById(R.id.customdialog_cancel_btn)
						.setVisibility(View.GONE);
				layout.findViewById(R.id.customdialog_divideline)
						.setVisibility(View.GONE);
				layout.findViewById(R.id.customdialog_confirm_btn)
						.setBackgroundResource(
								R.drawable.customdialog_one_btn_bg);
			}
		}

		/** 设置对话框【确定】按钮 */
		private void setConfirmButton(final CustomDialog dialog, View layout) {
			// 如果确定按钮文本不为空
			if (confirmBtnText != null) {
				Button confirmBtn = ((Button) layout
						.findViewById(R.id.customdialog_confirm_btn));
				confirmBtn.setText(confirmBtnText);
				if (confirmBtnClickListener != null) {
					confirmBtn.setOnClickListener(new View.OnClickListener() {
						public void onClick(View v) {
							confirmBtnClickListener.onClick(dialog,
									DialogInterface.BUTTON_POSITIVE);
							dialog.dismiss();
						}
					});
				} else {
					confirmBtn.setOnClickListener(new View.OnClickListener() {
						public void onClick(View v) {
							dialog.dismiss();
						}
					});
				}
			} else {
				// 如果确定按钮文本为空，则不显示确定按钮和分隔线
				layout.findViewById(R.id.customdialog_confirm_btn)
						.setVisibility(View.GONE);
				layout.findViewById(R.id.customdialog_divideline)
						.setVisibility(View.GONE);
				layout.findViewById(R.id.customdialog_cancel_btn)
				.setBackgroundResource(
						R.drawable.customdialog_one_btn_bg);
			}
		}

	}
}
