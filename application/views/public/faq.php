<a href="/<?=$lang?>/<?=union_uri('survey')?>" class="back">Назад<br>к опросу</a>
	<?php if (!empty($categories)): ?>
		<div class="tabs ib_wr">
		<?php foreach ($categories as $item): ?>
			<?php $active = (uri(4) == $item['id']) ? 'active' : ''; ?>
			<a class="<?=$active?>" href="/<?=$lang?>/faq/cat/<?=union_uri($item['id'])?>"><span><?=$item['name']?></span> </a> 
		<?php endforeach ?> 
		</div>
	<?php endif ?>
	 
	<div class="tab_content">
		<div class="tab_item" style="opacity:1; display:block;">
			<h1>Вопросы и Ответы - Происшествия</h1>
			<?php foreach ($data as $item): ?>
				<dl>
					<dt><?=$item['name']?></dt>
					<dd>
						<?= htmlspecialchars_decode($item['text']) ?>
					</dd>
				</dl>
			<?php endforeach ?> 

			<?php if (!empty($navigation)): ?> 
		        <div class="pagination ib_wr">
		            <?php if (!empty($navigation['first'])): ?>
		                <a href="<?=$uri?><?=union_uri($navigation['first'])?>">
		                    <i class="fa fa-angle-double-left" aria-hidden="true"></i>
		                </a>  
		                <?php endif ?> 
		                <?php if (!empty($navigation['prev_page'])): ?>
		                    <a href="<?=$uri?> <?=union_uri($navigation['prev_page'])?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a>  
		                <?php endif ?>
		                <?php if (!empty($navigation['prev_dots_page'])): ?>
		                    <a href="<?=$uri?><?=union_uri($navigation['first'])?>">
		                        <?=$navigation['first']?>
		                    </a>  
		                <?php endif ?>  
		                <?php if (!empty($navigation['prev_dots'])): ?>
		                    <a href="javascript:;" style="cursor:default;" onclick="return false;">
		                        ...
		                    </a>  
		                <?php endif ?>
		                <?php if (!empty($navigation['previous'])): ?>
		                    <?php foreach ($navigation['previous'] as $value_prev): ?>
		                        <a href="<?=$uri?><?=union_uri($value_prev)?>"><?=$value_prev?></a> 
		                    <?php endforeach ?> 
		                <?php endif ?>
		                <?php if (!empty($navigation['current'])): ?>
		                    <a href="" class="active">  <?=$navigation['current']?></a> 
		                <?php endif ?>
		                <?php if (!empty($navigation['next'])): ?>
		                    <?php foreach ($navigation['next'] as $value_next): ?>
		                        <a href="<?=$uri?><?=union_uri($value_next)?>"><?=$value_next?></a> 
		                    <?php endforeach ?> 
		                <?php endif ?>
		                <?php if (!empty($navigation['last_dots'])): ?>
		                    <a href="javascript:;" style="cursor:default;" onclick="return false;">
		                        ...
		                    </a>  
		                <?php endif ?>
		                <?php if (!empty($navigation['last_dots_page'])): ?> 
		                    <a href="<?=$uri?><?=union_uri($navigation['end']['0'])?>">
		                        <?=$navigation['end']['0']?>
		                    </a>  
		                <?php endif ?>  
		                <?php if (!empty($navigation['next_pages'])): ?>
		                    <a href="<?=$uri?><?=union_uri($navigation['next_pages']['0'])?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a> 
		                <?php endif ?>
		                <?php if (!empty($navigation['end'])): ?> 
		                    <a href="<?=$uri?><?=union_uri($navigation['end']['0'])?>">
		                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
		                </a>  
		            <?php endif ?>
		        </div> 
			<?php endif ?> 
		</div>  
	  
	</div>
	<div class="feedback">
		<h2>Не можете найти ответ на свой вопрос?<br>Задайте свой вопрос нам</h2>
		<form>
			<div class="f_row"><input type="text" name="" id="" placeholder="Ваше имя"></div>
			<div class="f_row"><input type="text" name="" id="" placeholder="Ваш e-mail"></div>
			<div class="f_row"><textarea name="" id="" cols="30" rows="10" placeholder="Ваше имя"></textarea></div>
			<div class="b_btn">
				<input type="submit" value="Задать вопрос">
				<span class="hint">вставить какой-то короткий текст на 2 строки, типа ваш емэйл может<br>
				использоваться для проясннеия ситуации, или что-то такое</span>
			</div>
		</form>
	</div>
	<div class="clear"></div>