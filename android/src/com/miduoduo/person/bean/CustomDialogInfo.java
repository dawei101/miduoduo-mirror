package com.miduoduo.person.bean;

public class CustomDialogInfo {

	private String title;
	private String message;
	private String confirmText;
	private String canclemText;

	public CustomDialogInfo(String title, String message, String confirmText,
			String canclemText) {
		super();
		this.title = title;
		this.message = message;
		this.confirmText = confirmText;
		this.canclemText = canclemText;
	}

	public String getTitle() {
		return title;
	}

	public void setTitle(String title) {
		this.title = title;
	}

	public String getMessage() {
		return message;
	}

	public void setMessage(String message) {
		this.message = message;
	}

	public String getConfirmText() {
		return confirmText;
	}

	public void setConfirmText(String confirmText) {
		this.confirmText = confirmText;
	}

	public String getCanclemText() {
		return canclemText;
	}

	public void setCanclemText(String canclemText) {
		this.canclemText = canclemText;
	}

}
