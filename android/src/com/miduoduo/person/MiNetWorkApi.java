package com.miduoduo.person;

public class MiNetWorkApi {

	/** base url */
	private static String apiBaseUrl = "http://api.chongdd.cn/v1/";

	/** 获取验证码 */
	private static String apiUserVcode = "auth/vcode";
	/** 登陆 */
	private static String apiUserVlogin = "auth/vlogin";

	public static String getApiBaseUrl() {
		return apiBaseUrl;
	}

	public static String getApiUserVcode() {
		return apiBaseUrl + apiUserVcode;
	}

	public static String getApiUserVlogin() {
		return apiBaseUrl + apiUserVlogin;
	}

}
