package com.miduoduo.person.adapter;

import java.util.ArrayList;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

/**
 * <ul>
 * <li>类描述：
 * <li>创建时间： 2015-6-10 上午10:57:01
 * <li>创建人：liyunlong
 * </ul>
 */
public class NearAdapter extends BaseAdapter {

	private ArrayList<String> mList = null;

	private int mResourceId = 0;
	private int mTextViewResourceId = 0;

	private Context mContext = null;

	public NearAdapter(Context context, ArrayList<String> list, int resourceId,
			int textViewSourceId) {
		super();
		mContext = context;
		mList = list;
		mResourceId = resourceId;
		mTextViewResourceId = textViewSourceId;
		notifyDataSetChanged();
	}

	public ArrayList<String> getList() {
		return mList;
	}

	public void setList(ArrayList<String> list) {
		this.mList = list;
	}

	@Override
	public int getCount() {
		if (mList == null) {
			return 0;
		}
		return mList.size();
	}

	@Override
	public Object getItem(int position) {
		return mList.get(position);
	}

	@Override
	public long getItemId(int position) {
		return 0;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		ViewHolder holder = null;

		if (convertView == null) {
			holder = new ViewHolder();
			convertView = LayoutInflater.from(mContext).inflate(mResourceId,
					null);
			holder.info = (TextView) convertView
					.findViewById(mTextViewResourceId);
			convertView.setTag(holder);
		} else {
			holder = (ViewHolder) convertView.getTag();
		}

		String text = mList.get(position);
		holder.info.setText(text);
		return convertView;

	}

	public final class ViewHolder {
		public TextView info;
	}
}
