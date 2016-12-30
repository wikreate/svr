 
	<h1 class="title1">
		<?=$survey['name']?>
		<?php 
			$classStatus = '';
			$iconStatus  = '';

			if (!empty($chapter['chapter_status']) && !empty($chapter['start_chapter_time'])) {
				$classStatus = 'confirmChapter';
				$iconStatus  = '<i class="fa fa-check" aria-hidden="true"></i>';
			}elseif(!empty($chapter['start_chapter_time'])){
				$classStatus = 'dangerChapter';
				$iconStatus  = '<i class="fa fa-exclamation" aria-hidden="true"></i>';
			}
		 ?>
		<span id="status" class="<?=$classStatus?>">
			<?=$iconStatus?>
		</span> 
	</h1>

	<h2 class="title2"><?=$chapter['name']?></h2>

	<form action="/<?=$lang?>/saveSurvey/" method="POST" class="onsubmit survey_form">
	<input type="hidden" name="chapter" value="<?=$chapterNum?>">
	<input type="hidden" name="id_chapter" value="<?=$chapter['id']?>">
	<?php if (!empty($questions)): ?>
		<?php foreach ($questions as $item): ?>
			<?php 
				$req = '';
				if (!empty($item['required'])) {
					$req = '<span class="req">*</span>';
				}
			?>
			<?php if ($item['type'] == '1'): ?> 
				<div class="c_wr b_info">
					<h3><?=$item['question']?> <?=$req?></h3>
					<?php 
						$choice = $this->pages_model->getQuestionChoice($item['id']); 
					?>
					<?php if (!empty($choice)): ?>
						<div class="vote ib_wr"> 
							<?php foreach ($choice as $row): ?>

								<?php 
									$checked = '';
									$class   = '';
									if (!empty($answer[$item['id']]) && $answer[$item['id']] == $row['id']) {
										$class   = 'active';
										$checked = 'checked';
									}
								 ?>

								<span class="check_tab <?=$class?>" data-space="<?=$item['id']?>">
									<?=$row['name']?>
									<input <?=$checked?> type="radio" name="response[<?=$item['id']?>]" value="<?=$row['id']?>">
								</span>
							<?php endforeach ?> 
						</div>
					<?php endif ?> 
				</div>

			<?php elseif($item['type'] == '2'): ?>
				<div class="c_wr b_info1"> 
					<h3><?=$item['question']?> <?=$req?> <p>(Mark up to <?=$item['max_choices']?> choices)</p></h3> 
					<?php 
						$choice = $this->pages_model->getQuestionChoice($item['id']); 
					?>
					<?php if (!empty($choice)): ?>
						<div class="cols">
							<?php $i = 1; ?>
							<?php foreach ($choice as $row): ?>
								<?php 
									$forLabel = $row['id'].'_'.$i;
									$checked = '';
									if (!empty($answer[$item['id']]) && array_key_exists($row['id'], $answer[$item['id']])) {
										$checked = 'checked';
									}
								?>
								<p><input <?=$checked?> type="checkbox" name="response[<?=$item['id']?>][<?=$row['id']?>]" id="<?=$forLabel?>"><label for="<?=$forLabel?>"><?=$row['name']?></label></p> 
								<?php $i++; ?>
							<?php endforeach ?> 
						</div>
					<?php endif ?> 
				</div>
			<?php elseif($item['type'] == '3'): ?>
				<?php 
					$value = '';
					if (!empty($answer[$item['id']])) {
						$value = $answer[$item['id']];
					}

				?>
				<div class="c_wr">
					<h3><?=$item['question']?> <?=$req?></h3>
					<textarea name="response[<?=$item['id']?>]"><?=$value?></textarea>
				</div>
			<?php endif ?>
		<?php endforeach ?>
	<?php endif ?> 
	 
	<div class="progress">
		<div class="p_bar">
			<div><div style="width: 55%;"><span class="num">55%</span></div></div>
		</div>
		<?php if ($chapterNum > 1): ?>
			<a href="/<?=$lang?>/survey/<?=union_uri($chapterNum-1)?>"><div class="ctrl prev">Назад</div></a>
		<?php endif ?> 

		<?php if ($chapterNum < count($chapters)): ?>  
			<a href="/<?=$lang?>/survey/<?=union_uri($chapterNum+1)?>">
				<div class="ctrl next">Вперед</div>
			</a>
			<!-- <button type="submit" id="submit-btn" class="ctrl next">Вперед</button>   -->
		<?php endif ?> 
		
		<!-- <div class="save_btn clearfix">
			<button type="submit" id="submit-btn">Сохранить</button>
		</div> -->
		 
	</div>

	<div id="error-respond"></div>
</form>
<div class="clear"></div>

  