package com.miduoduo.person.cache;

import java.io.File;
import java.io.FilenameFilter;
import java.io.InputStream;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.Collections;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.Map.Entry;

import android.content.Context;
import android.util.Log;

import com.miduoduo.person.util.Base64;
import com.miduoduo.person.util.SDCardUtils;

/**
 * 文件LRU缓存
 */
public class FileLruCache {
	public static final String APP_CACAHE_DIRNAME = "/webcache";
	public static final long APP_CACHE_MAX_SIZE = Runtime.getRuntime()
			.maxMemory() / 4;
	private static final String TAG = "DiskLruCache";

	/** 缓存文件名的前缀 */
	private static final String CACHE_FILENAME_PREFIX = "";

	/** 每次移除磁盘中的缓存容量最大值 */
	private static final int MAX_REMOVALS = 4;

	/** 缓存路径 */
	private final File mCacheDir;

	/** 缓存容器mLinkedHashMap中缓存的数量 */
	private int cacheSize = 0;

	/** 缓存的大小 */
	private int cacheByteSize = 0;

	/** 缓存容器mLinkedHashMap中缓存数量的最大值 */
	private final int maxCacheItemSize = 5000;

	/** 默认的缓存空间最大值(5Mb) */
	private long maxCacheByteSize = 1024 * 1024 * 5;

	private static final int INITIAL_CAPACITY = 32;
	private static final float LOAD_FACTOR = 0.75f;

	/**
	 * 缓存容器：LinkedHashMap支持两种排序：插入顺序、访问顺序。前者是指按照插入时的顺序排序，后者是指按照最旧使用到最近使用的顺序。
	 */
	private final Map<String, String> mLinkedHashMap = Collections
			.synchronizedMap(new LinkedHashMap<String, String>(
					INITIAL_CAPACITY, LOAD_FACTOR, true));

	/**
	 * 文件名过滤器：用来确定缓存文件名是否以“CACHE_FILENAME_PREFIX”为前缀
	 */
	private static final FilenameFilter cacheFileFilter = new FilenameFilter() {
		@Override
		public boolean accept(File dir, String filename) {
			return filename.startsWith(CACHE_FILENAME_PREFIX);
		}
	};

	/**
	 * 磁盘缓存DiskLruCache的构造方法，不能直接调用
	 * 
	 * @param cacheDir
	 *            缓存路径
	 * @param maxByteSize
	 *            缓存空间最大值
	 */
	private FileLruCache(File cacheDir, long maxByteSize) {
		// 缓存路径
		this.mCacheDir = cacheDir;
		// 缓存空间最大值
		this.maxCacheByteSize = maxByteSize;
	}

	/**
	 * 用于获取DiskLruCache的实例
	 * 
	 * @param context
	 * @param cacheDir
	 *            图片要保存的路径
	 * @param maxByteSize
	 *            缓存目录可用空间的最大值
	 * @return
	 */
	public static FileLruCache getInstance(Context context) {
		File cacheDir = new File(getFileCacheDir(context));
		// 如果缓存路径不存在,就创建出来
		if (!cacheDir.exists()) {
			cacheDir.mkdir();
		}

		// 判断指定路径是否是一个目录并且可读，同时指定路径可用空间大小大于缓存目录可用空间的最大值
		if (cacheDir.isDirectory() && cacheDir.canWrite()
				&& SDCardUtils.getUsableSpace(cacheDir) > APP_CACHE_MAX_SIZE) {
			return new FileLruCache(cacheDir, APP_CACHE_MAX_SIZE);
		}
		return null;
	}

	/**
	 * 把一个图片存到磁盘缓存中
	 * 
	 * @param key
	 *            图片(bitmap)对应的唯一标识
	 * @param bitmap
	 *            要存储的图片
	 */
	public void putFileLruCache(String key, byte[] data) {
		synchronized (FileLruCache.class) {
			String fileName = String.valueOf(Base64.encode(key.getBytes()));
			if (mLinkedHashMap.get(fileName) == null) {
				// 创建磁盘缓存路径
				if (!mCacheDir.exists()) {
					mCacheDir.mkdirs();
				}
				String filePath = mCacheDir.getAbsolutePath();
				// 把图片存到了某个文件中
				boolean saveDataIntoSD = SDCardUtils.saveDataIntoSD(data,
						filePath, fileName);
				if (saveDataIntoSD) {
					put(fileName, filePath);
					flushCache();
				}
			}
		}
	}

	/**
	 * 将图片添加到缓存容器中
	 * 
	 * @param key
	 * @param file
	 */
	private void put(String key, String file) {
		mLinkedHashMap.put(key, file);
		cacheSize = mLinkedHashMap.size();
		cacheByteSize += new File(file).length();
	}

	/**
	 * 移除磁盘中的缓存，如果磁盘缓存中缓存的文件容量超过了指定的缓存总大小，就清除最早的那个bitmap
	 */
	private void flushCache() {
		Entry<String, String> eldestEntry;
		File eldestFile;
		long eldestFileSize;
		int count = 0;
		// 移除的数量小于缓存容器mLinkedHashMap中缓存的数量，并且
		// 缓存容器mLinkedHashMap中缓存的数量大于缓存容器mLinkedHashMap中缓存数量的最大值，或缓存的大小大于默认的缓存空间最大值(5Mb)
		while (count < MAX_REMOVALS
				&& (cacheSize > maxCacheItemSize || cacheByteSize > maxCacheByteSize)) {
			eldestEntry = mLinkedHashMap.entrySet().iterator().next();
			eldestFile = new File(eldestEntry.getValue());
			eldestFileSize = eldestFile.length();
			mLinkedHashMap.remove(eldestEntry.getKey());
			eldestFile.delete();
			cacheSize = mLinkedHashMap.size();
			cacheByteSize -= eldestFileSize;
			count++;
		}
	}

	/**
	 * 从磁盘缓存中取出key对应的图片
	 * 
	 * @param key
	 * @return 如果找到就返回一个bitmap，反之返回null
	 */
	public InputStream getFileLruCache(String key) {
		synchronized (mLinkedHashMap) {
			String fileName = Base64.encode(key.getBytes());
			return SDCardUtils.getDataFromSD(mCacheDir.getAbsolutePath(),
					fileName);
		}
	}

	/**
	 * 判断key对应的图片是否存在
	 * 
	 * @param key
	 * @return 如果存在返回true，反之返回false
	 */
	public boolean containsKey(String key) {
		// 判断key对应的图片是否存在于缓存容器
		if (mLinkedHashMap.containsKey(key)) {
			return true;
		}

		final String existingFile = createFilePath(mCacheDir, key);
		if (new File(existingFile).exists()) {
			// 如果存在则添加到缓存容器中
			put(key, existingFile);
			return true;
		}
		return false;
	}

	/**
	 * 清除磁盘缓存中所有的bitmap
	 */
	public void clearDiskLruCache() {
		FileLruCache.clearCache(mCacheDir);
	}

	/**
	 * 清除某个路径下面的缓存内容(图片)
	 * 
	 * @param cacheDir
	 */
	private static void clearCache(File cacheDir) {
		final File[] files = cacheDir.listFiles(cacheFileFilter);
		for (int i = 0; i < files.length; i++) {
			files[i].delete();
		}
	}

	/**
	 * 创建磁盘缓存路径
	 * 
	 * @param cacheDir
	 * @param key
	 * @return
	 */
	public static String createFilePath(File cacheDir, String key) {
		try {
			// 使用URLEncoder确保文件名有效
			return cacheDir.getAbsolutePath() + File.separator
					+ CACHE_FILENAME_PREFIX
					+ URLEncoder.encode(key.replace("*", ""), "UTF-8");
		} catch (final UnsupportedEncodingException e) {
			Log.e(TAG, "createFilePath-->" + e);
		}

		return null;
	}

	/**
	 * 使用当前缓存目录创建缓存文件路径
	 * 
	 * @param key
	 * @return
	 */
	public String createFilePath(String key) {
		return createFilePath(mCacheDir, key);
	}

	/**
	 * 得到WebView缓存路径
	 * 
	 * @param context
	 * @return
	 */
	public static String getFileCacheDir(Context context) {
		return context.getFilesDir().getAbsolutePath() + APP_CACAHE_DIRNAME;
	}

}
