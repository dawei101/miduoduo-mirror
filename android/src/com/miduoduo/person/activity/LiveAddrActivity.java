package com.miduoduo.person.activity;

import java.util.ArrayList;
import java.util.List;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
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
import com.lidroid.xutils.ViewUtils;
import com.lidroid.xutils.view.annotation.ViewInject;
import com.lidroid.xutils.view.annotation.event.OnClick;
import com.miduoduo.person.R;
import com.miduoduo.person.adapter.NearAdapter;
import com.miduoduo.person.view.UINavigationView;

public class LiveAddrActivity extends Activity implements
		OnGetGeoCoderResultListener, OnGetPoiSearchResultListener {

	@ViewInject(R.id.lv_near_addr)
	private ListView lvNearAddr;

	@ViewInject(R.id.atv_search)
	AutoCompleteTextView atvSearch;
	
	@ViewInject(R.id.iv_bmap_mark)
	private ImageView ivBmapMark;

	@ViewInject(R.id.bmapView)
	private MapView mMapView;
	private BaiduMap mBaiduMap;
	private GeoCoder mSearch = null;
	private PoiSearch mPoiSearch = null;
	private SuggestionSearch mSuggestionSearch = null;

	private NearAdapter mNearAdapter;
	private String localCity;

	private ArrayAdapter<String> sugAdapter = null;

	private boolean isMoveMapView = false;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		LayoutInflater inflater = LayoutInflater.from(this);
		View view = inflater.inflate(R.layout.activity_live_addr, null, false);
		ViewUtils.inject(this, view);
		setContentView(view);

		UINavigationView navigation = (UINavigationView) view.findViewById(R.id.navigation);
		navigation.setListener(new UINavigationView.OnClickListener() {
			
			@Override
			public void onClick(View v, boolean isLeft) {
				// TODO Auto-generated method stub
				if (isLeft) {
					LiveAddrActivity.this.finish();
				}
			}
		});
		
		localCity = getIntent().getStringExtra("localCity");
		if (localCity == null) {
			localCity = "北京";
		}
		

		mMapView.showScaleControl(false);//设置是否显示比例尺控件
		mMapView.showZoomControls(false);//设置是否显示缩放控件
		mBaiduMap = mMapView.getMap();
		
		MapStatusUpdate msu = MapStatusUpdateFactory.zoomTo(18.0f);
		mBaiduMap.setMapStatus(msu);
		// 初始化搜索模块，注册事件监听
		mSearch = GeoCoder.newInstance();
		mSearch.setOnGetGeoCodeResultListener(this);
		mPoiSearch = PoiSearch.newInstance();
		mPoiSearch.setOnGetPoiSearchResultListener(this);
		mSuggestionSearch = SuggestionSearch.newInstance();
		mBaiduMap.setOnMapStatusChangeListener(new BaiduMap.OnMapStatusChangeListener() {
					public void onMapStatusChangeStart(MapStatus status) {
						showBmapViewMark(true);
					}

					public void onMapStatusChange(MapStatus status) {
					}

					public void onMapStatusChangeFinish(MapStatus status) {
						
						Log.d("mytest", ""+status.target.latitude + "," + status.target.longitude);
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
							
							Toast.makeText(LiveAddrActivity.this, "该位置：" + ll.latitude + "," + ll.longitude, Toast.LENGTH_LONG).show();
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
						// TODO Auto-generated method stub

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
							ArrayList<String> nearList = new ArrayList<String>();

							for (SuggestionResult.SuggestionInfo info : res
									.getAllSuggestions()) {
								if (info.key != null) {
									Log.e("mytest", info.key);

									nearList.add(info.key);
									// Log.e("mytest", info.city);
									// Log.e("mytest", info.district);
								}
							}

							mNearAdapter.setList(nearList);
							mNearAdapter.notifyDataSetChanged();
						}
					}
				});

		mNearAdapter = new NearAdapter(this, null, R.layout.near_address,
				R.id.tv_info);
		lvNearAddr.setAdapter(mNearAdapter);
		lvNearAddr.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				String address = (String) parent.getItemAtPosition(position);
				Log.d("mytest", address);
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
				// TODO Auto-generated method stub
				String text = (String) parent.getItemAtPosition(position);
				Log.d("mytest", text);
				search(null);
			}
		});
		
		sugAdapter = new ArrayAdapter<String>(this,
				android.R.layout.simple_dropdown_item_1line);
		atvSearch.setAdapter(sugAdapter);
		
		
		// todo 设置起始的中心位置，采用经纬度
		LatLng target = new LatLng(39.9289,116.3883);
		MapStatus mMapStatus = new MapStatus.Builder().target(target).zoom(18).build();
		MapStatusUpdate mMapStatusUpdate = MapStatusUpdateFactory.newMapStatus(mMapStatus);
		mBaiduMap.setMapStatus(mMapStatusUpdate);
		
		mSearch.reverseGeoCode(new ReverseGeoCodeOption().location(target));
	}

	@Override
	protected void onDestroy() {
		mSearch.destroy();
		mPoiSearch.destroy();
		mSuggestionSearch.destroy();
		super.onDestroy();
	}
	
	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		// TODO Auto-generated method stub
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
	
	@OnClick(R.id.btn_search)
	private void search(View view) {
		String text = atvSearch.getText().toString();
		Log.d("mytest", text);
		
		mPoiSearch.searchInCity((new PoiCitySearchOption())
				.city(localCity)
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

	@Override
	public void onGetGeoCodeResult(GeoCodeResult arg0) {
		// TODO Auto-generated method stub

	}

	@Override
	public void onGetReverseGeoCodeResult(ReverseGeoCodeResult result) {
		// TODO Auto-generated method stub
		if (result == null || result.error != SearchResult.ERRORNO.NO_ERROR) {
			Toast.makeText(this, "抱歉，未能找到结果", Toast.LENGTH_LONG).show();
			return;
		}

		Log.d("mytest", result.getBusinessCircle());
		Log.d("mytest", result.getAddress());

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
			Log.w("mytest", text);
		}

		Log.d("mytest", detail);
		Toast.makeText(this, detail, Toast.LENGTH_LONG).show();

		String key = poi.name;
		String city = result.getAddressDetail().city;

		mSuggestionSearch.requestSuggestion((new SuggestionSearchOption())
				.keyword(key).city(city));
		isMoveMapView = true;
	}


	public void onGetPoiResult(PoiResult result) {
		if (result == null
				|| result.error == SearchResult.ERRORNO.RESULT_NOT_FOUND) {
			Toast.makeText(this, "未找到结果", Toast.LENGTH_LONG)
			.show();
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
			Toast.makeText(this, strInfo, Toast.LENGTH_LONG)
					.show();
		}
	}

	public void onGetPoiDetailResult(PoiDetailResult result) {
		if (result.error != SearchResult.ERRORNO.NO_ERROR) {
			Toast.makeText(this, "抱歉，未找到结果", Toast.LENGTH_SHORT)
					.show();
		} else {
			Toast.makeText(this, result.getName() + ": " + result.getAddress(), Toast.LENGTH_SHORT)
			.show();
		}
	}
	
	private class MyPoiOverlay extends PoiOverlay {

		public MyPoiOverlay(BaiduMap baiduMap) {
			super(baiduMap);
		}

		@Override
		public boolean onPoiClick(int index) {
			super.onPoiClick(index);
			PoiInfo poi = getPoiResult().getAllPoi().get(index);
			// if (poi.hasCaterDetails) {
				
				mPoiSearch.searchPoiDetail((new PoiDetailSearchOption())
						.poiUid(poi.uid));
			// }
			return true;
		}
	}
}
