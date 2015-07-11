$('.names').on('click', function(){
    $.get('/resume/read', {aid : $(this).attr('aid')})
    .done(function(data){
        // location.reload();
    });
});

$('.jishou').on('click', function(){
    $.get('/resume/pass', {aid : $(this).attr('aid')})
    .done(function(data){
        location.reload();
    });
});

$('.jujue').on('click', function(){
    $.get('/resume/reject', {aid : $(this).attr('aid')})
    .done(function(data){
        location.reload();
    });
});
