
$(function() {
  // Handler for .ready() called.
  $(".cuowu").hide();
});

$('form').on('submit', function(){
    var form = document.forms[0];
    form.detail.value = $("#editor").html();
    var su = form.salary_unit.value;
    if(su.indexOf('/') >= 0) su = su.substring(2);
    form.salary_unit.value = su;

    if (form.title.value.length == 0) {
        $('title-error').html('请输入兼职标题');
        return false;
    }

    return true;

});
