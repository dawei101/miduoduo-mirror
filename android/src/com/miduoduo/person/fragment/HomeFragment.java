package com.miduoduo.person.fragment;

import android.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.miduoduo.person.R;
import com.miduoduo.person.util.LogUtils;
import com.miduoduo.person.util.WebViewUtils;
import com.miduoduo.person.view.bridge.BridgeHandler;
import com.miduoduo.person.view.bridge.BridgeWebView;
import com.miduoduo.person.view.bridge.CallBackFunction;

public class HomeFragment extends Fragment {

	private BridgeWebView webView;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		View view = inflater.inflate(R.layout.fragment_home, container, false);
		webView = (BridgeWebView) view.findViewById(R.id.home_webview);

		initWebVIew();

		return view;
	}

	private void initWebVIew() {
		WebViewUtils.initWebSettings(getActivity(), webView);
		webView.loadUrl("http://m.miduoduo.cn/user/vsignup");
		// webView.loadUrl("file:///android_asset/ExampleApp.html");
		webView.setDefaultHandler(new BridgeHandler() {

			@Override
			public void handler(String data, CallBackFunction function) {
				LogUtils.i("defaulHandler: " + data);
				function.onCallBack("http://www.google.cn/index.html?data＝"
						+ data);
			}
		});
		webView.registerHandler("submitFromWeb", new BridgeHandler() {

			@Override
			public void handler(String data, CallBackFunction function) {
				LogUtils.i("handler = submitFromWeb, data from web = " + data);
				function.onCallBack("file:///android_asset/demo.html,submitFromWeb exe, response data from Java");
			}

		});
	}
}
