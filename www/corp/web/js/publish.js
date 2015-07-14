
$(function() {
  // Handler for .ready() called.
  $(".cuowu").hide();
});

$('form').on('submit', function(){
    $("[name='detail']")[0].value = $("#editor").html();
});

$("#address_count").on('change', function(){
    console.log($(this).value);
});
