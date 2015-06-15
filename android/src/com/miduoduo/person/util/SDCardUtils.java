package com.miduoduo.person.util;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;

import android.annotation.SuppressLint;
import android.content.Context;
import android.os.Build;
import android.os.Environment;
import android.os.StatFs;

/**
 * 操作SD卡的工具类
 * <p>
 * 备注：操作SD卡需要在AndroidManifest.xml添加相应的权限(android.permission.
 * WRITE_EXTERNAL_STORAGE和"android.permission.READ_EXTERNAL_STORAGE")
 */
public class SDCardUtils {

	/**
	 * 判断SD卡的状态：是否可用(是否挂载)
	 */
	public static boolean isSDCardEnable() {
		// 获取设备设主要的扩张存储设备的状态
		String storageState = Environment.getExternalStorageState();
		if (Environment.MEDIA_MOUNTED.equals(storageState)) {
			return true;
		}

		return false;
	}

	/**
	 * 得到SD卡的(绝对)路径
	 * 
	 * @return 返回“/storage/sdcard”
	 */
	public static String getSDCardPath() {
		if (isSDCardEnable()) {
			return Environment.getExternalStorageDirectory().getAbsolutePath();
		}
		return null;
	}

	/**
	 * 获取系统存储路径
	 * 
	 * @return 返回“/system”
	 */
	public static String getRootDirectoryPath() {
		if (isSDCardEnable()) {
			return Environment.getRootDirectory().getAbsolutePath();
		}
		return null;
	}

	/**
	 * 获取内部存储的路径
	 * 
	 * @return 返回“/storage/sdcard/Android/data/packageName/files/type”
	 */
	public static String getInternalPath(Context context, String type) {
		// Alarms:铃声；DCIM:;Movies:;Music:;
		// Download:;
		File file = context.getExternalFilesDir(type);
		return file.getAbsolutePath();

	}

	/**
	 * 计算SD卡的总大小
	 */
	@SuppressLint("NewApi")
	public static long getSdSize() {
		if (isSDCardEnable()) {
			// StatFs：包含文件系统空间信息的类
			StatFs statFs = new StatFs(getSDCardPath());
			// 得到SD卡块的数量
			long blockCount = statFs.getBlockCountLong();
			// 得到每个块的大小
			long blockSize = statFs.getBlockSizeLong();
			return blockCount * blockSize / 1024 / 1024;
		}
		return 0;
	}

	/**
	 * 计算指定目录可用空间的大小
	 * 
	 * @param path
	 * @return 指定目录可用空间的大小
	 */
	@SuppressWarnings("deprecation")
	@SuppressLint("NewApi")
	public static long getUsableSpace(File path) {
		if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.GINGERBREAD) {
			return path.getUsableSpace();
		}
		final StatFs stats = new StatFs(path.getPath());
		return (long) stats.getBlockSize() * (long) stats.getAvailableBlocks();
	}

	/**
	 * 计算SD卡的可用空间
	 */
	@SuppressLint("NewApi")
	public static long getAvailableSize() {
		if (isSDCardEnable()) {
			StatFs statFs = new StatFs(getSDCardPath());
			// 得到SD卡可用的块数
			long availableBlocks = statFs.getAvailableBlocksLong();
			long blockSize = statFs.getBlockSizeLong();
			return availableBlocks * blockSize / 1024 / 1024;
		}
		return 0;
	}

	/**
	 * 将某个文件存到SD卡中
	 */
	public static boolean saveDataIntoSD(byte[] data, String dir,
			String fileName) {
		if (isSDCardEnable()) {
			File file = new File(dir);
			BufferedOutputStream bos = null;
			// 判断目录是否存在
			if (!file.exists()) {
				// 如果不存在，则创建出来
				file.mkdir();
			}
			try {
				// 大管子套小管子--->效率更高一些
				bos = new BufferedOutputStream(new FileOutputStream(new File(
						file, fileName)));
				// 将文件写入到SD卡
				bos.write(data, 0, data.length);
				return true;
			} catch (FileNotFoundException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			} finally {
				if (bos != null) {
					try {
						bos.close();
					} catch (IOException e) {
						e.printStackTrace();
					}
				}
			}
		}
		return false;
	}

	/**
	 * 从SD卡中取出某个文件
	 * 
	 * @return
	 */
	public static InputStream getDataFromSD(String dir, String fileName) {
		if (isSDCardEnable()) {
			
			// 拼接文件的绝对路径
			String path = dir + File.separator + fileName;
			File file = new File(path);
			if (file.exists()) {
				ByteArrayOutputStream baos = null;
				BufferedInputStream bis = null;
				try {
					// 字节数组输出流：输出缓冲区中的内容
					baos = new ByteArrayOutputStream();
					// 输入流：将某个文件中的内容读取过来
					bis = new BufferedInputStream(new FileInputStream(file));
					int len = 0;
					byte[] buffer = new byte[1024];
					while ((len = bis.read(buffer)) != -1) {
						baos.write(buffer, 0, len);
						baos.flush();
					}
					// 返回文件内容
					return new ByteArrayInputStream(baos.toByteArray());
				} catch (FileNotFoundException e) {
					e.printStackTrace();
				} catch (IOException e) {
					e.printStackTrace();
				} finally {
					// 关闭流
					if (baos != null) {
						try {
							baos.close();
						} catch (IOException e) {
							e.printStackTrace();
						}
					}
					if (bis != null) {
						try {
							bis.close();
						} catch (IOException e) {
							e.printStackTrace();
						}
					}
				}
			}
		}
		return null;
	}

}
