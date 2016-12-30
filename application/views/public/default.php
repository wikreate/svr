<h1><?=isset($data["name_{$lang}"]) ? $data["name_{$lang}"] : $pages["name_{$lang}"]?></h1>
<div class="content_wr">
    <?=isset($data["text_{$lang}"]) ? $data["text_{$lang}"] : $pages["text_{$lang}"]?>
    <div class="clear"></div>
    <?php if (!empty($uri2) && $uri2=='articles'): ?>
    	<div class="b_btn" style="margin-top:25px;"><a href="/" class="btn v1"> <?=BACK_HOME_BUTTON?></a></div>
    <?php endif ?> 
</div>
 