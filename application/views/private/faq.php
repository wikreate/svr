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
                  <?=getInputLang(false, false, 'Title', 'name', 'text', 'input')?>

                  <div class="form-group">
                     <label class="col-md-1 control-label">Category:<span class="required">*</span>
                     </label>
                     <div class="col-md-11">
                        <select class="form-control" name="id_category">
                           <option value="">Select...</option>
                           <?php  

                              function catList($categories, $pre='') {  
                                 foreach ($categories as $item) { 
                                    echo '<option value="'.$item['id'].'">'.$pre.$item['name_'.var_data_lang].'</option>';
                                    if (!empty($item['childs'])) {
                                       $pre=$pre.'&mdash; ';
                                       catList($item['childs'], $pre);
                                    }

                                    if ($item['parent_id'] == '0') {
                                       $pre = '';
                                    }

                                 }
                              } 
                              catList($categories, ''); 
                              
                           ?> 
                        </select>
                     </div>
                  </div>    

                  <?=getInputLang(false, false, 'Description', 'description', 'text', 'textarea')?>     

                  <?=getInputLang(false, false, 'Text', 'text', 'text', 'textarea', 'ckeditor')?>       
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
               <?php $cName='zzz'; ?>
               <?php foreach ($data as $item): ?>
                  <?php if ($cName !== $item['cat_name']): ?>
                     <?php $cName = $item['cat_name']; if ($cName!=='zzz') echo '</table>'; ?>
                     <h2><?=$item['cat_name']?></h2> 
                     <table class="table table-striped table-advance table-hover table-bordered" style="margin: 0; margin-top: -1px;">
                        <thead>
                           <tr>
                              <td></td>
                              <td><i class="fa fa-eye fa-center tooltips" data-placement="top" data-original-title="View" data-toggle="tooltip"></i></td> 
                              <td>Title</td> 
                              <td></td>
                           </tr>
                        </thead>
                        <tbody id="sort-items" data-table="<?=$db_table?>">  
                  <?php endif ?>
                  <tr id="<?=$item['id']?>">
                     <td style="width:5%; text-align:center;" class="handle"> </td>
                     <td class="t-border" style="width:2%;"> 
                        <?php if ($item['view'] == 1): ?>
                        <input checked onclick="buttonView(this, '<?=$db_table?>', '<?=$item['id']?>')" class="checkbox" name="view" type="checkbox"> 
                        <?php else: ?>
                        <input onclick="buttonView(this, '<?=$db_table?>', '<?=$item['id']?>')" class="checkbox" name="view" type="checkbox">
                        <?php endif ?>  
                     </td> 

                     <td style="width:80%;"><a href="/cp/<?=$method?>/<?=$item['id']?>"><?=$item['name_'.var_data_lang]?></a></td> 

                     <td style="width:7%;" class="t-right">
                        <a href="/cp/<?=$method?>/<?=$item['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a> 
                         
                        <a class="btn btn-danger btn-xs" data-toggle="modal" href="#static<?=$item['id']?>"><i class="fa fa-trash-o "></i></a>  

                        <div id="static<?=$item['id']?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                           <div class="modal-dialog">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Confirm the action</h4>
                                 </div>
                                 <div class="modal-body">
                                    <p>
                                       Are you sure you want to delete?
                                    </p>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                                    <button type="button" data-dismiss="modal" onclick="toDelete(this, '<?=base_url('cp/deleteElement/')?>','<?=$item['id']?>', '<?=$db_table?>')" class="btn red">Delete</button>
                                 </div>
                              </div>
                           </div>
                        </div> 
                     </td>
                  </tr>
               <?php endforeach ?>
            </tbody>
         </table>
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
                           <?=getInputLang(false, $data, 'Title', 'name', 'text', 'input', false, array('label_col' => 'col-md-1', 'field_col' => 'col-md-11'))?>

                           <div class="form-group">
                              <label class="col-md-1 control-label">Category:<span class="required">*</span>
                              </label>
                              <div class="col-md-11">
                                 <select class="form-control" name="id_category">
                                    <option value="">Select...</option>
                                    <?php  
                                   
                                       function catList($categories, $pre = '', $data) {  
                                          foreach ($categories as $item) {
                                        
                                             $selectedProject = ($data['id_category'] == $item['id']) ? 'selected' : '';
                                       
                                             echo '<option '.$selectedProject.' value="'.$item['id'].'">'.$pre.$item['name_'.var_data_lang].'</option>';
                                             if (!empty($item['childs'])) {
                                                $pre=$pre.'&mdash; ';
                                                catList($item['childs'], $pre, $data);
                                             }

                                             if ($item['parent_id'] == '0') {
                                                $pre = '';
                                             }

                                          }
                                       } 
                                       catList($categories, '', $data); 
                                       
                                    ?> 
                                 </select>
                              </div>
                           </div> 

                           <?=getInputLang(false, $data, 'Description', 'description', 'text', 'textarea')?>     

                           <?=getInputLang(false, $data, 'Text', 'text', 'text', 'textarea', 'ckeditor')?>   
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
 