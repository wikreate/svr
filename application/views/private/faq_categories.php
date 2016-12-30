<?php if (!empty($_SESSION['msg'])): ?>
<div class="row">
   <div class="col-md-12">
      <?=$_SESSION['msg']?>
      <?php unset($_SESSION['msg'])?>
   </div>
</div>
<?php endif ?>
<?php if (!$this->uri->segment(3)): ?>
<div class="note note-success" id="add_post" style="cursor:pointer; background-color:#F5F5F5;">
   <i class="fa fa-plus"></i> <?=alert('add')?>
</div>
<?php endif ?>
<div id="fade-respond" class="alert"> </div>
<?php if (!$this->uri->segment(3)): ?> 
<div class="row taggle_win">
   <div class="col-md-12">
      <div class="portlet light bg-inverse">
         <div class="portlet-title" style="border-bottom:0px; margin-bottom:0!important;">
            <div class="caption">
               <span class="caption-subject font-red-sunglo bold uppercase"> </span> 
                
            </div>

            <div class="actions" id="change-content">
               <?php $i=0 ?>
               <?php foreach ($lang_arr as $key => $value): ?>
               <a class="btn btn-circle btn-icon-only btn-default <?=$i==0 ? 'active' : ''?> change-lang" data-lang="<?=$value?>" href="javascript:;">
               <span><?=$value?></span>
               </a>
               <?php $i++ ?>
               <?php endforeach ?> 
            </div>
         </div>

         <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="/cp/<?=$method?>/" class="form-horizontal onsubmit" data-redirect="/cp/<?=$method?>/">
               <div class="form-body"> 
                  <?=getInputLang(false, false, 'Name', 'name', 'text', 'input')?>          
               </div>
               <div class="form-actions">
                  <div class="row">
                     <div class="col-md-offset-1 col-md-11">
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
<?php if (!empty($data)): ?>
<div class="row">
   <div class="col-md-12"> 
      <div class="dd" id="nestable" data-table="<?=$db_table?>">
         <ol class="dd-list"> 
            <?php function catList($data, $method, $db_table){?>
                  <?php foreach ($data as $category): ?> 
                     <li class="dd-item dd3-item" data-id="<?=$category['id']?>">
                     <div class="dd-handle dd3-handle handle "></div>
                     <div class="dd3-content clearfix">
                        <p style="float:left; margin:0 !important;">
                           <a href="/cp/<?=$method?>/<?=$category['id']?>">
                              <?php if ($category['view'] == 1): ?>
                                 <input checked onclick="buttonView(this, '<?=$db_table?>', '<?=$category['id']?>')" class="checkbox" name="view" type="checkbox"> 
                              <?php else: ?>
                                 <input onclick="buttonView(this, '<?=$db_table?>', '<?=$category['id']?>')" class="checkbox" name="view" type="checkbox">
                              <?php endif ?>   
                              <?=$category['name_'.var_data_lang]?>
                           </a>
                        </p>
                        <p style="float:right; margin:0 !important;"> 
                         
                           <a href="/cp/<?=$method?>/<?=$category['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>  
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
                                       <button class="btn btn-success" type="button" onclick="toDelete(this,'<?=base_url('cp/deleteElement/')?>','<?=$category['id']?>', '<?=$db_table?>')"><?=alert('delete')?></button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Modal --> 
                        </p>   
                     </div>
                     <?php if (isset($category['childs'])): ?>
                     <ol class="dd-list">
                        <?=catList($category['childs'], $method, $db_table) ?>
                     </ol>
                     <?php endif ?> 
                  </li>
               <?php endforeach ?>
            <?php } ?> 
            <?php catList($data, $method, $db_table); ?>
         </ol>
      </div> 
   </div>
</div> 
<?php endif ?> 
<?php else: ?>
<div class="row">
   <div class="col-md-12">
      <div class="portlet light bg-inverse">

         <div class="portlet-title" style="border-bottom:0px; margin-bottom:0!important;">
            <div class="caption">
               <span class="caption-subject font-red-sunglo bold uppercase"> </span> 
                
            </div>
            
            <div class="actions" id="change-content">
               <?php $i=0 ?>
               <?php foreach ($lang_arr as $key => $value): ?>
               <a class="btn btn-circle btn-icon-only btn-default <?=$i==0 ? 'active' : ''?> change-lang" data-lang="<?=$value?>" href="javascript:;">
               <span><?=$value?></span>
               </a>
               <?php $i++ ?>
               <?php endforeach ?> 
            </div>
         </div>

         <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="/cp/<?=$method?>/<?=$data['id']?>/" class="form-horizontal onsubmit" data-redirect="/cp/<?=$method?>/">
               <input type="hidden" class="form-control" name="id" value="<?=$data['id']?>">
               <div class="form-body"> 
                  <div class="tabbable-line">
                     <div class="tab-content" style="background-color:#f7f7f7;"> 
                        <div class="tab-pane active" id="tab_1_1"> 
                           <?=getInputLang(false, $data, 'Name', 'name', 'text', 'input', false, array('label_col' => 'col-md-1', 'field_col' => 'col-md-11'))?> 
                        </div> 
                     </div>
                  </div> 
               </div>

               <div class="form-actions">
                  <div class="row">
                     <div class="col-md-offset-1 col-md-4">
                        <button type="submit" class="btn green">Сохранить</button>  
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

<style>
  .filter-cheackbox{
   margin-left: 15px;
   padding:0;
  }

  .filter-cheackbox li{
   list-style: none;
  }
</style>
 