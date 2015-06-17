package com.miduoduo.person;

/**
 * <ul>
 * <li>类描述：常量类
 * <li>创建时间： 2015-5-20 下午3:21:49
 * <li>创建人：liyunlong
 * </ul>
 */
public class Constants {

	/** 网络请求地址 */
	public static class RequestUrl {
		/** 服务器端版本信息 */
		public static final String SERVERURL = "";
	}

	/** 网络请求类型 */
	public static class RequestType {
		/** 文本请求类型 */
		public static final short TEXT = 1;
		/** 图片请求类型 */
		public static final short IMAGE = 2;
		/** 查看详情的请求类型 */
		public static final short DETAIL = 3;
	}

	/** 字符串文本 */
	public static class Config {
		/** 是否第一次运行 */
		public static final String ISFIRSTRUN = "isFirstRun";
		/** 常驻通知栏 */
		public static final String RESIDENTNOTIFICATION = "residentNotification";
		/** 检查网络 */
		public static final String CHECKNETWORK = "checkNetwork";
		/** 是否缓存 */
		public static final String ENABLECACHE = "enableCache";
		/** 是否登录 */
		public static final String CHECKISLOGIN = "isLogin";
		/** 用户名 */
		public static final String USERNAME = "userName";
		/** 用户头像路径 */
		public static final String USERHEADPATH = "userHeadPath";
	}

	/** 性别 */
	public static class SexType {
		/** 默认性别 */
		public static final short DEFAULT = 0;
		/** 男性 */
		public static final short MALE = 1;
		/** 女性 */
		public static final short FEMALE = 2;
	}
	
	/** 时间日起格式 */
	public static class DateTimeFormat {
		/** 日起格式：yyyy-MM-dd */
		public static final String DATEFORMAT = "yyyy-MM-dd";
		/** 时间格式：yyyy-MM-dd HH:mm:ss */
		public static final String TIMEFORMAT = "yyyy-MM-dd HH:mm:ss";
	}
	
	/** 模块 */
	public static class Module {
		/** 待确认 */
		public static final short ToBeConfirmed = 0;
		/**未开始 */
		public static final short NotBeginning = 1;
		/** 正在进行 */
		public static final short InProgress = 2;
	}
}
