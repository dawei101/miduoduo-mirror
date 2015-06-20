package com.miduoduo.person.activity;

import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.miduoduo.person.R;
import com.miduoduo.person.view.UINavigationView;

/**
 * <ul>
 * <li>类描述：设置密码界面
 * <li>创建时间： 2015-6-10 下午5:14:28
 * <li>创建人：liyunlong
 * </ul>
 */
public class SetPasswordActivity extends BaseActivity implements
		OnClickListener {

	/** 密码输入框 */
	private EditText editPassword1;
	/** 确认密码输入框 */
	private EditText editPassword2;
	/** 下一步 */
	private Button btnSetPassword;
	private boolean isRegister;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setBaseContentView(R.layout.activity_set_password);
	}

	@Override
	public void setNavigationView() {
		isRegister = getIntent().getBooleanExtra("isRegister", true);
		if (isRegister) {
			setNavigationViewTitle(null, R.string.set_password, null);
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
		editPassword1 = (EditText) findViewById(R.id.set_pwd_et1);
		editPassword2 = (EditText) findViewById(R.id.set_pwd_et2);
		btnSetPassword = (Button) findViewById(R.id.set_password_btn);
	}

	@Override
	public void init() {
		if (isRegister) {
			editPassword1.setHint(R.string.set_login_pwd);
			editPassword2.setHint(R.string.comfirm_login_pwd);
		}else {
			editPassword1.setHint(R.string.find_login_pwd);
			editPassword2.setHint(R.string.comfirm_find_login_pwd);
		}
		btnSetPassword.setOnClickListener(this);
	}

	@Override
	public void onClick(View v) {
		String password1 = editPassword1.getText().toString();
		String password2 = editPassword2.getText().toString();
		if (!TextUtils.isEmpty(password1) || !TextUtils.isEmpty(password2)) {
			Toast.makeText(this, "两个密码都不能为空", Toast.LENGTH_SHORT).show();
		} else if (!password1.equals(password2)) {
			Toast.makeText(this, "两个密码不一致", Toast.LENGTH_SHORT).show();
		} else {
			// TODO:设置密码->修改成功->跳转...
			
			Intent intent;
			if (isRegister) {
				intent = new Intent(this,InputBaseDataActivity.class);
			} else {
				intent = new Intent(this,MainActivity.class);
			}
			
			startActivity(intent);
			finish();
		}

	}

}
