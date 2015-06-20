package com.miduoduo.person.util;

import java.io.IOException;
import java.util.concurrent.Executor;
import java.util.concurrent.Executors;

import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;

import android.content.Context;
import android.util.Log;

import com.miduoduo.person.cache.FileLruCache;

/**
 * <ul>
 * <li>类描述：网络请求处理工具类
 * <li>创建人：liyunlong
 * <li>创建时间：2015-3-16 上午9:43:00
 * </ul>
 */
public class DownFileUtils {

	/** 上下文 */
	private Context mContext;
	/** 线程池对象 */
	private Executor mExecutor = Executors.newFixedThreadPool(6);

	public DownFileUtils(Context context) {
		this.mContext = context;
	}

	/**
	 * 下载功能方法
	 * 
	 * @param url
	 *            请求的地址
	 */
	public void download(final String url) {

		// 将网络请求处理的Runnable增加到线程池中
		mExecutor.execute(new Runnable() {

			@Override
			public void run() {

				try {
					HttpClient client = new DefaultHttpClient();
					HttpGet get = new HttpGet(url);
					HttpResponse response = client.execute(get);
					if (response.getStatusLine().getStatusCode() == 200) {

						byte[] data = EntityUtils.toByteArray(response
								.getEntity());
						FileLruCache.getInstance(mContext).putFileLruCache(url,
								data);
						Log.e("TAG", "缓存" + url);
					}
				} catch (ClientProtocolException e) {
					e.printStackTrace();
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		});
	}

}
