
$(function() {
  // Handler for .ready() called.
  $(".cuowu").hide();
});

$('form').on('submit', function(){
    $("[name='detail']")[0].value = $("#editor").html();
    var su = $("[name='salary_unit']")[0].value;
    if(su.indexOf('/') >= 0) su = su.substring(2);
    $("[name='salary_unit']")[0].value = su;
});
