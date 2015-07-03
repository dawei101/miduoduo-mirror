<?php

$this->title = '我要举报';
$this->page_title = "举报";

$this->nav_left_link = 'javascript:window.history.back()';
?>
  <textarea name="Complaint[content]" id="textarea" class="text-area" placeholder="有任何意见和问题，请填入此处，我们会及时联系您"></textarea>
  <input name="Complaint[phonenum]" type="text" pattern="\d+" class="input" placeholder="联系方式" />
  <button type="submit"  class="btn-anniu"> 提交 </button>

