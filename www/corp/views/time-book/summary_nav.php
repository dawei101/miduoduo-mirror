<div class="gl_title_top">
    <div class="yuangong"><span>员工总数</span><span class="span_t">288</span></div>
    <div class="zaigang"><span>目前在职</span><span class="span_t">288</span></div>
    <div class="lizhi"><span>已经离职</span><span class="span_t">288</span></div>
</div>
<div class="container" style="clear: both;">
    <ul class="nav nav-tabs">
        <li class="<?=$subject=='worker'?'active':''?>" role="presentation">
            <a href="/time-book/worker-summary?gid=<?=$task->gid?>"> 按人员 </a> </li>
        <li class="<?=$subject=='address'?'active':''?>" role="presentation">
            <a href="/time-book/address-summary?gid=<?=$task->gid?>"> 按地点 </a> </li>
        <li class="<?=$subject=='date'?'active':''?>" role="presentation">
            <a href="/time-book/date-summary?gid=<?=$task->gid?>"> 按日期 </a> </li>
    </ul>
</div>

