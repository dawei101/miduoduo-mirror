package com.miduoduo.person.activity;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.lidroid.xutils.exception.HttpException;
import com.lidroid.xutils.http.ResponseInfo;
import com.lidroid.xutils.http.callback.RequestCallBack;
import com.miduoduo.person.Constants;
import com.miduoduo.person.R;
import com.miduoduo.person.network.MiHttpClient;
import com.miduoduo.person.util.DialogUtils;
import com.miduoduo.person.util.LogUtils;
import com.miduoduo.person.util.SharedPreferencesUtils;
import com.miduoduo.person.util.Utils;

/**
 * <ul>
 * <li>类描述：登录界面
 * <li>创建时间： 2015-6-15 上午9:35:03
 * <li>创建人：liyunlong
 * </ul>
 */
public class LoginActivity extends Activity implements OnClickListener {

	private MiHttpClient httpClient = MiHttpClient.getInstance();
	private Context mContext = LoginActivity.this;
	private Button btnJump;
	private EditText edtUserName;
	private EditText edtPassword;
	private Button btnForget;
	private Button btnLogin;
	private Button btnRegister;
	private ProgressDialog loadingDialog;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_login);

		findView();

		init();
	}

	private void findView() {
		btnJump = (Button) findViewById(R.id.login_btn_jump);
		edtUserName = (EditText) findViewById(R.id.login_edt_name);
		edtPassword = (EditText) findViewById(R.id.login_edt_pwd);
		btnForget = (Button) findViewById(R.id.login_btn_forget);
		btnLogin = (Button) findViewById(R.id.login_btn_login);
		btnRegister = (Button) findViewById(R.id.login_btn_register);
	}

	private void init() {
		loadingDialog = DialogUtils.getLoadingDialog(mContext);
		btnJump.setOnClickListener(this);
		btnForget.setOnClickListener(this);
		btnLogin.setOnClickListener(this);
		btnRegister.setOnClickListener(this);
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.login_btn_jump:// 跳过
			goMain();
			break;
		case R.id.login_btn_forget:// 忘记密码
			goInputPhoneNum(false);
			break;
		case R.id.login_btn_login:// 登录
			// TODO:验证账号密码
			final String userName = edtUserName.getText().toString();
			final String password = edtPassword.getText().toString();
			if (TextUtils.isEmpty(userName) || TextUtils.isEmpty(password)) {
				Toast.makeText(mContext, "账号或密码不能为空", Toast.LENGTH_SHORT)
						.show();
			} else if (!Utils.isPhone(userName)) {
				Toast.makeText(this, "手机号码格式不正确", Toast.LENGTH_SHORT).show();
			} else {
				loadingDialog.show();
				httpClient.userLogin(userName, password,
						new RequestCallBack<String>() {

							@Override
							public void onSuccess(
									ResponseInfo<String> responseInfo) {
								loadingDialog.dismiss();
								LogUtils.e("login: " + responseInfo.result);
								Toast.makeText(mContext, "登录成功",
										Toast.LENGTH_SHORT).show();
								SharedPreferencesUtils.putString(mContext,
										Constants.Config.USERNAME, userName);

								goMain();
							}

							@Override
							public void onFailure(HttpException error,
									String msg) {
								LogUtils.e("登录失败信息：" + msg);
								loadingDialog.dismiss();
								Toast.makeText(mContext, "登录失败",
										Toast.LENGTH_SHORT).show();
							}
						});
			}
			break;
		case R.id.login_btn_register:// 注册
			goInputPhoneNum(true);
			break;

		default:
			break;
		}
	}

	private void goInputPhoneNum(boolean value) {
		Intent intent = new Intent(this, InputPhoneNumActivity.class);
		intent.putExtra("isRegister", value);
		startActivity(intent);
	}

	private void goMain() {
		Intent intent = new Intent(LoginActivity.this, MainActivity.class);
		startActivity(intent);
		finish();
	}

}
