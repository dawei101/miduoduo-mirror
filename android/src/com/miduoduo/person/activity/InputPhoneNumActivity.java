package com.miduoduo.person.activity;

import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.miduoduo.person.R;
import com.miduoduo.person.util.LogUtils;
import com.miduoduo.person.util.TelephonyUtils;
import com.miduoduo.person.util.Utils;
import com.miduoduo.person.view.UINavigationView;

/**
 * <ul>
 * <li>类描述：填写手机号界面
 * <li>创建时间： 2015-6-10 下午4:45:30
 * <li>创建人：liyunlong
 * </ul>
 */
public class InputPhoneNumActivity extends BaseActivity implements
		OnClickListener {

	private boolean isRegister;
	private TextView tvContent;
	private EditText edtPhoneNum;
	private Button btnNext;
	private String phoneNumber;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setBaseContentView(R.layout.activity_input_phone_num);

	}

	@Override
	public void setNavigationView() {
		isRegister = getIntent().getBooleanExtra("isRegister", true);
		if (isRegister) {
			setNavigationViewTitle(null, R.string.welcome_register, null);
		} else {
			setNavigationViewTitle(null, R.string.find_password, null);
		}
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
		tvContent = (TextView) findViewById(R.id.input_phone_num_tv_content);
		edtPhoneNum = (EditText) findViewById(R.id.input_phone_num_et_phone);
		btnNext = (Button) findViewById(R.id.input_phone_num_btn_next);

	}

	@Override
	public void init() {
		if (isRegister) {
			tvContent.setText(R.string.input_person_phone_number);
		} else {
			tvContent.setText(R.string.input_register_phone_number);
		}
		edtPhoneNum.setText(TelephonyUtils
				.getNativePhoneNumber(getApplicationContext()));
		btnNext.setOnClickListener(this);

	}

	@Override
	public void onClick(View v) {
		// 手机号码格式验证
		phoneNumber = edtPhoneNum.getText().toString();
		LogUtils.i("phoneNumber=" + phoneNumber);
		if (TextUtils.isEmpty(phoneNumber)) {
			Toast.makeText(this, "手机号码不能为空", Toast.LENGTH_SHORT).show();
			return;
		}
		if (!Utils.isPhone(phoneNumber)) {
			Toast.makeText(this, "手机号码格式不正确", Toast.LENGTH_SHORT).show();
			return;
		}
		Intent intent = new Intent(this, InputVerificationCodeActivity.class);
		intent.putExtra("isRegister", isRegister);
		intent.putExtra("phoneNumber", phoneNumber);
		startActivity(intent);
	}

}
