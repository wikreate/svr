 
<?php if (!empty($_SESSION['msg'])): ?>
   <div class="row">
      <div class="col-md-12">
         <?=$_SESSION['msg']?>
         <?php unset($_SESSION['msg'])?>
      </div>
   </div> 
<?php endif ?>
<a href="/cp/interview/add/?step=1">
   <div class="note note-success" style="cursor:pointer; background-color:#F5F5F5;">
       <i class="fa fa-plus"></i> <?=alert('add')?> 
   </div> 
</a> 
<div id="fade-respond" class="alert alert-danger"> </div> 
 
   <div class="row">
      <div class="col-md-12">
         <table class="table table-bordered table-striped" style="margin: 0; margin-top: -1px;">
            <thead>
               <tr class="heading"> 
                  <th style="width:60%;">Name</th> 
                  <th style="width:20%;">Date start/end</th>
                  <th>Status</th>
                  <th></th>
               </tr>
               
               <form action="/cp/interview/"> 
                  <tr role="row" class="filter"> 
                     <td> 
                        <input type="hidden" name="filter" value="search">
                     </td> 
                     <td>
                        <div class="input-group date date-picker margin-bottom-5" data-date-format="dd.mm.yyyy">
                           <input type="text" class="form-control form-filter input-sm" readonly value="<?=@$_GET['date_from']?>" name="date_from" placeholder="From">
                           <span class="input-group-btn">
                           <button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
                           </span>
                        </div>
                        <div class="input-group date date-picker" data-date-format="dd.mm.yyyy">
                           <input type="text" class="form-control form-filter input-sm" readonly value="<?=@$_GET['date_to']?>" name="date_to" placeholder="To">
                           <span class="input-group-btn">
                           <button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
                           </span>
                        </div>
                     </td>
                     <td>
                        <select name="status" class="form-control form-filter input-sm">
                           <option value="">Select...</option>
                           <?php foreach ($status as $item): ?>
                              <option <?=(!empty($_GET['status']) == $item['id']) ? 'selected' : ''?> value="<?=$item['id']?>"><?=$item['name']?></option>
                           <?php endforeach ?>
                        </select>
                     </td>
                     <td>
                        <div class="margin-bottom-5">
                           <button type='submit' class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i> Search</button>
                        </div>
                        <a href="/cp/interview/" class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset</a>
                     </td>
                  </tr>
               </form> 
            </thead>
            <?php if (!empty($data)): ?>
            <tbody id="sort-items" data-table="<?=$db_table?>">
               <?php foreach ($data as $item): ?>
                  <?php 
                     $acceptLangs = getInterviewLangArr($item['id']);
                     $def_lang    = getDefLang($acceptLangs);
                  ?>
                  <tr id="<?=$item['id']?>"> 

                     <td style="width:60%;"> 
                        <a href="/cp/<?=$method?>/edit/?step=1&iw_id=<?=$item['id']?>">
                        <?=@$item["name_{$def_lang}"]?></a>
                        <?php if ($item['activated'] == '0'): ?>
                           &nbsp; <span class="badge badge-danger f-right">Deactivated</span>
                        <?php elseif($item['activated'] == '1'): ?>
                           &nbsp; <span class="badge badge-success f-right">Activ</span>
                        <?php elseif($item['activated'] == null): ?>
                           &nbsp; <span class="badge badge-warning f-right">No complete</span>
                        <?php endif ?>
                     </td> 
                     <td style="width:20%;">
                        <?php if (!empty($item['date_start']) && !empty($item['date_end'])): ?>
                           <?=date('d.m.Y', $item['date_start'])?> - <?=date('d.m.Y', $item['date_end'])?>
                        <?php endif ?> 
                     </td>
                     <td>
                        <select name="status" class="form-control form-filter input-sm" onchange="changeStatus(this, '<?=$db_table?>', '<?=$item['id']?>', true)">
                           <option value="">Select...</option>
                           <?php foreach ($status as $value): ?>
                              <option <?=($item['status'] == $value['id']) ? 'selected' : ''?> value="<?=$value['id']?>"><?=$value['name']?></option>
                           <?php endforeach ?>
                        </select>
                     </td>
                     <td class="t-right">

                     <div class="btn-group open">
                        <button class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true" type="button">Actions <i class="fa fa-angle-down"></i></button> 
                         <ul class="dropdown-menu pull-right" role="menu">
                           <li>
                              <a href="/cp/<?=$method?>/edit/?step=1&iw_id=<?=$item['id']?>"><i class="fa fa-pencil"></i> Edit</a> 
                           </li>  
                           <li>
                              <a data-toggle="modal" href="#static<?=$item['id']?>"><i class="fa fa-trash-o "></i> Delete</a>
                           </li> 
                           <li>
                              <a data-toggle="modal" href="#copy<?=$item['id']?>"><i class="fa fa-files-o" aria-hidden="true"></i> Copy</a>
                           </li>
                           <?php if ($item['activated'] == '1'): ?>
                              <li>
                                 <a data-toggle="modal" href="#test_letter<?=$item['id']?>"><i class="fa fa-envelope-o" aria-hidden="true"></i> Test letter</a>
                              </li>
                           <?php endif ?> 
                           <li>
                              <?php if ($item['activated'] == '1'): ?>
                                 <a data-toggle="modal" href="#deactiv<?=$item['id']?>" onclick="$(this).closest('td.t-right').find('#change-content a:first').click();"><i class="fa fa-ban" aria-hidden="true"></i> Deactivated</a> 
                              <?php elseif($item['activated'] == '0'): ?> 
                                 <a data-toggle="modal" href="#activ<?=$item['id']?>"><i class="fa fa-check" aria-hidden="true"></i> Activate</a> 
                              <?php endif ?> 
                           </li>
                        </ul> 
                     </div> 
            
                        <!-- Delete -->
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
                                          <button type="button" data-dismiss="modal" onclick="toDelete(this, '<?=base_url('cp/deleteElement/')?>','<?=$item['id']?>', '<?=$db_table?>')" class="btn red"><?=alert('delete')?></button>
                                       </div> 
                                  </div>
                              </div>   
                           </div>
                        <!-- End Delete -->

                        <!-- Activ -->
                           <div id="activ<?=$item['id']?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false"> 
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                          <h4 class="modal-title"><?=alert('confirm_action')?></h4>
                                       </div>
                                       <div class="modal-body">
                                          <p>
                                             Are you sure to activate?
                                          </p>
                                       </div>
                                       <div class="modal-footer"> 
                                          <form action="/cp/activateInterview/" class="onsubmit" data-redirect="/cp/<?=$method?>/"> 
                                             <input type="hidden" value="<?=$item['id']?>" name="id">
                                             <button type="button" data-dismiss="modal" class="btn default"><?=alert('cancel')?></button>
                                             <button type="submit" class="btn red"><?=alert('yes')?></button>
                                          </form>
                                       </div> 
                                  </div>
                              </div>   
                           </div>
                        <!-- End Activ -->

                        <!-- Copy -->
                           <div id="copy<?=$item['id']?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false"> 
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                          <h4 class="modal-title"><?=alert('confirm_action')?></h4>
                                       </div>
                                       <div class="modal-body">
                                          <p>
                                             Are you sure to copy?
                                          </p>
                                       </div>
                                       <div class="modal-footer"> 
                                          <form action="/cp/copyInterview/" class="onsubmit" data-redirect="/cp/<?=$method?>/"> 
                                             <input type="hidden" value="<?=$item['id']?>" name="id">
                                             <button type="button" data-dismiss="modal" class="btn default"><?=alert('cancel')?></button>
                                             <button type="submit" class="btn red"><?=alert('yes')?></button>
                                          </form>
                                       </div> 
                                  </div>
                              </div>   
                           </div>
                        <!-- End Copy -->
            
                        <!-- Deactivated -->
                           <div id="deactiv<?=$item['id']?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                          <h4 class="modal-title">Complete area</h4>
                                       </div>
                                       <div class="modal-body"> 
                                          <div class="portlet light bg-inverse">
                                             <div class="portlet-title" style="border-bottom:0px; margin-bottom:0!important;">
                                                <div class="caption">
                                                   <span class="caption-subject font-red-sunglo bold uppercase"> </span>  
                                                </div>

                                                <div class="actions" id="change-content">
                                                   <?php $i=0 ?>
                                                   <?php foreach ($acceptLangs as $key => $value): ?>
                                                   <a class="btn btn-circle btn-icon-only btn-default <?=$i==0 ? 'active' : ''?> change-lang" data-lang="<?=$value?>" href="javascript:;">
                                                   <span><?=$value?></span>
                                                   </a>
                                                   <?php $i++ ?>
                                                   <?php endforeach ?> 
                                                </div>
                                             </div>

                                             <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
                                                <form action="/cp/deactivatedInterview/" class="onsubmit" data-redirect="/cp/<?=$method?>/"> 
                                                   <div class="form-body"> 
                                                      <div class="form-group">
                                                         <input type="hidden" value="<?=$item['id']?>" name="id">
                                                         <?php foreach ($acceptLangs as $l_key => $l_val): ?>
                                                            <div class="lang-area field_<?=$l_val?>">
                                                               <textarea name="deactivated_message_<?=$l_val?>" style="resize:none; min-height:150px;" class="form-control"></textarea>
                                                            </div>
                                                         <?php endforeach ?>
                                                          
                                                         <span class="help-block">* This message the user will see on survey page</span>
                                                      </div> 
                                                   </div>
                                                   <button class="btn blue" type="submit"><?=alert('save')?></button>
                                                </form>
                                                <!-- END FORM-->
                                             </div>
                                          </div>

                                       </div> 
                                  </div>
                              </div>  
                           </div>
                        <!-- End Deactivated -->

                         <!-- Test letter -->
                           <div id="test_letter<?=$item['id']?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                          <h4 class="modal-title">Complete area</h4>
                                       </div>
                                       <div class="modal-body"> 
                                          <form action="/cp/sendTestWelcomeLetter/" class="onsubmit" data-redirect="/cp/<?=$method?>/"> 
                                             <div class="form-body"> 
                                                <div class="form-group">
                                                   <input type="hidden" value="<?=$item['id']?>" name="id">
                                                   <input class="form-control" placeholder="Your E-mail" name="email">  
                                                </div> 
                                             </div>

                                             <div class="form-body"> 
                                                <div class="form-group">
                                                   <select name="lang" class="form-control">
                                                      <option value="">Select language...</option>
                                                      <?php foreach ($acceptLangs as $key => $value): ?>
                                                         <option value="<?=$value?>"><?=$value?></option>
                                                      <?php endforeach ?>
                                                   </select>
                                                </div> 
                                             </div> 
                                             <button class="btn blue" type="submit">Send</button>
                                          </form> 
                                       </div> 
                                  </div>
                              </div>  
                           </div>
                        <!-- End Test letter -->

                     </td>
                  </tr>
               <?php endforeach ?>
            </tbody>
            <?php endif ?>
         </table>
      </div>
   </div>
 


 