$('.names').on('click', function(){
    $.get('/resume/read', {aid : $(this).attr('aid')})
    .done(function(data){
        // location.reload();
    });
});

$('.jishou').on('click', function(){
    $('#current-aid').val( $(this).attr('aid') );
    $('#current-taskid').val( $(this).attr('taskid') );
    $('#tongzhi-1').addClass('is-visible');
});

$('.need-notice').on('click', function(){
    $.get('/resume/notice-info',{taskid:$("#current-taskid").val()})
    .done(function(data){
        var notice_info = eval('('+data+')');
        $('#meet_time').val( notice_info.meet_time );
        $('#place').val( notice_info.place );
        $('#linkman').val( notice_info.linkman );
        $('#phone').val( notice_info.phone );
        $('#task_id').val( notice_info.task_id );
        $('#task-title').html( notice_info.task_title );
        if( notice_info.type == 2 ){
            $('#type2').attr('checked','checked');
        }else{
            $('#type1').attr('checked','checked');
        }
    });

    $('#tongzhi-1').removeClass('is-visible');
    $('#tongzhi-2').addClass('is-visible');
});

$('.unneed-notice').on('click', function(){
    $.get('/resume/pass', {aid : $("#current-aid").val()})
    .done(function(data){
        location.reload();
    });
    $('#tongzhi-1').removeClass('is-visible');
});

$('.jujue').on('click', function(){
    $.get('/resume/reject', {aid : $(this).attr('aid')})
    .done(function(data){
        location.reload();
    });
});

jQuery(document).ready(function($){
	//open popup
	$('.cd-popup-trigger').on('click', function(event){
		event.preventDefault();
		$('.cd-popup').addClass('is-visible');
	});
	
	//close popup
	$('.cd-popup').on('click', function(event){
		if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		}
	});
	//close popup when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$('.cd-popup').removeClass('is-visible');
	    }
    });
});
