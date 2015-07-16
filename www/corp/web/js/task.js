$('.task-refresh').on('click', function(){
    $.get('/task/refresh', {gid : $(this).attr('gid')})
    .done(function(data){
        location.reload();
    });
});

$('.task-edit').on('click', function(){
    window.location = '/task/edit?gid=' + $(this).attr('gid');
});

$('.task-down').on('click', function(){
    $.get('/task/down', {gid : $(this).attr('gid')})
    .done(function(data){
        location.reload();
    });
});

$('.task-delete').on('click', function(){
    $.get('/task/delete', {gid : $(this).attr('gid')})
    .done(function(data){
        location.reload();
    });
});
