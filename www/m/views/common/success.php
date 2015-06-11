<?php $this->beginContent('@m/views/layouts/main.php'); ?>
<div class="container">
     <div style="font-size:1.6em; width:80%; margin:0 auto; padding:50px 0 30px; background:url(/static/img/suc-icon.png) left no-repeat; padding-left:70px">
        <?=$message?>
    </div>
    <p class="block-btn">
    <a class="btn btn-primary btn-lg btn-block" href="<?=$next?>" >确定</a>
    </p>
</div>
<?php $this->endContent(); ?>
