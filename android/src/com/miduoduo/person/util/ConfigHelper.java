package com.miduoduo.person.util;

import android.content.Context;
import android.content.SharedPreferences;

public class ConfigHelper {
	
	public static long CONFIG_GUIDE_DELAY_MILLIS = 1000;

	public static String CONFIG_KEY_SP_NAME = "miduoduo_sp";
	public static String CONFIG_KEY_IS_FIRST_RUN = "is_first_run";
	
    //配置项名称
    /**记住密码*/
    public static String CONFIG_KEY_REMEMBER_PASSWORD = "remember_password";
    /**自动登录*/
    public static String CONFIG_KEY_AUTO_LOGIN = "auto_login";
    /**最后登录用户id*/
    public static String CONFIG_KEY_USER_ID = "user_id";
    /**最后登录用户名*/
    public static String CONFIG_KEY_USER_NAME = "user_name";
    /**最后登录用户所在的省份id*/
    public static String CONFIG_KEY_USER_PROVINCE_ID = "user_province_id";
    /**最后登录用户名id*/
    public static String CONFIG_KEY_USER_CITY_ID = "user_city_id";
    public static String CONFIG_KEY_PASSPORT = "passport";
    
    private static ConfigHelper instance = null;
    protected SharedPreferences mSettings;
    protected SharedPreferences.Editor mEditor;
    private Context mContext = null;
    
    private ConfigHelper(Context context) {
    	mContext = context;
        mSettings = mContext.getSharedPreferences(CONFIG_KEY_SP_NAME, 0);
        mEditor = mSettings.edit();
    }
    
    public static ConfigHelper getInstance(Context context) {
    	if(instance == null) {
    		instance = new ConfigHelper( context.getApplicationContext());
    	}
    	
    	return instance;
    }
    
    public void removeKey(String key) {
        mEditor.remove(key);
        mEditor.commit();
    }
    
    public boolean readBoolean(String key,boolean defValue) {
    	return mSettings.getBoolean(key, defValue);
    }
    
    
    public boolean readBoolean(String key) {
    	return mSettings.getBoolean(key, false);
    }
    
    public boolean writeBoolean(String key,boolean value) {
       	mEditor.putBoolean(key, value);
    	return mEditor.commit();
    }
    
    public int readInt(String key) {
    	return mSettings.getInt(key, 0);
    }
    
    public boolean writeInt(String key,int value) {
    	mEditor.putInt(key, value);
    	return mEditor.commit();
    }
    
    public String readString(String key) {
    	return mSettings.getString(key, null);
    }
    
    public boolean writeString(String key,String value) {
    	mEditor.putString(key, value);
    	return mEditor.commit();
    }
}
