package com.miduoduo.person.util;

import android.util.Log;

/**
 * <ul>
 * <li>类描述：Log统一管理类
 * <li>创建时间： 2015-6-3 下午2:56:20
 * <li>创建人：liyunlong
 * </ul>
 */
public class LogUtils {

	/** 是否需要打印bug */
	private static boolean isDebug = true;
	private static final String TAG = "TAG";

	//********** 下面四个是默认tag的函数 **********/
	
	public static void i(String msg) {
		if (isDebug)
			Log.i(TAG, msg);
	}

	public static void d(String msg) {
		if (isDebug)
			Log.d(TAG, msg);
	}

	public static void e(String msg) {
		if (isDebug)
			Log.e(TAG, msg);
	}

	public static void v(String msg) {
		if (isDebug)
			Log.v(TAG, msg);
	}

	//**********  下面是传入自定义tag的函数 **********/
	
	public static void i(String tag, String msg) {
		if (isDebug)
			Log.i(tag, msg);
	}

	public static void d(String tag, String msg) {
		if (isDebug)
			Log.i(tag, msg);
	}

	public static void e(String tag, String msg) {
		if (isDebug)
			Log.i(tag, msg);
	}

	public static void v(String tag, String msg) {
		if (isDebug)
			Log.i(tag, msg);
	}
}