package com.miduoduo.person.util;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.Map;

import android.content.Context;
import android.content.SharedPreferences;

/**
 * <ul>
 * <li>类描述：共享参数工具类
 * <li>创建人：liyunlong
 * <li>创建时间：2015-3-13 下午8:24:20
 * </ul>
 */
public class SharedPreferencesUtils {

	/**
	 * 存储文件名
	 */
	public static final String SHAREDPREFERENCES_NAME = "miduoduo_config";

	private SharedPreferencesUtils() {
		throw new AssertionError();
	}

	/**
	 * 得到SharedPreferences对象
	 */
	private static SharedPreferences getSharedPreferences(Context context) {
		return context.getSharedPreferences(SHAREDPREFERENCES_NAME,
				Context.MODE_PRIVATE);
	}

	/**
	 * 读取int类型参数
	 */
	public static int getInt(Context context, String key, int defValue) {
		return getSharedPreferences(context).getInt(key, defValue);
	}

	/**
	 * 写入int类型参数
	 */
	public static void putInt(Context context, String key, int value) {
		getSharedPreferences(context).edit().putInt(key, value).commit();
	}

	/**
	 * 读取float类型参数
	 */
	public static float getFloat(Context context, String key, float defValue) {
		return getSharedPreferences(context).getFloat(key, defValue);
	}

	/**
	 * 写入float类型参数
	 */
	public static void putFloat(Context context, String key, float value) {
		getSharedPreferences(context).edit().putFloat(key, value).commit();
	}

	/**
	 * 读取long类型参数
	 */
	public static long getLong(Context context, String key, long defValue) {
		return getSharedPreferences(context).getLong(key, defValue);
	}

	/**
	 * 写入long类型参数
	 */
	public static void putLong(Context context, String key, long value) {
		getSharedPreferences(context).edit().putLong(key, value).commit();
	}

	/**
	 * 读取String类型参数
	 */
	public static String getString(Context context, String key, String defValue) {
		return getSharedPreferences(context).getString(key, defValue);
	}

	/**
	 * 写入String类型参数
	 */
	public static void putString(Context context, String key, String value) {
		getSharedPreferences(context).edit().putString(key, value).commit();
	}

	/**
	 * 读取boolean类型参数
	 * 
	 * @param context
	 * @param key
	 * @return
	 */
	public static boolean getBoolean(Context context, String key,
			boolean defValue) {
		return getSharedPreferences(context).getBoolean(key, defValue);
	}

	/**
	 * 写入boolean类型参数
	 */
	public static void putBoolean(Context context, String key, boolean value) {
		getSharedPreferences(context).edit().putBoolean(key, value).commit();
	}

	/**
	 * 保存数据的方法，拿到保存数据的具体类型，然后根据类型调用不同的保存方法
	 */
	public static void put(Context context, String key, Object object) {

		SharedPreferences preferences = getSharedPreferences(context);
		SharedPreferences.Editor editor = preferences.edit();

		if (object instanceof String) {
			editor.putString(key, (String) object);
		} else if (object instanceof Integer) {
			editor.putInt(key, (Integer) object);
		} else if (object instanceof Boolean) {
			editor.putBoolean(key, (Boolean) object);
		} else if (object instanceof Float) {
			editor.putFloat(key, (Float) object);
		} else if (object instanceof Long) {
			editor.putLong(key, (Long) object);
		} else {
			editor.putString(key, object.toString());
		}

		SharedPreferencesCompat.apply(editor);
	}

	/**
	 * 保存数据的方法，根据默认值得到保存的数据的具体类型，然后调用相对应的方法获取值
	 * 
	 * @return 返回key对应的值
	 */
	public static Object get(Context context, String key, Object defaultObject) {
		SharedPreferences preferences = getSharedPreferences(context);

		if (defaultObject instanceof String) {
			return preferences.getString(key, (String) defaultObject);
		} else if (defaultObject instanceof Integer) {
			return preferences.getInt(key, (Integer) defaultObject);
		} else if (defaultObject instanceof Boolean) {
			return preferences.getBoolean(key, (Boolean) defaultObject);
		} else if (defaultObject instanceof Float) {
			return preferences.getFloat(key, (Float) defaultObject);
		} else if (defaultObject instanceof Long) {
			return preferences.getLong(key, (Long) defaultObject);
		}

		return null;
	}

	/**
	 * 移除某个key对应的值
	 */
	public static void remove(Context context, String key) {
		SharedPreferences preferences = getSharedPreferences(context);
		SharedPreferences.Editor editor = preferences.edit();
		if (preferences.contains(key)) {
			editor.remove(key);
		}
		SharedPreferencesCompat.apply(editor);
	}

	/**
	 * 清除所有数据
	 */
	public static void clear(Context context) {
		SharedPreferences preferences = getSharedPreferences(context);
		SharedPreferences.Editor editor = preferences.edit();
		editor.clear();
		SharedPreferencesCompat.apply(editor);
	}

	/**
	 * 查询某个key是否已经存在
	 * @return 如果key已经存在则返回true，反之返回false
	 */
	public static boolean contains(Context context, String key) {
		return getSharedPreferences(context).contains(key);
	}

	/**
	 * 返回所有的键值对
	 * @return 返回所有的键值对
	 */
	public static Map<String, ?> getAll(Context context) {
		return getSharedPreferences(context).getAll();
	}

	/**
	 * 创建一个解决SharedPreferencesCompat.apply方法的一个兼容类
	 */
	private static class SharedPreferencesCompat {

		private static final Method applyMethod = findApplyMethod();

		/**
		 * 反射查找apply的方法
		 */
		@SuppressWarnings({ "unchecked", "rawtypes" })
		private static Method findApplyMethod() {
			try {
				Class clzz = SharedPreferences.Editor.class;
				return clzz.getMethod("apply");
			} catch (NoSuchMethodException e) {
			}

			return null;
		}

		/**
		 * 如果找到则使用apply执行，否则使用commit
		 * 
		 * @param editor
		 */
		public static void apply(SharedPreferences.Editor editor) {
			try {
				if (applyMethod != null) {
					applyMethod.invoke(editor);
					return;
				}
			} catch (IllegalArgumentException e) {
			} catch (IllegalAccessException e) {
			} catch (InvocationTargetException e) {
			}
			editor.commit();
		}
	}

}
