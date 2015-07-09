$('.task-refresh').on('click', function(){
    $.get('/task/refresh', {gid : $(this).attr('gid')})
    .done(function(data){
        console.log(data);
    });
});

$('.task-edit').on('click', function(){
    $.get('/task/edit', {gid : $(this).attr('gid')})
    .done(function(data){
        console.log(data);
    });
});

$('.task-down').on('click', function(){
    $.get('/task/down', {gid : $(this).attr('gid')})
    .done(function(data){
        console.log(data);
    });
});

$('.task-delete').on('click', function(){
    $.get('/task/delete', {gid : $(this).attr('gid')})
    .done(function(data){
        console.log(data);
    });
});
