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
            <form action="/cp/<?=$method?>/" class="form-horizontal onsubmit" data-redirect="/cp/<?=$method?>/">
               <div class="form-body"> 
                  <?=getInput(false, 'Name', 'name', 'text', 'input')?>      
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
         <table class="table table-striped table-advance table-hover" style="margin: 0; margin-top: -1px;">
            <thead>
               <tr>
                  <td></td> 
                  <td><i class="fa fa-eye" aria-hidden="true"></i></td>
                  <td>Название</td>
                  <td></td>
               </tr>
            </thead>
            <tbody id="sort-items" data-table="<?=$db_table?>">
               <?php foreach ($data as $item): ?>
                  <tr id="<?=$item['id']?>">
                     <td style="width:50px; text-align:center;" class="handle"> </td> 

                     <td class="t-border" style="width:30px;"> 
                        <?php if ($item['view'] == 1): ?>
                        <input checked onclick="buttonView(this, '<?=$db_table?>', '<?=$item['id']?>', 'view')" class="checkbox" type="checkbox"> 
                        <?php else: ?>
                        <input onclick="buttonView(this, '<?=$db_table?>', '<?=$item['id']?>', 'view')" class="checkbox" type="checkbox">
                        <?php endif ?>  
                     </td> 

                     <td><a href="/cp/<?=$method?>/<?=$item['id']?>"><?=$item['name']?></a></td>
                     <td class="t-right">
                        <a href="/cp/<?=$method?>/<?=$item['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a> 
                       
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
   </div>
<?php endif ?>
<?php else: ?>
<div class="row">
   <div class="col-md-12">
      <div class="portlet light bg-inverse"> 

         <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="/cp/<?=$method?>/<?=$data['id']?>/" class="form-horizontal onsubmit" data-redirect="/cp/<?=$method?>/">
               <input type="hidden" class="form-control" name="id" value="<?=$data['id']?>">
               <div class="form-body"> 
                  <div class="tabbable-line">
                     <div class="tab-content" style="background-color:#f7f7f7;"> 
                        <div class="tab-pane active" id="tab_1_1"> 
                           <?=getInput($data, 'Name', 'name', 'text', 'input')?> 
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
 