package com.miduoduo.person.task;

import java.io.File;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

import android.os.AsyncTask;

import com.miduoduo.person.util.UpdateUtils;

public class UpdateAsyncTask extends AsyncTask<String, Integer, Void> {

	private OnDownloadCompleteListener mListener;
	private int fileSize;

	public void setOnDownloadCompleteListener(OnDownloadCompleteListener listener) {
		mListener = listener;
	}

	@Override
	protected void onPreExecute() {
		super.onPreExecute();
	}

	@Override
	protected Void doInBackground(String... params) {
		InputStream is = null;
		OutputStream os = null;
		// 在SD卡创建下载目录
		File path = UpdateUtils.getDownloadDirectory();
		try {
			// 如果文件夹不再则创建
			if (!path.exists()) {
				path.mkdir();
			}
			URL url = new URL(params[0]);
			HttpURLConnection conn = (HttpURLConnection) url.openConnection();
			conn.setConnectTimeout(6 * 1000);
			conn.connect();
			is = conn.getInputStream();
			os = new FileOutputStream(new File(path.getAbsolutePath()
					+ UpdateUtils.getDownloadFileName(params[0])));
			// 获得文件长度

			fileSize = conn.getContentLength();
			mListener.ongetDataLength(fileSize);
			byte[] buffer = new byte[1024];
			int count = 0;
			int length = -1;
			while ((length = is.read(buffer)) != -1) {
				os.write(buffer, 0, length);
				count += length;
				// 调用publishProgress公布进度,最后onProgressUpdate方法将被执行
				mListener.onProgressUpdate(count);
				os.flush();
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			try {
				os.close();
				is.close();
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		return null;
	}

	@Override
	protected void onPostExecute(Void result) {
		super.onPostExecute(result);
	}

	/**
	 * 网络任务完成后的回调接口
	 */
	public interface OnDownloadCompleteListener {

		void ongetDataLength(int dataLength);

		void onProgressUpdate(int progress);
	}
}
