package com.miduoduo.person.activity;

import java.io.File;
import java.io.FileNotFoundException;
import java.text.SimpleDateFormat;
import java.util.Calendar;

import android.app.AlertDialog;
import android.app.DatePickerDialog;
import android.app.DatePickerDialog.OnDateSetListener;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Bundle;
import android.os.SystemClock;
import android.provider.MediaStore;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RadioGroup;
import android.widget.RadioGroup.OnCheckedChangeListener;
import android.widget.Toast;

import com.miduoduo.person.R;
import com.miduoduo.person.view.SegmentedGroup;
import com.miduoduo.person.view.UINavigationView;

/**
 * <ul>
 * <li>类描述：填写基本资料界面
 * <li>创建时间： 2015-6-15 下午2:06:16
 * <li>创建人：liyunlong
 * </ul>
 */
public class InputBaseDataActivity extends BaseActivity implements
		OnClickListener {

	// 调用照相机
	/** 照相机 */
	private final int REQUEST_CODE_CAMERA = 10001;
	/** 相册 */
	private final int REQUEST_CODE_ALBUM = 10002;
	/** 裁剪图片 */
	private final int REQUEST_CODE_CROP = 10003;
	/** 居住地址 */
	public final int REQUEST_CODE_LIVE_ADDR = 10004;

	private Context mContext = InputBaseDataActivity.this;
	private Button btnPhoto;
	private ImageView ivPhoto;
	private EditText edtName;
	private ImageView ivCleanName;
	private Button btnBirth;
	private SegmentedGroup stgSex;
	private SegmentedGroup stgSchool;
	private EditText edtSchool;
	private ImageView ivCleanSchool;
	private Button btnAddress;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setBaseContentView(R.layout.activity_input_base);
	}

	@Override
	public void setNavigationView() {
		setNavigationViewTitle(null, R.string.input_base_data, "跳过");
		setNavigationViewListener(new UINavigationView.OnClickListener() {
			
			@Override
			public void onClick(View v, boolean isLeft) {
				if (!isLeft) {
					finish();
				}
			}
		});
	}

	@Override
	public void findView() {
		btnPhoto = (Button) findViewById(R.id.input_base_btn_photo);
		ivPhoto = (ImageView) findViewById(R.id.input_base_iv_photo);
		edtName = (EditText) findViewById(R.id.input_base_edt_name);
		ivCleanName = (ImageView) findViewById(R.id.input_base_iv_clean_name);
		btnBirth = (Button) findViewById(R.id.input_base_btn_birth);
		stgSex = (SegmentedGroup) findViewById(R.id.input_base_sgt_sex);
		stgSchool = (SegmentedGroup) findViewById(R.id.input_base_sgt_school);
		llSchoolView = (LinearLayout) findViewById(R.id.input_base_llt_school);
		edtSchool = (EditText) findViewById(R.id.input_base_edt_school);
		ivCleanSchool = (ImageView) findViewById(R.id.input_base_iv_clean_school);
		btnAddress = (Button) findViewById(R.id.input_base_btn_live_addr);
	}

	@Override
	public void init() {
		btnPhoto.setOnClickListener(this);
		edtName.addTextChangedListener(new TextWatcher() {

			@Override
			public void onTextChanged(CharSequence s, int start, int before,
					int count) {
				if (!TextUtils.isEmpty(s)) {
					ivCleanName.setVisibility(View.VISIBLE);
				}
			}

			@Override
			public void beforeTextChanged(CharSequence s, int start, int count,
					int after) {

			}

			@Override
			public void afterTextChanged(Editable s) {
				if (TextUtils.isEmpty(s)) {
					ivCleanName.setVisibility(View.GONE);
				}
			}
		});
		ivCleanName.setOnClickListener(this);
		edtSchool.addTextChangedListener(new TextWatcher() {

			@Override
			public void onTextChanged(CharSequence s, int start, int before,
					int count) {
				if (!TextUtils.isEmpty(s)) {
					ivCleanSchool.setVisibility(View.VISIBLE);
				}
			}

			@Override
			public void beforeTextChanged(CharSequence s, int start, int count,
					int after) {

			}

			@Override
			public void afterTextChanged(Editable s) {
				if (TextUtils.isEmpty(s)) {
					ivCleanSchool.setVisibility(View.GONE);
				}
			}
		});
		ivCleanSchool.setOnClickListener(this);
		btnBirth.setOnClickListener(this);
		stgSex.setOnCheckedChangeListener(new OnCheckedChangeListener() {

			@Override
			public void onCheckedChanged(RadioGroup group, int checkedId) {
				switch (checkedId) {
				case R.id.man:
					Toast.makeText(mContext, "man", Toast.LENGTH_SHORT).show();
					return;

				case R.id.women:
					Toast.makeText(mContext, "women", Toast.LENGTH_SHORT)
							.show();
					return;
				}

			}
		});
		stgSchool.setOnCheckedChangeListener(new OnCheckedChangeListener() {

			@Override
			public void onCheckedChanged(RadioGroup group, int checkedId) {
				switch (checkedId) {
				case R.id.student:
					Toast.makeText(mContext, "student", Toast.LENGTH_SHORT)
							.show();

					llSchoolView.setVisibility(View.VISIBLE);
					return;

				case R.id.worker:
					Toast.makeText(mContext, "worker", Toast.LENGTH_SHORT)
							.show();
					llSchoolView.setVisibility(View.GONE);
					return;
				}

			}
		});
		btnAddress.setOnClickListener(this);

	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.input_base_btn_photo:
			btnPhoto.setText("");

			final String[] arrayType = new String[] { "拍照", "相册" };

			alertDialog = new AlertDialog.Builder(this)
					.setTitle("上传个人图片")
					.setItems(arrayType, new DialogInterface.OnClickListener() {

						@Override
						public void onClick(DialogInterface dialog, int which) {
							if (which == 0) {
								pushSystemCamera();
							} else {
								pushSystemAlbum();
							}
						}
					})
					.setNegativeButton("取消",
							new DialogInterface.OnClickListener() {

								@Override
								public void onClick(DialogInterface dialog,
										int which) {
									alertDialog.dismiss();
								}
							}).create();

			alertDialog.show();
			break;
		case R.id.input_base_iv_clean_name:
			edtName.setText(null);
			ivCleanName.setVisibility(View.GONE);
			break;
		case R.id.input_base_iv_clean_school:
			edtSchool.setText(null);
			ivCleanSchool.setVisibility(View.GONE);
			break;
		case R.id.input_base_btn_birth:
			final Calendar c = Calendar.getInstance();
			int mYear = c.get(Calendar.YEAR);
			int mMonth = c.get(Calendar.MONTH);
			int mDay = c.get(Calendar.DAY_OF_MONTH);

			DatePickerDialog dialog = new DatePickerDialog(this, 0,
					new OnDateSetListener() {

						@Override
						public void onDateSet(DatePicker view, int year,
								int monthOfYear, int dayOfMonth) {
							// TODO Auto-generated method stub
							Calendar calendar = Calendar.getInstance();
							calendar.set(year, monthOfYear, dayOfMonth);
							String date = new SimpleDateFormat("yyyy-MM-dd")
									.format(calendar.getTime());
							btnBirth.setText(date);
						}
					}, mYear, mMonth, mDay);
			dialog.getDatePicker().setCalendarViewShown(false);
			dialog.show();
			break;
		case R.id.input_base_btn_live_addr:
			Intent intent = new Intent(this, LiveAddrActivity.class);
			startActivityForResult(intent, REQUEST_CODE_LIVE_ADDR);
			break;
		default:
			break;
		}

	}

	private File sdcardTempFile = new File("/mnt/sdcard/", "tmp_pic_"
			+ SystemClock.currentThreadTimeMillis() + ".jpg");
	private LinearLayout llSchoolView;
	private Dialog alertDialog;

	private void pushSystemCamera() {
		Intent intent = new Intent(
				android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
		Uri u = Uri.fromFile(sdcardTempFile);
		intent.putExtra(MediaStore.Images.Media.ORIENTATION, 0);
		intent.putExtra(MediaStore.EXTRA_OUTPUT, u);
		intent.putExtra("return-data", true);
		startActivityForResult(intent, REQUEST_CODE_CAMERA);

	}

	private void pushSystemAlbum() {
		Intent intent = new Intent(Intent.ACTION_PICK);
		intent.setType("image/*");// 相片类型
		startActivityForResult(intent, REQUEST_CODE_ALBUM);
	}

	private void cameraActionCrop(Uri mUri) {
		Intent intent = new Intent();
		intent.setAction("com.android.camera.action.CROP");
		intent.setDataAndType(mUri, "image/*");// mUri是已经选择的图片Uri
		intent.putExtra("crop", "true");
		intent.putExtra("aspectX", 1);// 裁剪框比例
		intent.putExtra("aspectY", 1);
		intent.putExtra("outputX", 150);// 输出图片大小
		intent.putExtra("outputY", 150);
		intent.putExtra("return-data", true);

		startActivityForResult(intent, REQUEST_CODE_CROP);
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {

		Log.d("mytest", "requestcode: " + requestCode + " resultCode: "
				+ resultCode);

		if (resultCode != RESULT_OK) {
			System.out.println("requestcode: " + requestCode + " resultCode: "
					+ resultCode);
			if (resultCode == RESULT_CANCELED) {
				btnPhoto.setText(R.string.upload_individual_photo);
			}
			return;
		}

		if (requestCode == REQUEST_CODE_CAMERA) {
			try {
				Uri tempUri = Uri
						.parse(android.provider.MediaStore.Images.Media
								.insertImage(getContentResolver(),
										sdcardTempFile.getAbsolutePath(), null,
										null));
				// System.out.println(tempUri.getPath());
				// ContentResolver xiangji_cr = this.getContentResolver();
				// Bitmap bmp =
				// BitmapFactory.decodeStream(xiangji_cr.openInputStream(tempUri));

				cameraActionCrop(tempUri);
				// ivPhoto.setImageBitmap(bmp);
			} catch (FileNotFoundException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
				btnPhoto.setText(R.string.upload_individual_photo);
			}

		} else if (requestCode == REQUEST_CODE_ALBUM) {
			Uri tempUri = data.getData();
			cameraActionCrop(tempUri);
		} else if (requestCode == REQUEST_CODE_CROP) {
			// 拿到剪切数据
			Bitmap bmap = data.getParcelableExtra("data");

			// 显示剪切的图像
			btnPhoto.setVisibility(View.INVISIBLE);
			ivPhoto.setImageBitmap(bmap);

		} else if (requestCode == REQUEST_CODE_LIVE_ADDR) {
			Bundle b = data.getExtras();
			String address = b.getString("address");
			btnAddress.setText(address);
			super.onActivityResult(requestCode, resultCode, data);
		} else {
			super.onActivityResult(requestCode, resultCode, data);
		}

	}

}
