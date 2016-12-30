<li class="dd-item dd3-item" data-id="<?=$category['id']?>">
   <div class="dd-handle dd3-handle handle "></div>
   <div class="dd3-content clearfix">
      <p style="float:left; margin:0 !important;">
         <a href="/cp/projects/<?=$category['id']?>">
            <?php if ($category['view'] == 1): ?>
               <input checked onclick="buttonView(this, 'projects', '<?=$category['id']?>')" class="checkbox" name="view" type="checkbox"> 
            <?php else: ?>
               <input onclick="buttonView(this, 'projects', '<?=$category['id']?>')" class="checkbox" name="view" type="checkbox">
            <?php endif ?>  

            <?=$category['name_'.var_data_lang]?>
         </a>
      </p>
      <p style="float:right; margin:0 !important;"> 
         <a href="/cp/emails-list/?pr_id=<?=$category['id']?>" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-envelope" aria-hidden="true"></i></a>
         <a href="/cp/projects/<?=$category['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>  
         <a class="btn btn-danger btn-xs" data-toggle="modal" href="#myModal<?=$category['id']?>"><i class="fa fa-trash-o "></i></a>  
         <!-- Modal -->
         <div class="modal fade theme-modal" id="myModal<?=$category['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title"><?=alert('confirm_action')?></h4>
                  </div>
                  <div class="modal-body"> 
                     <?=alert('confirm_question')?>
                  </div>
                  <div class="modal-footer">
                     <button data-dismiss="modal" class="btn btn-default" type="button"><?=alert('cancel')?></button>
                     <button class="btn btn-success" type="button" onclick="toDelete(this,'<?=base_url('cp/deleteElement/')?>','<?=$category['id']?>', 'projects')"><?=alert('delete')?></button>
                  </div>
               </div>
            </div>
         </div>
         <!-- Modal --> 
      </p>   
   </div>
   <?php if (isset($category['childs'])): ?>
   <ol class="dd-list">
      <?=categories_to_string($category['childs'], 'cat-list') ?>
   </ol>
   <?php endif ?> 
</li>

 