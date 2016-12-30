<div id="fade-respond" class="alert"></div>
<script>
   var langs = JSON.parse('<?= !empty($langs) ? json_encode($langs) : ''?>');
</script>
<?php if (!$this->uri->segment('4')): ?> 
<div class="row">
   <div class="col-md-12">
      <div class="portlet light bg-inverse">
         <div class="portlet-title" style="border-bottom:0px; margin-bottom:0!important;">
            <div class="caption"> 
               <span class="caption-subject font-red-sunglo bold uppercase"> </span>  
            </div>
            <div class="actions" id="change-content" style="padding-top:19px;"> 
               <?php $i=0 ?>
               <?php foreach ($langs as $key => $value): ?>
               <a class="btn btn-circle btn-icon-only btn-default <?=$i==0 ? 'active' : ''?> change-lang" data-lang="<?=$value?>" href="javascript:;">
               <span><?=$value?></span>
               </a>
               <?php $i++ ?>
               <?php endforeach ?> 
            </div>
         </div>
         <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="/cp/<?=$method?>/<?=$chapter['id']?>/" class="form-horizontal onsubmit" data-redirect="/cp/interview/add/?step=4&iw_id=<?=$id_interview?>">
               <input type="hidden" name="id_interview" value="<?=$id_interview?>">
               <div class="form-body">
                  <?=getInputLang($langs, false, 'Question', 'question', 'text', 'input')?> 
                  <div class="form-group">
                     <label class="col-md-1">Required</label>
                     <div class="col-md-11">
                        <input type="checkbox" name="required">
                     </div>
                  </div>
                  <div class="form-group form-md-radios">
                     <label class="control-label col-md-1"> Type: <span class="req">*</span></label>
                     <div class="col-md-11">
                        <div class="md-radio-inline">
                           <div class="md-radio">
                              <input type="radio" id="radio1" name="question_type" value="1" class="md-radiobtn select_type open_attr_block" data-href="#multiple_choice">
                              <label for="radio1">
                              <span></span>
                              <span class="check"></span>
                              <span class="box"></span>
                              One answer </label>
                           </div>
                           <div class="md-radio">
                              <input type="radio" id="radio2" name="question_type" value="2" class="md-radiobtn select_type open_attr_block" data-href="#multiple_choice">
                              <label for="radio2">
                              <span></span>
                              <span class="check"></span>
                              <span class="box"></span>
                              Multiple choice </label>
                           </div>
                           <div class="md-radio">
                              <input type="radio" id="radio3" name="question_type" value="3" class="md-radiobtn select_type open_attr_block">
                              <label for="radio3">
                              <span></span>
                              <span class="check"></span>
                              <span class="box"></span>
                              Response in the free form </label>
                           </div>
                        </div> 
                        <div id="multiple_choice">
                           <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10" onclick="addChoice(this)" style="position:relative; display:inline-block; ">
                              <a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn yellow"> 
                              <i class="fa fa-plus"></i> Add choice </a> 
                           </div>

                           <div class="form-group" id="max_choices"> 
                              <div class="col-md-3">
                                 <input type="text" placeholder="Max choices *" class="number form-control" name="max_choices">
                              </div>
                           </div>

                           <table class="table table-bordered table-hover" style="display:none;" id="put-wrapper">
                              <thead>
                                 <tr>
                                    <th style="width:80%;">Choice</th>
                                    <th style="width:10%;"></th>
                                 </tr>
                              </thead>
                              <tbody> 
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-actions">
                  <div class="row">
                     <div class="col-md-offset-1 col-md-4">
                        <a href="/cp/interview/add/?step=4&iw_id=<?=$id_interview?>" class="btn default button-previous">
                        <i class="m-icon-swapleft"></i> 
                        Back to chapter
                        </a>
                        <button type="submit" class="btn green"><?=alert('save')?></button> 
                     </div>
                  </div>
               </div>
            </form>
            <!-- END FORM-->
         </div>
      </div>
   </div>
</div>
<?php else: ?>
<div class="row">
   <div class="col-md-12">
      <div class="portlet light bg-inverse">
         <div class="portlet-title" style="border-bottom:0px; margin-bottom:0!important;">
            <div class="caption"> 
               <span class="caption-subject font-red-sunglo bold uppercase"> </span>  
            </div>
            <div class="actions" id="change-content" style="padding-top:19px;"> 
               <?php $i=0 ?>
               <?php foreach ($langs as $key => $value): ?>
               <a class="btn btn-circle btn-icon-only btn-default <?=$i==0 ? 'active' : ''?> change-lang" data-lang="<?=$value?>" href="javascript:;">
               <span><?=$value?></span>
               </a>
               <?php $i++ ?>
               <?php endforeach ?> 
            </div>
         </div>
         <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="/cp/<?=$method?>/<?=$chapter['id']?>/<?=$data['id']?>" class="form-horizontal onsubmit" data-redirect="/cp/<?=$method?>/<?=$chapter['id']?>/<?=$data['id']?>/?iw_id=<?=$id_interview?>">
               <input type="hidden" name="id_interview" value="<?=$id_interview?>">
               <div class="form-body">
                  <?=getInputLang($langs, $data, 'Question', 'question', 'text', 'input')?> 
                  <div class="form-group">
                     <label class="col-md-1">Required</label>
                     <div class="col-md-11">
                        <input type="checkbox" name="required" <?=!empty($data['required']) ? 'checked' : ''?>>
                     </div>
                  </div>
                  <div class="form-group form-md-radios">
                     <label class="control-label col-md-1"> Type: <span class="req">*</span></label>
                     <div class="col-md-11">
                        <div class="md-radio-inline">
                           <div class="md-radio">
                              <input type="radio" id="radio1" name="question_type" <?=($data['type'] == '1') ? 'checked' : ''?> value="1" class="md-radiobtn select_type open_attr_block" data-href="#multiple_choice">
                              <label for="radio1">
                              <span></span>
                              <span class="check"></span>
                              <span class="box"></span>
                              One answer </label>
                           </div>
                           <div class="md-radio">
                              <input type="radio" id="radio2" name="question_type" <?=($data['type'] == '2') ? 'checked' : ''?> value="2" class="md-radiobtn select_type open_attr_block" data-href="#multiple_choice">
                              <label for="radio2">
                              <span></span>
                              <span class="check"></span>
                              <span class="box"></span>
                              Multiple choice </label>
                           </div>
                           <div class="md-radio">
                              <input type="radio" id="radio3" name="question_type" <?=($data['type'] == '3') ? 'checked' : ''?> value="3" class="md-radiobtn select_type open_attr_block">
                              <label for="radio3">
                              <span></span>
                              <span class="check"></span>
                              <span class="box"></span>
                              Response in the free form </label>
                           </div>
                        </div> 
                        <div id="multiple_choice">
                           <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10" onclick="addChoice(this)" style="position:relative; display:inline-block; ">
                              <a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn yellow"> 
                              <i class="fa fa-plus"></i> Add choice </a> 
                           </div>

                           <div class="form-group" id="max_choices"> 
                              <div class="col-md-3">
                                 <input type="text" placeholder="Max choices *" value="<?=$data['max_choices']?>" class="number form-control" name="max_choices">
                              </div>
                           </div>

                           <table class="table table-bordered table-hover" style="display:none;" id="put-wrapper">
                              <thead>
                                 <tr>
                                    <th style="width:80%;">Choice</th> 
                                    <th style="width:10%;"></th>
                                 </tr>
                              </thead>
                              <tbody> 
                              </tbody>
                           </table>
                           <?php if ($data['type'] !== '3'): ?> 
                           <?php 
                              $sql = $this->db->where('id_question', $data['id'])
                                                 ->where('delete', '0')
                                                 ->order_by('page_up', 'asc')
                                                 ->order_by('id', 'desc')
                                                 ->get('choice')
                                                 ->result_array();
                              
                                  $getChoice = getTranslateArray($sql, array('name'), 'choice_lang', true, $langs);  
                              ?>
                           <?php if (!empty($getChoice)): ?> 
                           <table class="table table-bordered table-hover" style="">
                              <thead>
                                 <tr>
                                    <th width="5%"></th>
                                    <th><i class="fa fa-eye fa-center"></i></th>
                                    <th style="width:75%;">Choice</th> 
                                    <th style="width:10%;"></th>
                                 </tr>
                              </thead>
                              <tbody id="sort-items" data-table="choice">
                                 <?php foreach ($getChoice as $item): ?>
                                 <tr id="<?=$item['id']?>">
                                    <td style="width:50px; text-align:center;" class="handle"></td>
                                    <td class="t-border" style="width:30px;"> 
                                       <?php if ($item['view'] == 1): ?>
                                       <input checked onclick="buttonView(this, 'choice', '<?=$item['id']?>')" class="checkbox" type="checkbox"> 
                                       <?php else: ?>
                                       <input onclick="buttonView(this, 'choice', '<?=$item['id']?>')" class="checkbox" type="checkbox">
                                       <?php endif ?>  
                                    </td>
                                    <td>
                                       <?php foreach ($langs as $l_key => $l_val): ?>
                                       <div class="lang-area field_<?=$l_val?>">
                                          <input type="text" name="update_choice[<?=$l_val?>][<?=$item['id']?>]" value="<?=$item["name_{$l_val}"]?>" class='form-control'>
                                       </div>
                                       <?php endforeach ?>  
                                    </td> 
                                    <td>
                                       <a data-toggle="modal" href="#myModal<?=$item['id']?>_rel" class="btn default btn-sm">
                                       <i class="fa fa-times"></i> Delete </a> 
                                       <div class="modal fade theme-modal" id="myModal<?=$item['id']?>_rel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                   <button class="btn btn-success" type="button" onclick="toDelete(this,'<?=base_url('cp/deleteElement/')?>','<?=$item['id']?>', 'choice')"><?=alert('delete')?></button>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </td>
                                 </tr>
                                 <?php endforeach ?>
                              </tbody>
                           </table>
                           <?php endif ?>
                           <?php endif ?>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-actions">
                  <div class="row">
                     <div class="col-md-offset-1 col-md-4">
                        <a href="/cp/interview/add/?step=4&iw_id=<?=$id_interview?>" class="btn default button-previous">
                        <i class="m-icon-swapleft"></i> 
                        Back to chapter
                        </a>
                        <button type="submit" class="btn green"><?=alert('save')?></button> 
                     </div>
                  </div>
               </div>
            </form>
            <!-- END FORM-->
         </div>
      </div>
   </div>
</div>
<?php endif ?>

 
<script>
$(document).ready(function(){ 
   $('input[name="question_type"]').change(function(){
      var val = $(this).val();
      if (val == '2') {
         $('#max_choices').show();
      }else{
         $('#max_choices').hide();
      }
   });

   var val_question_type = $('input[name="question_type"]:checked').val();
   if (val_question_type == '2') {
      $('#max_choices').show();
   }else{
      $('#max_choices').hide();
   }
});
</script>