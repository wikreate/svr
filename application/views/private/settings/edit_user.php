<div class="row">
   <div class="col-md-12">
      <div class="portlet light bg-inverse">
              
            <div class="portlet-body form">
               <!-- BEGIN FORM-->
               <form action="/cp/<?=$method?>/<?=$data['id']?>/" class="onsubmit form-horizontal form-bordered" data-redirect="/cp/settings?p=users">
                  <div class="form-body">  
                     <input type="hidden" class="form-control" name="id" value="<?=$data['id']?>">
                      
                       <div class="form-group">  
                           <label class="control-label col-md-1">Login</label>
                           <div class="col-md-11">
                              <input type="text" class="form-control" name="login" value="<?=$data['login']?>"/>
                           </div>  
                        </div>  
                         
                          <div class="form-group">
                             <label class="control-label col-md-1">Role: <span class="required">*</span> </label>
                             <div class="col-md-11"> 
                             <div class="radio-list">  
                                <?php foreach ($role as $item): ?>  
                                  <?php 
                                    $check = $item['id'] == $data['id_role'] ? 'checked' : '';
                                  ?>
                                    <?php if ($item['id'] == '2' && Can(array('ADD_ADMIN')) === false): ?> 
                                       <!-- <input type="hidden" name="id_role" class="open_attr_block" data-href="#role_<?=$item['id']?>" value="<?=$item['id']?>"/> -->
                                    <?php elseif($item['id'] == '1' && getAdminUser('id_role') != '1'): ?>

                                    <?php else: ?>
                                    <label style="display: block !important;">
                                    <input <?=$check?> type="radio" name="id_role" class="open_attr_block" data-href="#role_<?=$item['id']?>" value="<?=$item['id']?>"/>
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
                                 <label class="control-label col-md-1">Projects</label>
                                 <div class="col-md-11"> 
                                    <?php 
                                       $getUserProjects = $this->db->where('delete', '0')->where('id_user', $data['id'])->get('user_projects')->result_array();

                                       $getUserProjects = array_map(function($v){
                                          return $v['id_project'];
                                       }, $getUserProjects);

                                        function initProjects($projects, $getUserProjects, $parent = 0) {  
                                          foreach ($projects as $item) 
                                          { 
                                            $lockClass = '';
                                            $lockIcon  = '';
                                            if (AccessProject($item['id']) === false) { 
                                              $lockClass = 'lock-project';
                                              $lockIcon  = '<i class="fa fa-lock" aria-hidden="true"></i>';
                                            } 

                                            if ($item['parent_id'] == '0') {
                                              $parent = $item['id'];
                                            }else{
                                              $parent = ($parent == 0) ? $item['id'] : $parent;
                                            }

                                            $checked = in_array($item['id'], $getUserProjects) ? 'checked' : '';
                                            echo "<div class='parent_$parent'> <div class='child_checkbox $lockClass' style='display:block;'><input onclick='setCheckchild(this)' id='p_id' data-val='{$item['id']}' data-parent='$parent' name='projects[{$item['id']}]' ".$checked." type='checkbox'> $lockIcon ".$item['name_'.var_data_lang]."</div>"; 

                                            if (!empty($item['childs'])) 
                                            { 
                                              echo "<div id='child_".$item['id']."' class='section_checkbox'>";
                                                 initProjects($item['childs'], $getUserProjects, $parent);
                                              echo "</div>";
                                            } 
                                            echo "</div>";
                                          }
                                        } 
                                       initProjects($projects, $getUserProjects);
                                    ?> 
                                    </div>  </div> 
                              </div>  
                           <?php endif ?> 

                        <div class="form-group">
                           <label class="control-label col-md-1">Privilege</label>
                           <div class="col-md-11"> 
                              <table  class="table table-striped table-advance table-hover table-bordered"> 
                                 <tbody> 
                                   <?php if (!empty($privilege)): ?>
                                    <?php 

                                       $getUserPrivilege = $this->db->where('id_user', $data['id'])->get('user_privileges')->result_array();

                                       $getUserPrivilege = array_map(function($v){
                                          return $v['id_privilege'];
                                       }, $getUserPrivilege);

                                     ?>
                                     <?php foreach ($privilege as $key => $value): ?>
                                       <?php 
                                          $checked = in_array($value['id_privilege'], $getUserPrivilege) ? 'checked' : '';
                                        ?>
                                       <tr>
                                         <td style="width:50%;"><?=$key?></td>
                                         <td><input <?=$checked?> type="checkbox"  
                                         name="privilege[<?=$value['id_privilege']?>]"></td>
                                       </tr>
                                     <?php endforeach ?>
                                   <?php endif ?> 
                                 </tbody>
                              </table>
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