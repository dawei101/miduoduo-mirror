package com.miduoduo.person.activity;

import java.util.ArrayList;
import java.util.List;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.Toast;

import com.baidu.mapapi.map.BaiduMap;
import com.baidu.mapapi.map.BaiduMap.OnMarkerClickListener;
import com.baidu.mapapi.map.BitmapDescriptorFactory;
import com.baidu.mapapi.map.InfoWindow;
import com.baidu.mapapi.map.InfoWindow.OnInfoWindowClickListener;
import com.baidu.mapapi.map.MapStatus;
import com.baidu.mapapi.map.MapStatusUpdate;
import com.baidu.mapapi.map.MapStatusUpdateFactory;
import com.baidu.mapapi.map.MapView;
import com.baidu.mapapi.map.Marker;
import com.baidu.mapapi.model.LatLng;
import com.baidu.mapapi.overlayutil.PoiOverlay;
import com.baidu.mapapi.search.core.CityInfo;
import com.baidu.mapapi.search.core.PoiInfo;
import com.baidu.mapapi.search.core.SearchResult;
import com.baidu.mapapi.search.geocode.GeoCodeResult;
import com.baidu.mapapi.search.geocode.GeoCoder;
import com.baidu.mapapi.search.geocode.OnGetGeoCoderResultListener;
import com.baidu.mapapi.search.geocode.ReverseGeoCodeOption;
import com.baidu.mapapi.search.geocode.ReverseGeoCodeResult;
import com.baidu.mapapi.search.poi.OnGetPoiSearchResultListener;
import com.baidu.mapapi.search.poi.PoiCitySearchOption;
import com.baidu.mapapi.search.poi.PoiDetailResult;
import com.baidu.mapapi.search.poi.PoiDetailSearchOption;
import com.baidu.mapapi.search.poi.PoiResult;
import com.baidu.mapapi.search.poi.PoiSearch;
import com.baidu.mapapi.search.sug.OnGetSuggestionResultListener;
import com.baidu.mapapi.search.sug.SuggestionResult;
import com.baidu.mapapi.search.sug.SuggestionSearch;
import com.baidu.mapapi.search.sug.SuggestionSearchOption;
import com.lidroid.xutils.view.annotation.event.OnClick;
import com.miduoduo.person.R;
import com.miduoduo.person.adapter.NearAdapter;
import com.miduoduo.person.bean.Near;
import com.miduoduo.person.util.LogUtils;
import com.miduoduo.person.view.UINavigationView;

public class LiveAddrActivity extends BaseActivity {

	private Context mContext = LiveAddrActivity.this;
	/** 显示附近地点的ListView */
	private ListView mNearListView;
	/** 搜索框 */
	AutoCompleteTextView atvSearch;
	/** 搜索按钮 */
	private Button btnSearch;
	/** 地图标记 */
	private ImageView ivBmapMark;
	/** 地图 */
	private MapView mMapView;
	private BaiduMap mBaiduMap;
	/** 搜索模块 */
	private GeoCoder mSearch = null;
	/** POI检索实例 */
	private PoiSearch mPoiSearch = null;
	private SuggestionSearch mSuggestionSearch = null;

	private NearAdapter mNearAdapter;
	private String localCity;
	private ArrayList<Near> nearList;

	private ArrayAdapter<String> sugAdapter = null;

	private boolean isMoveMapView = false;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setBaseContentView(R.layout.activity_live_addr);

	}

	@Override
	public void setNavigationView() {
		setNavigationViewTitle(null, R.string.live_address, null);
		setNavigationViewDrable(R.drawable.ic_back, 0);
		setNavigationViewListener(new UINavigationView.OnClickListener() {

			@Override
			public void onClick(View v, boolean isLeft) {
				if (isLeft) {
					finish();
				}
			}
		});
	}

	@Override
	public void findView() {
		mNearListView = (ListView) findViewById(R.id.lv_near_addr);
		btnSearch = (Button) findViewById(R.id.btn_search);
		atvSearch = (AutoCompleteTextView) findViewById(R.id.atv_search);
		ivBmapMark = (ImageView) findViewById(R.id.iv_bmap_mark);
		mMapView = (MapView) findViewById(R.id.bmapView);

	}

	@Override
	public void init() {
		localCity = getIntent().getStringExtra("localCity");
		if (localCity == null) {
			localCity = "北京";
		}
		mMapView.showScaleControl(false);// 设置是否显示比例尺控件
		mMapView.showZoomControls(false);// 设置是否显示缩放控件
		mBaiduMap = mMapView.getMap();

		MapStatusUpdate msu = MapStatusUpdateFactory.zoomTo(18.0f);
		mBaiduMap.setMapStatus(msu);
		// 初始化搜索模块，注册事件监听
		mSearch = GeoCoder.newInstance();
		mSearch.setOnGetGeoCodeResultListener(getGeoCoderResultListener);
		// 创建POI检索实例
		mPoiSearch = PoiSearch.newInstance();
		// 设置POI检索监听者
		mPoiSearch.setOnGetPoiSearchResultListener(poiListener);
		mSuggestionSearch = SuggestionSearch.newInstance();
		mBaiduMap
				.setOnMapStatusChangeListener(new BaiduMap.OnMapStatusChangeListener() {
					public void onMapStatusChangeStart(MapStatus status) {
						showBmapViewMark(true);
					}

					public void onMapStatusChange(MapStatus status) {
					}

					public void onMapStatusChangeFinish(MapStatus status) {

						LogUtils.d("mytest", "" + status.target.latitude + ","
								+ status.target.longitude);
						mSearch.reverseGeoCode(new ReverseGeoCodeOption()
								.location(status.target));
					}
				});

		mBaiduMap.setOnMarkerClickListener(new OnMarkerClickListener() {
			public boolean onMarkerClick(final Marker marker) {
				Button button = new Button(getApplicationContext());
				button.setBackgroundResource(R.drawable.ic_popup);
				OnInfoWindowClickListener listener = null;
				button.setText("选择该地点");
				listener = new OnInfoWindowClickListener() {
					public void onInfoWindowClick() {
						LatLng ll = marker.getPosition();

						Toast.makeText(LiveAddrActivity.this,
								"该位置：" + ll.latitude + "," + ll.longitude,
								Toast.LENGTH_LONG).show();
						mBaiduMap.hideInfoWindow();
						showBmapViewMark(true);
					}
				};
				LatLng ll = marker.getPosition();
				InfoWindow mInfoWindow = new InfoWindow(BitmapDescriptorFactory
						.fromView(button), ll, -47, listener);
				mBaiduMap.showInfoWindow(mInfoWindow);
				return true;
			}
		});

		mSuggestionSearch
				.setOnGetSuggestionResultListener(new OnGetSuggestionResultListener() {

					@Override
					public void onGetSuggestionResult(SuggestionResult res) {

						if (res == null || res.getAllSuggestions() == null) {
							return;
						}

						if (isMoveMapView == false) {
							sugAdapter.clear();
							for (SuggestionResult.SuggestionInfo info : res
									.getAllSuggestions()) {
								if (info.key != null)
									sugAdapter.add(info.key);
							}
							sugAdapter.notifyDataSetChanged();
						} else {
							for (SuggestionResult.SuggestionInfo info : res
									.getAllSuggestions()) {
								if (info.key != null) {
									LogUtils.e("mytest", info.key);

									nearList.add(new Near(info.key,
											info.district));
								}
							}

							mNearAdapter.setDatas(nearList);
						}
					}
				});
		nearList = new ArrayList<Near>();
		mNearAdapter = new NearAdapter();
		mNearAdapter.setDatas(nearList);
		mNearListView.setAdapter(mNearAdapter);
		mNearListView.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				String address = (String) parent.getItemAtPosition(position);
				LogUtils.d("mytest", address);
				finishPutResult(address);
			}
		});

		atvSearch.addTextChangedListener(new TextWatcher() {

			@Override
			public void afterTextChanged(Editable arg0) {

			}

			@Override
			public void beforeTextChanged(CharSequence arg0, int arg1,
					int arg2, int arg3) {

			}

			@Override
			public void onTextChanged(CharSequence cs, int arg1, int arg2,
					int arg3) {
				if (cs.length() <= 0) {
					return;
				}

				/**
				 * 使用建议搜索服务获取建议列表，结果在onSuggestionResult()中更新
				 */
				mSuggestionSearch
						.requestSuggestion((new SuggestionSearchOption())
								.keyword(cs.toString()).city(localCity));

				isMoveMapView = false;
			}
		});
		atvSearch.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				String text = (String) parent.getItemAtPosition(position);
				LogUtils.d("mytest", text);
				search();
			}
		});
		btnSearch.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				search();
			}
		});
		sugAdapter = new ArrayAdapter<String>(this,
				android.R.layout.simple_dropdown_item_1line);
		atvSearch.setAdapter(sugAdapter);

		// todo 设置起始的中心位置，采用经纬度
		LatLng target = new LatLng(39.9289, 116.3883);
		MapStatus mMapStatus = new MapStatus.Builder().target(target).zoom(18)
				.build();
		MapStatusUpdate mMapStatusUpdate = MapStatusUpdateFactory
				.newMapStatus(mMapStatus);
		mBaiduMap.setMapStatus(mMapStatusUpdate);

		mSearch.reverseGeoCode(new ReverseGeoCodeOption().location(target));

	}

	@Override
	protected void onDestroy() {
		mSearch.destroy();
		mPoiSearch.destroy();// 释放POI检索实例
		mSuggestionSearch.destroy();
		super.onDestroy();
	}

	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (keyCode == KeyEvent.KEYCODE_BACK) {
			return true;
		}
		return super.onKeyDown(keyCode, event);
	}

	public void finishPutResult(String address) {

		Intent intent = new Intent();
		intent.putExtra("address", address);
		setResult(RESULT_OK, intent);

		finish();
	}

	private void search() {
		String text = atvSearch.getText().toString();
		LogUtils.d("搜索地点=" + text);
		// 发起检索请求
		mPoiSearch.searchInCity((new PoiCitySearchOption()).city(localCity)
				.keyword(text));

	}

	private void showBmapViewMark(boolean visible) {
		if (visible) {
			mBaiduMap.clear();
			ivBmapMark.setVisibility(View.VISIBLE);
		} else {
			ivBmapMark.setVisibility(View.INVISIBLE);
		}
	}

	/** 　POI检索监听者　 */
	OnGetPoiSearchResultListener poiListener = new OnGetPoiSearchResultListener() {
		// 获取POI检索结果
		public void onGetPoiResult(PoiResult result) {
			if (result == null
					|| result.error == SearchResult.ERRORNO.RESULT_NOT_FOUND) {
				Toast.makeText(mContext, "未找到结果", Toast.LENGTH_LONG).show();
				return;
			}
			if (result.error == SearchResult.ERRORNO.NO_ERROR) {

				showBmapViewMark(false);
				mBaiduMap.clear();
				PoiOverlay overlay = new MyPoiOverlay(mBaiduMap);
				mBaiduMap.setOnMarkerClickListener(overlay);
				overlay.setData(result);
				overlay.addToMap();
				overlay.zoomToSpan();
				return;
			}
			if (result.error == SearchResult.ERRORNO.AMBIGUOUS_KEYWORD) {

				// 当输入关键字在本市没有找到，但在其他城市找到时，返回包含该关键字信息的城市列表
				String strInfo = "在";
				for (CityInfo cityInfo : result.getSuggestCityList()) {
					strInfo += cityInfo.city;
					strInfo += ",";
				}
				strInfo += "找到结果";
				Toast.makeText(mContext, strInfo, Toast.LENGTH_LONG).show();
			}
		}

		// 获取Place详情页检索结果
		public void onGetPoiDetailResult(PoiDetailResult result) {

			if (result.error != SearchResult.ERRORNO.NO_ERROR) {// 详情检索失败
				Toast.makeText(mContext, "抱歉，未找到结果", Toast.LENGTH_SHORT).show();
			} else {// 详情检索成功
				Toast.makeText(mContext,
						result.getName() + ": " + result.getAddress(),
						Toast.LENGTH_SHORT).show();
			}
		}
	};

	OnGetGeoCoderResultListener getGeoCoderResultListener = new OnGetGeoCoderResultListener() {

		@Override
		public void onGetGeoCodeResult(GeoCodeResult arg0) {

		}

		@Override
		public void onGetReverseGeoCodeResult(ReverseGeoCodeResult result) {
			if (result == null || result.error != SearchResult.ERRORNO.NO_ERROR) {
				Toast.makeText(mContext, "抱歉，未能找到结果", Toast.LENGTH_LONG).show();
				return;
			}

			LogUtils.d("mytest", result.getBusinessCircle());
			LogUtils.d("mytest", result.getAddress());

			String detail = result.getAddressDetail().province;
			detail += " - " + result.getAddressDetail().city;
			detail += " - " + result.getAddressDetail().district;
			detail += " - " + result.getAddressDetail().street;
			detail += " - " + result.getAddressDetail().streetNumber;

			List<PoiInfo> list = result.getPoiList();
			PoiInfo poi = result.getPoiList().get(0);
			for (int i = 0; i < list.size(); i++) {
				poi = result.getPoiList().get(0);
				String text = poi.name;
				text += " - " + poi.city;
				text += " - " + poi.address;
				LogUtils.e("mytest", text);
			}

			LogUtils.d("mytest", detail);
			Toast.makeText(mContext, detail, Toast.LENGTH_LONG).show();

			String key = poi.name;
			String city = result.getAddressDetail().city;

			mSuggestionSearch.requestSuggestion((new SuggestionSearchOption())
					.keyword(key).city(city));
			isMoveMapView = true;
		}
	};

	private class MyPoiOverlay extends PoiOverlay {

		public MyPoiOverlay(BaiduMap baiduMap) {
			super(baiduMap);
		}

		@Override
		public boolean onPoiClick(int index) {
			super.onPoiClick(index);
			PoiInfo poi = getPoiResult().getAllPoi().get(index);
			// if (poi.hasCaterDetails) {
			// uid是POI检索中获取的POI ID信息
			mPoiSearch.searchPoiDetail((new PoiDetailSearchOption())
					.poiUid(poi.uid));
			// }
			return true;
		}
	}

}
