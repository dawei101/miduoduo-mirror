package com.miduoduo.person.global;

import com.miduoduo.person.bean.User;
import com.miduoduo.person.util.Utils;

public class GlobalInfo {

	
	private static User user = null;
	
	public static void setCurrentUser(User u) {
		user = u;
	}
	
	public static User getCurrentUser() {
		return user;
	}
	
	public static boolean hasLogin() {
		boolean login = false;
		

		if (user != null && !Utils.isEmpty(user.getUsername()) ) {
			login = true;
		}
		
		return login;
	}
}
