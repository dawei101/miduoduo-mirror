package com.miduoduo.person.util;

import android.content.Context;
import android.telephony.CellLocation;
import android.telephony.TelephonyManager;

/**
 * <ul>
 * <li>类描述：手机SIM卡信息工具类
 * <li>创建时间： 2015-6-17 下午3:45:58
 * <li>创建人：liyunlong
 * <li>备注：需要权限需要加入权限"android.permission.READ_PHONE_STATE"
 * </ul>
 */
public class TelephonyUtils {

	/**
	 * TelephonyManager提供设备上获取通讯服务信息的入口。 应用程序可以使用这个类方法确定的电信服务商和国家 以及某些类型的用户访问信息。
	 * 应用程序也可以注册一个监听器到电话收状态的变化。不需要直接实例化这个类
	 * 使用Context.getSystemService(Context.TELEPHONY_SERVICE)来获取这个类的实例。
	 */
	public static TelephonyManager getTelephonyManager(Context context) {
		return (TelephonyManager) context
				.getSystemService(Context.TELEPHONY_SERVICE);
	}

	/**
	 * 获取智能设备唯一编号
	 */
	public static String getDeviceId(Context context) {
		return getTelephonyManager(context).getDeviceId();
	}
	
	/**
	 * 获取当前设置的电话号码
	 */
	public static String getNativePhoneNumber(Context context) {
		return getTelephonyManager(context).getLine1Number();
	}
	
	/**
	 * 获得SIM卡的序号
	 */
	public static String getSimSerialNumber(Context context) {
		return getTelephonyManager(context).getSimSerialNumber();
	}
	
	/**
	 * 获取设备的当前位置
	 */
	public static CellLocation getCellLocation(Context context) {
		return getTelephonyManager(context).getCellLocation();
	}
	
	/**
	 * 获取唯一的用户ID，即这张卡的编号(国际移动用户识别码)
	 */
	public static String getSubscriberId(Context context) {
		return getTelephonyManager(context).getSubscriberId();
	}
	
	/**
     * 获取手机服务商信息
     */
    public static String getProvidersName(Context context) {
        String ProvidersName = null;
        // 返回唯一的用户ID，即这张卡的编号(国际移动用户识别码)
        String IMSI = getSubscriberId(context);
        // IMSI号前面3位460是国家，紧接着后面2位00 02是中国移动，01是中国联通，03是中国电信。
        System.out.println(IMSI);
        if (IMSI.startsWith("46000") || IMSI.startsWith("46002")) {
            ProvidersName = "中国移动";
        } else if (IMSI.startsWith("46001")) {
            ProvidersName = "中国联通";
        } else if (IMSI.startsWith("46003")) {
            ProvidersName = "中国电信";
        }
        return ProvidersName;
    }

}
