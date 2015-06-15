package com.miduoduo.person.util;

import java.util.regex.Pattern;

public class Utils {

	private static Pattern phoneNumPattern;
	private static Pattern emailPattern;

	static {
		/*
		 * 移动：134、135、136、137、138、139、150、151、157(TD)、158、159、187、188
		 * 联通：130、131、132、152、155、156、185、186 电信：133、153、180、189、（1349卫通）
		 * 总结起来就是第一位必定为1，第二位必定为3或5或8，其他位置的可以为0-9
		 */
		// "[1]"代表第1位为数字1，"[358]"代表第二位可以为3、5、8中的一个，"\\d{9}"代表后面是可以是0～9的数字，有9位。
		phoneNumPattern = Pattern.compile("^1[358]\\d{9}$");
		emailPattern = Pattern
				.compile("\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*");
	}

	/**
	 * 验证字符串是否为空
	 */
	public static boolean isEmpty(CharSequence str) {
		if (str == null || str.length() == 0)
			return true;
		else
			return false;
	}

	/**
	 * 验证是否为手机号
	 */
	public static boolean isPhone(CharSequence phoneNum) {
		return !isEmpty(phoneNum)
				&& phoneNumPattern.matcher(phoneNum).matches();
	}

	/**
	 * 验证是否为Email地址
	 */
	public static boolean isEmail(CharSequence email) {
		return !isEmpty(email) && emailPattern.matcher(email).matches();
	}
}
