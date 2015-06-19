package com.miduoduo.person.activity;

import java.util.Timer;
import java.util.TimerTask;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.TextView;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONObject;
import com.lidroid.xutils.exception.HttpException;
import com.lidroid.xutils.http.ResponseInfo;
import com.lidroid.xutils.http.callback.RequestCallBack;
import com.miduoduo.person.R;
import com.miduoduo.person.network.MiHttpClient;
import com.miduoduo.person.util.LogUtils;
import com.miduoduo.person.view.UINavigationView;

/**
 * <ul>
 * <li>类描述：填写验证码界面
 * <li>创建时间： 2015-6-10 下午5:14:28
 * <li>创建人：liyunlong
 * </ul>
 */
public class InputVerificationCodeActivity extends BaseActivity implements
		OnClickListener {

	/** 验证码输入框 */
	private EditText editCode;
	/** 提示 */
	private TextView hintPhone;
	/** 获取验证码按钮 */
	private Button btnGetCode;
	/** 单选框 */
	private CheckBox cbAgree;
	/** 米多多协议 */
	private Button btnProtocol;
	/** 手机号 */
	private String phoneNumber;
	/** 是否注册 */
	private boolean isRegister;
	/** 下一步 */
	private Button btnNext;

	private int timeCountDown = 60;
	private Timer timer;
	private TimerTask timerTask;

	@SuppressLint("HandlerLeak")
	private Handler handler = new Handler() {
		public void handleMessage(Message msg) {
			System.out.println("  " + timeCountDown--);
			if (timeCountDown == 0) {
				btnGetCode.setEnabled(true);
				btnGetCode.setText(R.string.get_auth_code);
				timeCountDown = 60;
				timerStop();
			} else {
				String text = timeCountDown
						+ getString(R.string.reget_auth_code);

				btnGetCode.setText(text);
			}

		};
	};

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setBaseContentView(R.layout.activity_input_verification_code);
	}

	@Override
	public void setNavigationView() {
		isRegister = getIntent().getBooleanExtra("isRegister", true);
		phoneNumber = getIntent().getStringExtra("phoneNumber");
		LogUtils.i("phoneNumber2=" + phoneNumber);
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
		hintPhone = (TextView) findViewById(R.id.tv_hint);
		editCode = (EditText) findViewById(R.id.et_code);
		btnGetCode = (Button) findViewById(R.id.btn_code);
		cbAgree = (CheckBox) findViewById(R.id.cb_agree);
		btnProtocol = (Button) findViewById(R.id.btn_protocol);
		btnNext = (Button) findViewById(R.id.input_phone_num_btn_next);
	}

	@Override
	public void init() {
		if (!isRegister) {
			cbAgree.setVisibility(View.GONE);
			btnProtocol.setVisibility(View.GONE);
		}
		sendCode();
		hintPhone.setText("验证码已发送到" + phoneNumber + "，请查收");
		btnGetCode.setEnabled(false);
		timerStart();

		btnGetCode.setOnClickListener(this);
		btnProtocol.setOnClickListener(this);
		btnNext.setOnClickListener(this);
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.btn_code:// 获取验证码
			sendCode();
			btnGetCode.setEnabled(false);
			timerStart();
			break;
		case R.id.btn_protocol:// 米多多协议

			break;
		case R.id.input_phone_num_btn_next:// 下一步
			timerStop();
			// TODO:发送验证码，校验成功，跳转到 设置密码...

			editCode.getText().toString();

			Intent intent = new Intent(this, SetPasswordActivity.class);
			intent.putExtra("isRegister", isRegister);
			startActivity(intent);
			finish();
			break;

		default:
			break;
		}

	}

	/** 计时开始 */
	private void timerStart() {
		timer = new Timer();
		timerTask = new TimerTask() {
			@Override
			public void run() {
				Message message = new Message();
				message.what = 1;
				handler.sendMessage(message);
			}
		};
		timer.schedule(timerTask, 1000, 1000);
	}

	/** 计时停止 */
	private void timerStop() {
		if (timer != null) {
			timer.cancel();
			timer = null;
		}
		if (timerTask != null) {
			timerTask.cancel();
			timerTask = null;
		}
	}

	/** 发送验证码 */
	private void sendCode() {
		MiHttpClient.getInstance().requestUserVcode(phoneNumber,
				new RequestCallBack<String>() {
					@Override
					public void onSuccess(ResponseInfo<String> responseInfo) {
						String result = responseInfo.result;
						System.out.println(result);
						JSONObject jsonObj = JSON.parseObject(result);
						String message = jsonObj.getString("message");
						boolean success = jsonObj.getBoolean("result");
						System.out.println("succ: " + success + " message: "
								+ message);
					}

					@Override
					public void onFailure(HttpException error, String msg) {

					}
				});
	}

}
