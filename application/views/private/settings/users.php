<div class="profile-content">
   <div class="row">
      <div class="col-md-12">  
               <div class="note note-success" id="add_post" style="cursor:pointer; background-color:#F5F5F5;">
                  <i class="fa fa-plus"></i> <?=alert('add')?>
               </div>

               <div class="taggle_win">  
                  <!-- CHANGE PASSWORD TAB --> 
                   <div class="portlet light bg-inverse user-form"> 
                     <div class="portlet-body form">
                     <form action="/cp/addNewUser/" class="onsubmit form-horizontal form-bordered" data-redirect="/cp/settings/?p=users">

                        <div class="form-group">
                           <label class="control-label col-md-1">Login <span class="required">*</span></label>
                           <div class="col-md-11">
                              <input type="text" class="form-control" name="login" value=""/>
                           </div> 
                        </div> 
                         
                           <div class="form-group">
                              <label class="control-label col-md-1">Role: <span class="required">*</span> </label> 
                              <div class="col-md-11"> 
                              <div class="radio-list">   
                                 <?php foreach ($role as $item): ?>  
                                    <?php if ($item['id'] == '2' && Can(array('ADD_ADMIN')) === false): ?> 
                                       <!-- <input type="hidden" name="id_role" class="open_attr_block" data-href="#role_<?=$item['id']?>" value="<?=$item['id']?>"/> -->
                                    <?php elseif($item['id'] == '1' && getAdminUser('id_role') != '1'): ?>

                                    <?php else: ?>
                                    <label style="display: block !important;">
                                    <input type="radio" name="id_role" class="open_attr_block" data-href="#role_<?=$item['id']?>" value="<?=$item['id']?>"/>
                                       <?=$item['name']?> 
                                     </label> 
                                   <?php endif ?> 
                                 <?php endforeach ?>  
                              </div>  
                              </div> 
                           </div>  

                            <?php if (!empty($projects)): ?>
                              <div id="role_2">
                                 <div class="form-group">
                                 <label class="control-label col-md-1">Projects <span class="required">*</span></label>
                                 <div class="col-md-11"> 
                                    <?php 
                                       function initProjects($projects, $parent = 0)
                                       {  
                                          foreach ($projects as $item) 
                                          {

                                             if ($item['parent_id'] == '0') {
                                                $parent = $item['id'];
                                             }else{
                                                $parent = ($parent == 0) ? $item['id'] : $parent;
                                             }
                                               
                                             $lockClass = '';
                                             $lockIcon  = '';
                                             if (AccessProject($item['id']) == false) { 
                                                $lockClass = 'lock-project';
                                                $lockIcon  = '<i class="fa fa-lock" aria-hidden="true"></i>';
                                             } 

                                             echo "<div class='parent_$parent'>
                                                   <div class='child_checkbox $lockClass' style='display:block;'><input onclick='setCheckchild(this)' id='p_id' data-val='{$item['id']}' name='projects[{$item['id']}]' data-parent='$parent' type='checkbox'> $lockIcon ".$item['name_'.var_data_lang]."</div>";

                                             if (!empty($item['childs'])) 
                                             {  
                                                echo "<div id='child_".$item['id']."' class='section_checkbox'>";
                                                   initProjects($item['childs'], $parent);
                                                echo "</div>";
                                             } 
                                             echo "</div>";
                                          }
                                       } 
                                       initProjects($projects);
                                    ?>
                                 </div>
                                 </div>
                              </div>  
                           <?php endif ?> 

                        <div class="form-group"> 
                           <label class="control-label col-md-1">Privilege<span class="required">*</span></label> 
                           <div class="col-md-11"> 
                              <table  class="table table-striped table-advance table-hover table-bordered"> 
                                 <tbody> 
                                   <?php if (!empty($privilege)): ?>
                                     <?php foreach ($privilege as $key => $value): ?>
                                       <tr>
                                         <td style="width:50%;"><?=$key?></td>
                                         <td><input type="checkbox"  
                                         name="privilege[<?=$value['id_privilege']?>]"></td>
                                       </tr>
                                     <?php endforeach ?>
                                   <?php endif ?> 
                                 </tbody>
                              </table>
                           </div>
                        </div> 
 
                        <div class="form-group">
                           <label class="control-label col-md-1">New Password<span class="req">*</span></label>

                           <div class="col-md-11"> 
                              <input type="password" class="form-control new_password" name="password" data-size="6" data-character-set="a-z,A-Z,#,0-9"/>
                              <br>
                              <button type="button" id="generate_new_password" class="btn btn-circle btn-danger btn-sm">Generate password</button>
                              <button type="button" id="view_password" style="display:none;" class="btn btn-circle btn-info btn-sm"><i class="fa fa-eye"></i> <span>Show</span></button>
                              <button type="button" id="copy" style="display:none;" class="btn btn-circle btn-success btn-sm"><i class="fa fa-files-o" aria-hidden="true"></i> <span>Copy</span></button>
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-1">Re-type Password<span class="req">*</span></label>

                           <div class="col-md-11"> 
                              <input type="password" class="form-control repeat_password" name="repeat_password"/>
                           </div>
                        </div>

                        <div class="margin-top-10">
                           <button type="submit" class="btn green">Save</button> 
                        </div>
                      
                     </form> <br><br>
                     </div>
                     </div>
                  <!-- END CHANGE PASSWORD TAB --> 
               </div>
            
      </div>
   </div>
 
      <?php if (!empty($users)): ?> 
         <div class="row">
            <div class="col-md-12">
                
                     <?php $role_name='zzz'; ?>
                     <?php foreach ($users as $item): ?>
                        <?php if ($item['id'] != getAdminUser('id')): ?> 
                           <?php if ($item['role_name'] !== $role_name): ?> 
                              <?php $role_name = $item['role_name']; if ($role_name!=='zzz') echo '</table>'; ?>
                              <h2><?=$role_name?></h2>
                              <table  class="table table-striped table-advance table-hover table-bordered" style="margin: 0; margin-top: -1px;">  
                           <?php endif ?>
                           <tr> 
                              <td class="t-border" style="width:30px;">
                              <?php if (Can(array('DEACTIVATE_ADMIN')) === false && $item['id_role'] == '2'): ?>
                              <?php else: ?>
                                 <?php if ($item['active'] == 1): ?>
                                    <input checked onclick="buttonView(this, 'admin_users', '<?=$item['id']?>', 'active')" class="checkbox" type="checkbox"> 
                                 <?php else: ?>
                                    <input onclick="buttonView(this, 'admin_users', '<?=$item['id']?>', 'active')" class="checkbox" type="checkbox">
                                 <?php endif ?>
                              <?php endif ?>  
                              </td>
                              <td style="width:15%;"><a href="/cp/edit-user/<?=$item['id']?>"><?=$item['login']?></a></td>
                          <!--     <td>
                                 <select  onchange="changeType(this)" data-id="<?=$item['id']?>">
                                    <?php foreach ($role as $value): ?>
                                       <?php 
                                          $selected =  ($value['id'] == $item['id_role']) ? 'selected'  : '';   
                                       ?>
                                    <option <?=$selected?> value="<?=$value['id']?>"><?=$value['name']?></option>
                                    <?php endforeach ?> 
                                  </select>
                              </td> -->
                              <td class="t-right">   
                                 <?php if (Can(array('EDIT_ADMIN')) === false && $item['id_role'] == '2'): ?>
                                 <?php else: ?>
                                    <a href="/cp/edit-user/<?=$item['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a> 
                                 <?php endif ?>  

                                 <?php if (Can(array('TRASH_ADMIN')) === false && $item['id_role'] == '2'): ?>
                                 <?php else: ?>
                                    <a class="btn btn-danger btn-xs" data-toggle="modal" href="#static<?=$item['id']?>"><i class="fa fa-trash-o "></i></a>   
                                 <?php endif ?> 

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
                                                <button type="button" data-dismiss="modal" onclick="toDelete(this, '<?=base_url('cp/deleteElement/')?>','<?=$item['id']?>', 'admin_users')" class="btn red"><?=alert('delete')?></button>
                                             </div> 
                                        </div>
                                    </div>  
                                 </div> 
                              </td>
                           </tr>
                        <?php endif ?>
                     <?php endforeach ?> 
               </table> 
            </div>
         </div> 
   <?php endif ?> 
</div>
 