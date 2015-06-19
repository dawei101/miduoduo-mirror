package com.miduoduo.person.adapter;

import java.util.ArrayList;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.miduoduo.person.R;
import com.miduoduo.person.bean.Near;

/**
 * <ul>
 * <li>类描述：
 * <li>创建时间： 2015-6-10 上午10:57:01
 * <li>创建人：liyunlong
 * </ul>
 */
public class NearAdapter extends BaseAdapter {

	private ArrayList<Near> mList = null;

	public void setDatas(ArrayList<Near> list) {
		this.mList = list;
		notifyDataSetChanged();
	}

	@Override
	public int getCount() {
		return mList != null ? mList.size() : 0;
	}

	@Override
	public Object getItem(int position) {
		return mList.get(position);
	}

	@Override
	public long getItemId(int position) {
		return position;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		ViewHolder holder = null;
		Context mContext = parent.getContext();
		if (convertView == null) {
			holder = new ViewHolder();
			convertView = LayoutInflater.from(mContext).inflate(
					R.layout.near_address, null);
			// 查找控件
			holder.tvKey = (TextView) convertView
					.findViewById(R.id.tv_near_key);
			holder.tvDistrict = (TextView) convertView
					.findViewById(R.id.tv_near_district);
			convertView.setTag(holder);
		} else {
			// 复用ListView滚出屏幕的itemView
			holder = (ViewHolder) convertView.getTag(); // 获取到可复用的item中的所有控件对象
		}

		Near near = mList.get(position);
		holder.tvKey.setText(near.getKey());
		holder.tvDistrict.setText(near.getDistrict());
		return convertView;

	}

	static final class ViewHolder {
		TextView tvKey;
		TextView tvDistrict;
	}
}
