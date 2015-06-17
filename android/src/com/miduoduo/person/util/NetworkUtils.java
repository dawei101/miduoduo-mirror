package com.miduoduo.person.util;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.NetworkInfo.State;
import android.provider.Settings;

/**
 * 判断网络状态的工具类
 * <p>
 * 备注：判断网络状态需要在AndroidManifest.xml添加相应的权限(android.permission.
 * ACCESS_NETWORK_STATE)，否则会报安全性异常(java.lang.SecurityException)
 */
public class NetworkUtils {

	/**
	 * 判断网络是否可以使用
	 * 
	 * @param context
	 * @return
	 */
	public static boolean isNetAvailable(Context context) {
		// ConnectivityManager：网络连接管理器，有如下作用：
		// ①.监视网络连接(Wi-Fi, GPRS, UMTS, etc.)
		// ②.当网络状态发生改变的时候，发出一个广播意图
		// ③.当一个网络连接丢失的时候，尝试着转移到另一个网络中(fail over-->故障转移)
		// ④.提供了一套API，供我们开发的时候监测网络状态的好与坏
		// ⑤.提供了一套API，供我们用来请求与查询与网络相关的数据
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		// 得到的是可用的网络信息
		NetworkInfo activeNetworkInfo = manager.getActiveNetworkInfo();
		// 判断网络是否可用
		if (activeNetworkInfo != null && activeNetworkInfo.isAvailable()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 判断网络是否已连接
	 * 
	 * @param context
	 */
	public static boolean isNetConnected(Context context) {

		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);

		if (null != manager) {

			NetworkInfo activeNetworkInfo = manager.getActiveNetworkInfo();
			if (null != activeNetworkInfo && activeNetworkInfo.isConnected()) {
				if (activeNetworkInfo.getState() == NetworkInfo.State.CONNECTED) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * 判断WiFi是否可用
	 * 
	 * @param context
	 * @return
	 */
	public static boolean isWiFiAvailable(Context context) {
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		// 得到与WiFi相关的网络信息
		NetworkInfo networkInfo = manager
				.getNetworkInfo(ConnectivityManager.TYPE_WIFI);
		if (networkInfo != null) {
			// 判断网络是否可用
			return networkInfo.isAvailable();
		}
		return false;
	}

	/**
	 * 判断WiFi是否已连接
	 * 
	 * @param context
	 * @return
	 */
	public static boolean isWiFiConnected(Context context) {
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		// 得到与WiFi相关的网络信息
		NetworkInfo networkInfo = manager
				.getNetworkInfo(ConnectivityManager.TYPE_WIFI);
		if (networkInfo != null) {
			// 判断网络是否已连接
			return networkInfo.isConnected();
		}
		return false;
	}

	/**
	 * 获得WiFi的连接状态
	 * 
	 * @param context
	 * @return 返回当前网络连接的状态(CONNECTING, CONNECTED, SUSPENDED, DISCONNECTING,
	 *         DISCONNECTED, UNKNOWN)
	 */
	public static State getWiFiNetState(Context context) {
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		// 得到与WiFi相关的网络信息
		NetworkInfo networkInfo = manager
				.getNetworkInfo(ConnectivityManager.TYPE_WIFI);
		if (networkInfo != null) {
			// 得到当前网络的连接状态
			return networkInfo.getState();
		}
		return null;
	}

	/**
	 * 判断Mobile是否可用
	 * 
	 * @param context
	 * @return
	 */
	public static boolean isMobileAvailable(Context context) {
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		// 得到与手机网络相关的网络信息
		NetworkInfo networkInfo = manager
				.getNetworkInfo(ConnectivityManager.TYPE_MOBILE);
		if (networkInfo != null) {
			// 判断网络是否可用
			return networkInfo.isAvailable();
		}
		return false;
	}

	/**
	 * 判断Mobile是否已连接
	 * 
	 * @param context
	 * @return
	 */
	public static boolean isMobileConnected(Context context) {
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		// 得到与手机网络相关的网络信息
		NetworkInfo networkInfo = manager
				.getNetworkInfo(ConnectivityManager.TYPE_MOBILE);
		if (networkInfo != null) {
			// 判断网络是否已连接
			return networkInfo.isConnected();
		}
		return false;
	}

	/**
	 * 获得Mobile的连接状态
	 * 
	 * @param context
	 * @return 返回当前网络连接的状态(CONNECTING, CONNECTED, SUSPENDED, DISCONNECTING,
	 *         DISCONNECTED, UNKNOWN)
	 */
	public static State getMobileNetState(Context context) {
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		// 得到与Mobile相关的网络信息
		NetworkInfo networkInfo = manager
				.getNetworkInfo(ConnectivityManager.TYPE_MOBILE);
		if (networkInfo != null) {
			// 得到当前网络的连接状态
			return networkInfo.getState();
		}
		return null;
	}

	/**
	 * 判断Bluetooth是否可用
	 * 
	 * @param context
	 * @return
	 */
	public static boolean isBluetoothAvailable(Context context) {
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		// 得到与蓝牙相关的网络信息
		NetworkInfo networkInfo = manager
				.getNetworkInfo(ConnectivityManager.TYPE_BLUETOOTH);
		if (networkInfo != null) {
			// 判断网络是否可用
			return networkInfo.isAvailable();
		}
		return false;
	}

	/**
	 * 判断Bluetooth是否已连接
	 * 
	 * @param context
	 * @return
	 */
	public static boolean isBluetoothConnected(Context context) {
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		// 得到与蓝牙相关的网络信息
		NetworkInfo networkInfo = manager
				.getNetworkInfo(ConnectivityManager.TYPE_BLUETOOTH);
		if (networkInfo != null) {
			// 判断网络是否已连接
			return networkInfo.isConnected();
		}
		return false;
	}

	/**
	 * 获得Bluetooth的连接状态
	 * 
	 * @param context
	 * @return 返回当前网络连接的状态(CONNECTING, CONNECTED, SUSPENDED, DISCONNECTING,
	 *         DISCONNECTED, UNKNOWN)
	 */
	public static State getBluetoothNetState(Context context) {
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		// 得到与Bluetooth相关的网络信息
		NetworkInfo networkInfo = manager
				.getNetworkInfo(ConnectivityManager.TYPE_BLUETOOTH);
		if (networkInfo != null) {
			// 得到当前网络的连接状态
			return networkInfo.getState();
		}
		return null;
	}

	/**
	 * 判断当前的网络类型--->WiFi还是Mobile
	 * 
	 * @param context
	 * @return 返回一个描述网络类型的可读名称,例如“Mobile”或“WiFi”
	 */
	public static String getNetTypeName(Context context) {
		ConnectivityManager manager = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		NetworkInfo activeNetworkInfo = manager.getActiveNetworkInfo();
		// 如果网络可以并已连接
		if (activeNetworkInfo != null && activeNetworkInfo.isConnected()) {
			// 得到当前的网络类型(0代表MOBILE；1代表WIFI)
			// String typeName = activeNetworkInfo.getTypeName();
			return activeNetworkInfo.getTypeName();
		}
		return null;
	}

	/**
	 * 打开网络设置界面
	 * 
	 * @param activity
	 */
	public static void openNetSetting(Activity activity) {
		Intent intent = new Intent(Settings.ACTION_WIRELESS_SETTINGS);
		// intent.setAction("android.intent.action.VIEW");
		activity.startActivityForResult(intent, 0);
	}

}
