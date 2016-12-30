<div class="profile-content">
   <div class="row">
      <div class="col-md-12"> 

        <div class="note note-success" id="add_post" style="cursor:pointer; background-color:#F5F5F5;">
          <i class="fa fa-plus"></i> <?=alert('add')?>
        </div> 
              
         <div class="taggle_win">  
            <!-- CHANGE PASSWORD TAB --> 
               <form action="/cp/addRole/" class="onsubmit" data-redirect="/cp/settings/?p=privilege">
                  <div class="form-group">
                     <label class="control-label">Role</label>
                     <input type="text" class="form-control" name="role" value=""/>
                  </div> 
                  <div class="margin-top-10">
                     <button type="submit" class="btn green">Save</button> 
                  </div>
               </form> 
            <!-- END CHANGE PASSWORD TAB --> 
         </div> 
      </div>
   </div>

   <?php if (!empty($role)): ?>
      <form action="/cp/editRole/" class="onsubmit table_onsubmit" method="POST"> 
         <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-advance table-hover" style="margin: 0; margin-top: -1px;">
                  <thead>
                     <tr>
                        <td></td>  
                        <td>Role</td>
                        <td></td>
                     </tr>
                  </thead>
                  <tbody id="sort-items" data-table="role">
                     <?php foreach ($role as $item): ?>
                        <tr id="<?=$item['id']?>">
                           <td style="width:50px; text-align:center;" class="handle"> </td>  
                           <td class="get"><?=$item['name']?></td>
                           <td class="t-right">
                              <button onclick="transformInInput(this); return false;" data-id="<?=$item['id']?>" class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                              </button>  
                              <a class="btn btn-danger btn-xs" data-toggle="modal" href="#static<?=$item['id']?>"><i class="fa fa-trash-o "></i></a>   
                              <div id="static<?=$item['id']?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                          <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                             <h4 class="modal-title"><?=alert('confirm_action')?></h4>
                                          </div>
                                          <div class="modal-body">
                                             <p>
                                                <?=alert('confirm_question')?>
                                             </p>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" data-dismiss="modal" class="btn default"><?=alert('cancel')?></button>
                                             <button type="button" data-dismiss="modal" onclick="toDelete(this, '<?=base_url('cp/deleteElement/')?>','<?=$item['id']?>', 'role')" class="btn red"><?=alert('delete')?></button>
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
      </form>
   <?php endif ?>
 
<!--     <form action="/cp/editPriveleges/" id="priv_usr">  
      <div class="row">
        <div class="col-md-12">
           <div class="portlet light">
           <div class="portlet-title tabbable-line">
              <div class="caption caption-md">
                 <i class="icon-globe theme-font hide"></i>
                 <span class="caption-subject font-blue-madison bold uppercase">Privilege</span>
              </div> 
           </div>
           <div class="portlet-body">
              <div class="tab-content">  
               <table  class="table table-striped table-advance table-hover table-bordered">
                  <thead>
                    <tr>
                      <td></td>
                      <?php foreach ($role as $item): ?>
                        <td><?=$item['name']?></td>   
                      <?php endforeach ?>   
                    </tr>
                  </thead>  
                  <tbody> 
                    <?php if (!empty($role) && !empty($privilege)): ?>
                      <?php foreach ($privilege as $key => $value): ?>
                        <tr>
                          <td style="width:20%;"><?=$key?></td>
                          <?php foreach ($role as $item): ?>
                            <?php 
                              $checked = array_key_exists($item['id'], $value) ? 'checked' : '';
                             ?>
                            <td><input <?=$checked?> type="checkbox" onclick="submitPriv()" name="<?=$item['id']?>[]" value="<?=$value['id_privilege']?>"></td>
                          <?php endforeach ?>
                        </tr>
                      <?php endforeach ?>
                    <?php endif ?> 
                  </tbody>
                </table>
              </div>
           </div>
        </div>  
        </div>
     </div> 
    </form>   -->
</div>

<script>  
    function submitPriv(){
      $('#priv_usr').submit(); 
    }
       
    $('form#priv_usr').on('submit', function(e){
      e.preventDefault();
      var form = $(this); 
      $.ajax({
        type:'POST', 
        url: '/cp/editPriveleges/', 
        async: true,
        data: new FormData(form[0]),
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        success: function(res, textStatus, request) {}
      }); 
    });

   function changeType(item){
      var val = $(item).val();
      var id = $(item).attr('data-id'); 
      $.ajax({
        type:'POST', 
        url: '/cp/changeUsrType/', 
        async: true,
        data: {'type': val, 'id': id}
      }); 
   }

    function transformInInput(item){
      var text = $(item).closest('tr').find('.get').text();
      var id = $(item).attr('data-id');
      $(item).closest('tr').find('.get').html("<input class='form-control' autocomplete='false' name='role["+id+"]' value='"+text+"'>");
      $(item).html('<i class="fa fa-floppy-o" aria-hidden="true"></i>');
      $(item).attr('type', 'submit');
      $(item).attr('onclick', '');
    }
  </script>