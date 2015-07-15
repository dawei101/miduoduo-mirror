
$(function() {
  // Handler for .ready() called.
  $(".cuowu").hide();
});

$('form').on('submit', function(){
    $("[name='detail']")[0].value = $("#editor").html();
    $("[name='salary_unit']")[0].value = $("[name='salary_unit']")[0].value.substring(2);
});
