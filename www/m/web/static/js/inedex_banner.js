$(document).ready(function(){
  $('.bxslider').bxSlider({
  captions: true,//自动控制
        auto: true,
        // speed: 5000,
        pause: 2000,
        infiniteLoop: true,
        controls: false,
        autoHover: false,
});

  $('.bx-controls').css('position', 'relative');
  $('.bx-default-pager').css('position', 'absolute');
  $('.bx-default-pager').css('top', '-30px');
  $('.bx-default-pager').css('width', '100%');
  //$('.bx-default-pager').css('padding-left', '68%');
});


