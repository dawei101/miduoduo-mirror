
$(function() {
  if ($("#address_count").val() == '一个') {
      $(".tagBox-add-tag").hide();
  }else {
      $(".tagBox-add-tag").show();
  }
});

$('form').on('submit', function(){
    $('.cuowu').hide();
    var form = document.forms[0];
    form.detail.value = $("#editor").html();
    var su = form.salary_unit.value;
    if(su.indexOf('/') >= 0) su = su.substring(2);
    form.salary_unit.value = su;
    var valid = true;
    if (form.title.value.length == 0) {
        $('.title-error').html('请输入兼职标题');
        $('.title-error').show();
        valid = false;
    }
    if (form.service_type_id.value.length == 0) {
        $('.service_type_id-error').html('请选择兼职类别');
        $('.service_type_id-error').show();
        valid = false;
    }
    if (form.need_quantity.value.length == 0) {
        $('.need_quantity-error').html('请输入人数');
        $('.need_quantity-error').show();
        valid = false;
    }
    if (form.salary.value.length == 0) {
        $('.salary-error').html('请输入薪酬');
        $('.salary-error').show();
        valid = false;
    }else if (form.salary_unit.value.length == 0) {
        $('.salary-error').html('请选择金额单位');
        $('.salary-error').show();
        valid = false;
    }else if (form.clearance_period.value.length == 0) {
        $('.salary-error').html('请选择结算方式');
        $('.salary-error').show();
        valid = false;
    }
    if (!form.phone_contact.checked && !form.sms_contact.checked) {
        $('.enroll-error').html('请至少选择一种报名方式');
        $('.enroll-error').show();
        valid = false;
    }
    if (!form.protocol.checked) {
        $('.protocol-error').html('请确认米多多发布兼职协议');
        $('.protocol-error').show();
        valid = false;
    }
    if(valid === false){
        $('html,body').scrollTop(0);
    }
    
    return valid;

});

$('#address_count').change(function(){
    var value = $(this).val();
    if (value == '一个') {
        $(".tagBox-add-tag").hide();
        $(".tagBox-input").show();
    }else if (value == '不限') {
        $(".tagBox-add-tag").hide();
        $(".tagBox-input").hide();
    }else{
        $(".tagBox-add-tag").show();
        $(".tagBox-input").show();
    }
});

$('#search-address').keypress(function(e) {
  var code = (e.keyCode ? e.keyCode : e.which);
  if(code==13) {
    console.log('search address clicked');
    return false;
  }
});
