
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
          
            <div class="portlet-body form">
               <!-- BEGIN FORM-->
               <form action="/cp/<?=$method?>/?pr_id=<?=$project['id']?>" class="form-horizontal onsubmit" data-redirect="/cp/<?=$method?>/?pr_id=<?=$project['id']?>">
                  <div class="form-body">  
                     <input type="hidden" name="id_project" value="<?=$project['id']?>">
                     <div class="form-group">
                        <label class="col-md-1 control-label">Emails</label>
                        <div class="col-md-11">
                           <textarea name="emails" style="min-height:250px;" class="form-control"></textarea>
                           <span class="help-block">
                              <span class="label label-danger label-sm">Attention:</span> Allowed types <code>xls, xlsx, csv</code>
                           </span> 
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-1 control-label"></label>
                        <div class="col-md-11">
                           <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10" style="position:relative; display:inline-block; ">
                              <a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn yellow">
                                 <input type="file" id="xls-preview" name="file_emails" class="default" style="position:absolute; top:0; right:0; width:100%; height:100%; direction:ltr; opacity:0;">
                              <i class="fa fa-plus"></i> Browse </a> 
                           </div>

                           <button type="button" class="btn btn-info start-load"><i class="fa fa-upload"></i> <?=alert('upload')?></button>
                        </div>
                     </div> 

                     <div class="form-group existing_emails" style="display:none;">
                        <label class="col-md-1 control-label"></label>
                        <div class="col-md-11">
                           <div class="note note-danger">
                              <h4>Exists emails</h4>
                              <p> <!-- Content load here --> </p>
                           </div>
                        </div>
                     </div> 
                  </div>
                  <div class="form-actions">
                     <div class="row">
                        <div class="col-md-offset-1 col-md-4">
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
   <?php  

      $countData = round(count($data)/3);  
      if ($countData < 1) {
         $countData = 1;
      }
      $data = array_chunk($data, $countData); 
   ?>
   <div class="row">
      <?php foreach ($data as $key => $value): ?>
         
         <div class="col-md-3">
            <table class="table table-striped table-advance table-hover" style="margin: 0; margin-top: -1px;">
               <thead>
                  <tr> 
                     <td><i class="fa fa-eye" aria-hidden="true"></i></td>
                     <td>Email</td>
                     <td></td>
                  </tr>
               </thead>
               <tbody> 
                  <?php foreach ($value as $item): ?> 
                     <tr>  
                        <td class="t-border" style="width:30px;"> 
                           <?php if ($item['view'] == 1): ?>
                           <input checked onclick="buttonView(this, '<?=$db_table?>', '<?=$item['id']?>', 'view')" class="checkbox" type="checkbox"> 
                           <?php else: ?>
                           <input onclick="buttonView(this, '<?=$db_table?>', '<?=$item['id']?>', 'view')" class="checkbox" type="checkbox">
                           <?php endif ?>  
                        </td>  
                        <td><a href="/cp/<?=$method?>/<?=$item['id']?>/?pr_id=<?=$project['id']?>"><?=$item['email']?></a></td>
                        <td class="t-right">
                           <a href="/cp/<?=$method?>/<?=$item['id']?>/?pr_id=<?=$project['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a> 
                            
                           <a class="btn btn-danger btn-xs" data-toggle="modal" href="#static<?=$item['id']?>"><i class="fa fa-trash-o "></i></a>  

                           <div id="static<?=$item['id']?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                          <h4 class="modal-title">Подтвердить операцию</h4>
                                       </div>
                                       <div class="modal-body">
                                          <p>
                                             Вы действительно желаете удалить?
                                          </p>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" data-dismiss="modal" class="btn default">Отмена</button>
                                          <button type="button" data-dismiss="modal" onclick="toDelete(this, '<?=base_url('cp/deleteElement/')?>','<?=$item['id']?>', '<?=$db_table?>')" class="btn red">Удалить</button>
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
      <?php endforeach ?>
       
   </div>
<?php endif ?>


<?php else: ?> 
<div class="row">
   <div class="col-md-12">
      <div class="portlet light bg-inverse">
             
            <div class="portlet-body form">
               <!-- BEGIN FORM-->
               <form action="/cp/<?=$method?>/<?=$data['id']?>/?pr_id=<?=$project['id']?>" class="form-horizontal onsubmit" data-redirect="/cp/<?=$method?>/?pr_id=<?=$project['id']?>">
                  <div class="form-body">  
                     <input type="hidden" class="form-control" name="id" value="<?=$data['id']?>"> 
                     <div class="form-group">
                        <label class="col-sm-1 control-label">Email </label>
                        <div class="col-sm-11">
                           <input type="text" class="form-control" name="email" value="<?=decrypt($data['email'])?>">  
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