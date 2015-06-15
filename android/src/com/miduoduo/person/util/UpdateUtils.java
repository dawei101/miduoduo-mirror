package com.miduoduo.person.util;

import java.io.File;

import android.app.Activity;
import android.content.Intent;
import android.net.Uri;
import android.os.Environment;

public class UpdateUtils {

	/**
	 * 安装
	 */
	public static void installApp(Activity activity, String filePath) {

		Intent intent = new Intent(Intent.ACTION_VIEW);
		intent.setDataAndType(Uri.fromFile(new File(filePath)),
				"application/vnd.android.package-archive");
		activity.startActivity(intent);
	}

	/**
	 * 或得下载路径
	 */
	public static File getDownloadDirectory() {

		return Environment
				.getExternalStoragePublicDirectory(Environment.DIRECTORY_DOWNLOADS);
	}

	/**
	 * 截取URL地址最后部分的文件名
	 */
	public static String getDownloadFileName(String url) {
		String fileName = url.substring(url.lastIndexOf("/") + 1);
		return fileName;
	}
}
