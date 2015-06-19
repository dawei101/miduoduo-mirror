package com.miduoduo.person.task;

import java.io.File;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;

import android.os.AsyncTask;

import com.miduoduo.person.util.UpdateUtils;

/**
 * 到网络中下载图片，并且保存到SD卡中
 */
public class UpdateAsyncTask extends AsyncTask<String, Integer, String> {

	private onUpdateListener mListener;

	public void setOnUpdateListener(onUpdateListener listener) {
		mListener = listener;
	}

	@Override
	protected String doInBackground(String... params) {
		InputStream is = null;
		FileOutputStream fos = null;
		File directory = UpdateUtils.getDownloadDirectory();
		try {
			URL url = new URL(params[0]);
			HttpURLConnection conn = (HttpURLConnection) url.openConnection();
			conn.setDoInput(true);
			conn.setConnectTimeout(7000);
			conn.setRequestMethod("GET");

			int code = conn.getResponseCode();
			if (code == HttpURLConnection.HTTP_OK) {
				int contentLength = conn.getContentLength();
				if (mListener == null) {
					throw new IllegalStateException("The listener is not set.");
				}
				// 把网络数据的长度通知给UI
				mListener.onGetDataLength(contentLength);
				// 判断目录是否存在
				if (!directory.exists()) {
					directory.mkdirs();
				}
				String filePath = directory.getAbsolutePath() + File.separator
						+ UpdateUtils.getDownloadFileName(params[0]);
				is = conn.getInputStream();
				fos = new FileOutputStream(filePath);
				int len = 0;
				byte[] buf = new byte[1024];
				int progress = 0;
				while ((len = is.read(buf)) != -1) {
					fos.write(buf, 0, len);
					fos.flush();
					progress += len;
					mListener.onProgressUpdate(progress);
				}

				fos.close();
				is.close();
				return filePath;
			}

		} catch (Exception e) {
			e.printStackTrace();
		}

		return null;
	}

	@Override
	protected void onPreExecute() {
	}

	@Override
	protected void onPostExecute(String result) {
		if (mListener == null) {
			throw new IllegalStateException("The listener is not set.");
		}
		mListener.onGetFilePath(result);
	}

	/**
	 * 网络任务完成后的回调接口
	 */
	public interface onUpdateListener {
		/**
		 * 在网络下载完成后被调用
		 */
		void onGetFilePath(String filePath);

		/**
		 * 在网络连通之后，被调用
		 * 
		 * @param dataLength
		 *            网络数据的长度
		 */
		void onGetDataLength(int dataLength);

		void onProgressUpdate(int progress);
	}

}
