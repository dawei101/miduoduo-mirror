package com.miduoduo.person.util;

import java.io.File;

import android.annotation.SuppressLint;
import android.content.Context;
import android.util.Log;
import android.webkit.WebSettings;
import android.webkit.WebSettings.RenderPriority;
import android.webkit.WebView;

/**
 * <ul>
 * <li>类描述：WebView缓存工具类
 * <li>创建时间： 2015-6-17 上午10:54:19
 * <li>创建人：liyunlong
 * </ul>
 */
public class WebViewUtils {

	public static final String APP_CACAHE_DIRNAME = "/webcache";
	public static final long APP_CACHE_MAX_SIZE = Runtime.getRuntime()
			.maxMemory() / 4;

	/**
	 * 得到WebView缓存路径
	 * 
	 * @param context
	 * @return
	 */
	public static String getWebViewFilesDir(Context context) {
		return context.getFilesDir().getAbsolutePath() + APP_CACAHE_DIRNAME;
	}

	/**
	 * 设置WebSettings
	 * 
	 * @param context
	 * @param webView
	 */
	@SuppressWarnings("deprecation")
	@SuppressLint("SetJavaScriptEnabled")
	public static void initWebSettings(Context context, WebView webView) {

		WebSettings settings = webView.getSettings();
		settings.setJavaScriptEnabled(true);
		settings.setAllowContentAccess(true);// 设置WebView的内容是否可以访问
		settings.setJavaScriptEnabled(true);// 设置WebView是否可以执行JavaScript脚本程序
		settings.setBuiltInZoomControls(true);// 设置WebView是否使用再带的缩放机制
		settings.setDisplayZoomControls(true);// 设置WebView在网页上显示缩放工具
		settings.setDefaultZoom(WebSettings.ZoomDensity.FAR);// html页面大小自适应
		settings.setRenderPriority(RenderPriority.HIGH);
		// 建议缓存策略为，判断是否有网络，有的话，使用LOAD_DEFAULT,无网络时，使用LOAD_CACHE_ELSE_NETWORK
		// settings.setCacheMode(WebSettings.LOAD_CACHE_ELSE_NETWORK); // 设置缓存模式
		// settings.setDomStorageEnabled(true);// 开启 DOM storage API 功能
		// settings.setDatabaseEnabled(true);// 开启 database storage API 功能
		// settings.setAppCacheEnabled(true);// 开启 Application Caches
		// // 功能(H5缓存)，默认关闭，即H5的缓存无法使用
		// settings.setAllowFileAccess(true); // 可以读取文件缓存(manifest生效)
		// String cacheDirPath = getWebViewFilesDir(context);// 缓存路径
		// Log.i("TAG", "cacheDirPath=" + cacheDirPath);
		// settings.setDatabasePath(cacheDirPath);// 设置数据库缓存路径
		// settings.setAppCachePath(cacheDirPath);// 设置 Application Caches 缓存目录
		// settings.setAppCacheMaxSize(APP_CACHE_MAX_SIZE);// 设置 Application
		// Caches
		// // 缓存最大容量(运行内存的1/4)
		webView.requestFocus();// 设置触摸焦点起作用
		webView.setScrollBarStyle(WebView.SCROLLBARS_OUTSIDE_OVERLAY);// 取消滚动条
	}

	/**
	 * 清除WebView缓存
	 */
	public static void clearWebViewCache(Context context) {

		// 清理Webview缓存数据库
		try {
			context.deleteDatabase("webview.db");
			context.deleteDatabase("webviewCache.db");
		} catch (Exception e) {
			e.printStackTrace();
		}

		// WebView 缓存文件
		File appCacheDir = new File(getWebViewFilesDir(context));
		// File webviewCacheDir = new
		// File(context.getCacheDir().getAbsolutePath()
		// + "/webviewCache");
		// // 删除webview 缓存目录
		// if (webviewCacheDir.exists()) {
		// deleteFile(webviewCacheDir);
		// }
		// 删除webview 缓存 缓存目录
		if (appCacheDir.exists()) {
			deleteFile(appCacheDir);
		}
	}

	/**
	 * 递归删除 文件/文件夹
	 * 
	 * @param file
	 */
	public static void deleteFile(File file) {

		Log.i("TAG", "delete file path=" + file.getAbsolutePath());

		if (file.exists()) {
			if (file.isFile()) {
				file.delete();
			} else if (file.isDirectory()) {
				File files[] = file.listFiles();
				for (int i = 0; i < files.length; i++) {
					deleteFile(files[i]);
				}
			}
			file.delete();
		} else {
			Log.e("TAG", "delete file no exists " + file.getAbsolutePath());
		}
	}
}
