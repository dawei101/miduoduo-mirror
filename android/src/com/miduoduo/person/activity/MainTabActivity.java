package com.miduoduo.person.activity;

import android.app.TabActivity;
import android.content.Intent;
import android.os.Bundle;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.RadioButton;
import android.widget.TabHost;
import android.widget.TabHost.TabSpec;

import com.miduoduo.person.R;

@SuppressWarnings("deprecation")
public class MainTabActivity extends TabActivity implements
		OnCheckedChangeListener {

	private TabHost mTabHost;
	private Intent mAIntent;
	private Intent mBIntent;
	private Intent mCIntent;

	/** Called when the activity is first created. */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.maintabs);

		this.mAIntent = new Intent(this, MainActivity.class);
		this.mBIntent = new Intent(this, MainActivity.class);
		this.mCIntent = new Intent(this, MainActivity.class);

		((RadioButton) findViewById(R.id.radio_button0))
				.setOnCheckedChangeListener(this);
		((RadioButton) findViewById(R.id.radio_button1))
				.setOnCheckedChangeListener(this);
		((RadioButton) findViewById(R.id.radio_button2))
				.setOnCheckedChangeListener(this);

		setupIntent();
	}

	@Override
	public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
		if (isChecked) {
			switch (buttonView.getId()) {
			case R.id.radio_button0:
				this.mTabHost.setCurrentTabByTag("A_TAB");
				break;
			case R.id.radio_button1:
				this.mTabHost.setCurrentTabByTag("B_TAB");
				break;
			case R.id.radio_button2:
				this.mTabHost.setCurrentTabByTag("C_TAB");
				break;
			case R.id.radio_button3:
				this.mTabHost.setCurrentTabByTag("D_TAB");
				break;
			case R.id.radio_button4:
				this.mTabHost.setCurrentTabByTag("MORE_TAB");
				break;
			}
		}

	}

	private void setupIntent() {
		this.mTabHost = getTabHost();
		TabHost localTabHost = this.mTabHost;

		localTabHost.addTab(buildTabSpec("A_TAB", this.mAIntent));
		localTabHost.addTab(buildTabSpec("B_TAB", this.mBIntent));
		localTabHost.addTab(buildTabSpec("C_TAB",  this.mCIntent));

	}

	private TabHost.TabSpec buildTabSpec(String tag,final Intent content) {
		TabSpec spec = mTabHost.newTabSpec(tag);
		spec.setIndicator(tag);
		spec.setContent(content);
		
		content.putExtra("tag", tag);
		return spec;
	}
}