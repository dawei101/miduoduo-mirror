package com.miduoduo.person.util;

import android.app.ProgressDialog;
import android.content.Context;

/**
 * <ul>
 * <li>类描述：加载动画的工具类
 * <li>创建人：liyunlong
 * <li>创建时间：2015-3-19 下午12:57:09
 * </ul>
 */
public class DialogUtils {

	/**
	 * 加载动画
	 */
	// public static Dialog getLoadingAnim(Context context) {
	//
	// // 自定义对话框样式
	// Dialog dialog = new Dialog(context, R.style.loading);
	// // 此处布局为一个progressbar
	// dialog.setContentView(R.layout.loading_process_dialog_anim);
	// dialog.setCancelable(true); // 是否可以取消
	// dialog.setCanceledOnTouchOutside(false);
	// return dialog;
	// }
	
	/**
	 * 加载对话框
	 */
	public static ProgressDialog getLoadingDialog(Context context){
		ProgressDialog dialog = new ProgressDialog(context);
		
		// setIcon(R.drawable.dialogicon);
		// setTitle("温馨提示");
		dialog.setMessage("正在加载");
		dialog.setCanceledOnTouchOutside(false);
		return dialog;
	}
	
	/**
	 * 加载对话框
	 */
	public static ProgressDialog getDialog(Context context){
		ProgressDialog dialog = new ProgressDialog(context);
		dialog.setTitle("下载");
		dialog.setMessage("正在下载，请稍后...");
		dialog.setProgressStyle(ProgressDialog.STYLE_HORIZONTAL);
		dialog.setCanceledOnTouchOutside(false);
		dialog.setCancelable(true);// 设置点击进度条外部，不响应
		return dialog;
	}
}
