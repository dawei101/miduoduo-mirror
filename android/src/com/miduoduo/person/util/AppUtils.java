package com.miduoduo.person.util;

import android.content.Context;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager.NameNotFoundException;

/**
 * <ul>
 * <li>类描述：获取应用信息的工具类
 * <li>创建时间： 2015-6-17 上午9:43:15
 * <li>创建人：liyunlong
 * </ul>
 */
public class AppUtils {

	/**
	 * 获取版本号
	 * 
	 * @param context
	 * @return
	 */
	public static int getVersionCode(Context context) {
		try {
			PackageInfo packageInfo = context.getPackageManager()
					.getPackageInfo(context.getPackageName(), 0);
			return packageInfo.versionCode;
		} catch (NameNotFoundException e) {
			e.printStackTrace();
			return 0;
		}
	}

	/**
	 * 获取版本号
	 * 
	 * @param context
	 * @return
	 */
	public static String getVersion(Context context) {
		try {
			PackageInfo packageInfo = context.getPackageManager()
					.getPackageInfo(context.getPackageName(), 0);
			return packageInfo.versionName;
		} catch (NameNotFoundException e) {
			e.printStackTrace();
			return "1.0";
		}
	}

	/**
	 * 获取包名
	 * 
	 * @param context
	 * @return
	 */
	public static String getPackageName(Context context) {
		try {
			PackageInfo packageInfo = context.getPackageManager()
					.getPackageInfo(context.getPackageName(), 0);
			return packageInfo.packageName;
		} catch (NameNotFoundException e) {
			e.printStackTrace();
			return "com.miduoduo.person";
		}
	}
}
