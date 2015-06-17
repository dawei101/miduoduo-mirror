package com.miduoduo.person.network;

import java.io.UnsupportedEncodingException;

import com.lidroid.xutils.HttpUtils;
import com.lidroid.xutils.http.RequestParams;
import com.lidroid.xutils.http.callback.RequestCallBack;
import com.lidroid.xutils.http.client.HttpRequest.HttpMethod;
import com.lidroid.xutils.http.client.multipart.MultipartEntity;
import com.lidroid.xutils.http.client.multipart.content.StringBody;
import com.miduoduo.person.MiNetWorkApi;
import com.miduoduo.person.util.Base64;
import com.miduoduo.person.util.ConfigHelper;

public class MiHttpClient {

	private static MiHttpClient instance = null;

	public static MiHttpClient getInstance() {
		if (instance == null) {
			instance = new MiHttpClient();
		}

		return instance;
	}

	private HttpUtils httpUtils = new HttpUtils();

	private MiHttpClient() {

	}

	public boolean requestForGetMethodWithApi(String api,
			RequestCallBack<String> callBack) {

		String username = ConfigHelper.getInstance(null).readString(
				ConfigHelper.CONFIG_KEY_USER_NAME);
		String password = ConfigHelper.getInstance(null).readString(
				ConfigHelper.CONFIG_KEY_PASSPORT);
		String author = "Basic "
				+ Base64.encode((username + ":" + password).getBytes());
		String url = MiNetWorkApi.getApiBaseUrl() + api;

		RequestParams requestParams = new RequestParams();
		requestParams.addHeader("Content-Type", "application/json");
		requestParams.addHeader("Authorization", author);

		try {
			httpUtils.send(HttpMethod.GET, url, requestParams, callBack);
		} catch (Exception e) {
			e.printStackTrace();

			return false;
		}
		return true;
	}

	public boolean requestWithPost(String url,RequestParams params,
			RequestCallBack<String> callBack) {
		
		if (params == null) {
			params = new RequestParams();
		}
		
		params.setContentType("application/json");
		try {
			httpUtils.send(HttpMethod.POST, url, params, callBack);
		} catch (Exception e) {
			e.printStackTrace();

			return false;
		}
		return true;
	}
	
	public boolean requestUserVcode(String phoneNum,RequestCallBack<String> callBack) {
		String url = MiNetWorkApi.getApiUserVcode();
		
		RequestParams params = new RequestParams();
		MultipartEntity entity = new MultipartEntity();
		try {
			entity.addPart("phonenum", new StringBody(phoneNum));
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		}
		params.setBodyEntity(entity);
		
		httpUtils.send(HttpMethod.POST, url, params, callBack);
		
		return true;
		
	}
	
	public boolean userLogin(String phoneNum,String code,RequestCallBack<String> callBack ) {
		String url = MiNetWorkApi.getApiUserVlogin();
		RequestParams params = new RequestParams();
		MultipartEntity entity = new MultipartEntity();
		try {
			entity.addPart("phonenum", new StringBody(phoneNum));
			entity.addPart("code", new StringBody(code));
			
			params.setBodyEntity(entity);
			httpUtils.send(HttpMethod.POST, url, params, callBack);
			
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		}

		
		return true;
	}

}
