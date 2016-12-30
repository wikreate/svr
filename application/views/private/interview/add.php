<script>
   var notificationsStatus = JSON.parse('<?=json_encode($notification_status)?>');
   var langs               = JSON.parse('<?= !empty($langs) ? json_encode($langs) : ''?>');
   var startDateNotify     = '<?=!empty($interview["date_start"]) ? date("d.m.Y", $interview["date_start"]) : ''?>';
   var endDateNotify       = '<?=!empty($interview["date_end"]) ? date("d.m.Y", $interview["date_end"]) : ''?>'; 
</script> 

<div id="fade-respond" class="alert"></div>
<div class="row" id="survey">

   <?php if (checkBeginInterview($interview['id']) == true): ?>
      <div class="col-md-12">
         <div class="note note-warning"> 
            <p>The survey has already started</p>
         </div>
      </div> 
   <?php endif ?>
   
   <?php if ($current_step == '4' && empty($chapter)): ?>
      <div class="col-md-12">
         <div class="note note-warning"> 
            <p>For activate the survey, you must add at least one chapter!</p>
         </div>
      </div> 
   <?php elseif(!empty($interview) && $interview['activated'] == null): ?>
      <div class="col-md-12">
         <div class="note note-success">  
            <form action="/cp/activateInterview/" class="onsubmit" data-redirect="/cp/interview/"> 
               <p>This survey is ready to be activate! 
               <input type="hidden" value="<?=$interview['id']?>" name="id">
                &nbsp; <button type="submit" class="btn btn-xs green"><i class="fa fa-check" aria-hidden="true"></i> Activate!</button> </p>
            </form> 
         </div>
      </div> 
   <?php elseif(!empty($interview) && $interview['activated'] == '0'): ?>
      <div class="col-md-12">
         <div class="note note-danger">  
            <form action="/cp/activateInterview/" class="onsubmit" data-redirect="/cp/interview/"> 
               <p>This survey is deactivated! You can activate it again. 
               <input type="hidden" value="<?=$interview['id']?>" name="id">
                &nbsp; <button type="submit" class="btn btn-xs green"><i class="fa fa-check" aria-hidden="true"></i> Activate!</button> </p>
            </form> 
         </div>
      </div> 
   <?php endif ?>

   <div class="col-md-12">
      <div class="portlet box" style="background-color:#F7F7F7; border:1px solid #ededed;" id="form_wizard_1">
         <div class="portlet-title">
            <div class="caption"></div>
            <?php if (!empty($langs) && $current_step != '1'): ?>
            <div class="actions" id="change-content" style="padding-top:19px;">
               <?php $i=0 ?>
               <?php foreach ($lang_arr as $key => $value): ?>
               <?php if (array_key_exists($key, $langs)): ?>
               <a class="btn btn-circle btn-icon-only btn-default <?=$i==0 ? 'active' : ''?> change-lang" data-lang="<?=$value?>" href="javascript:;">
               <span><?=$value?></span>
               </a>
               <?php endif ?> 
               <?php $i++ ?>
               <?php endforeach ?> 
            </div>
            <?php endif ?>  
         </div>
         <div class="portlet-body form">
            <form action="/cp/interview/add" class="form-horizontal onsubmit form-bordered form-label-stripped" id="submit_form" method="POST">
               <input type="hidden" name="current_step" value="<?=$current_step?>">
               <input type="hidden" name="iw_id" value="<?=@$_GET['iw_id']?>">
               <div class="form-wizard">
                  <div class="form-body">
                     <ul class="nav nav-pills nav-justified steps">
                        <?php foreach ($steps as $key => $value): ?> 
                        <?php
                           $active = '';
                           $onclick = '';
                           if (!empty($value['access'])) {
                              $active  = 'active';
                              $url = '/cp/interview/add/'.$value['url']; 
                           }  else{
                              $active  = 'no-active';
                              $url     = 'javascript:;';
                           }
                           ?>
                        <li class="<?=$active?>">
                           <a href="<?=$url?>" <?=$onclick?> class="step">
                           <span class="number">
                           <?=$key?> </span>
                           <span class="desc">
                           <i class="fa fa-check"></i> <?=$value['name']?> </span>
                           </a>
                        </li>
                        <?php endforeach ?> 
                     </ul>
                     <div id="bar" class="progress progress-striped" role="progressbar">
                        <div class="progress-bar progress-bar-success" style="width:<?=(100/count($steps))*$current_step?>%;">
                        </div>
                     </div>
                     <div class="tab-content">
                        <?php if ($current_step == '1'): ?>
                        <div class="tab-pane active">
                           <div class="form-group">
                              <label class="control-label col-md-1">Languages</label>
                              <div class="col-md-11 locked">
                                 <select multiple="multiple" class="multi-select" id="multi_select" name="langs[]">
                                    <?php foreach ($this->lang->languages as $key => $value): ?>  
                                    <?php $selected = array_key_exists($key, $langs) ? 'selected' : ''; ?>
                                    <option <?=$selected?> value="<?=$key?>"><?=$value?></option>
                                    <?php endforeach ?> 
                                 </select>
                              </div>
                           </div>
                        </div>
                        <?php endif ?> 
                        <?php if ($current_step == '2'): ?>
                        <div class="tab-pane active locked"> 
                           <?=getInputLang($langs, $interview, 'Name <span class="req">*</span>', 'name', 'text', 'input')?> 
                           <?=getInputLang($langs, $interview, 'Description', 'description', 'text', 'textarea')?>
                           <div class="form-group last fileupload">
                              <label class="control-label col-md-1">Image</label>
                              <div class="col-md-11">
                                 <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
                                       <?php if ($interview['image']  && file_exists('public/image/interview/' .$interview['image'])): ?>
                                       <img src="<?=base_url('public/image/interview/' .$interview['image'])?>" id="thumb-img" alt="">
                                       <?php else: ?>
                                       <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                                       <?php endif ?>
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                    </div>
                                    <div>
                                       <span class="btn default btn-file">
                                       <span class="fileinput-new">
                                       Select </span>
                                       <span class="fileinput-exists">
                                       Edit </span>
                                       <input type="file" name="image">
                                       </span>
                                       <?php if ($interview['image']): ?>   
                                       <a data-toggle="modal" href="#myModal<?=$interview['id']?>" class="btn btn-danger del_btn" ><i class="fa fa-trash"></i> <?=alert('delete')?> </a>
                                       <!-- Modal -->
                                       <div class="modal fade theme-modal" id="myModal<?=$interview['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                   <button class="btn btn-success" type="button" onclick="toDeleteImg(this,'<?=base_url('cp/deleteImageElement/')?>','<?=$interview['id']?>', '<?=$db_table?>', '')"><?=alert('delete')?></button>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- Modal --> 
                                       <?php else: ?>
                                       <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> <?=alert('cancel')?> </a>
                                       <?php endif ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?=getInputLang($langs, $interview, 'Welcome text', 'welcome_text', 'text', 'textarea', 'ckeditor')?>
                           <div class="form-group">
                              <label class="control-label col-md-1">Date <span class="required">*</span></label>
                              <div class="col-md-11">
                                 <div class="input-group input-medium date date-picker" data-date-format="dd.mm.yyyy" data-date-viewmode="years">
                                    <input type="text" class="form-control" name="date_send_welcome" value="<?=!empty($interview['date_send_welcome']) ? date('d.m.Y', $interview['date_send_welcome']) : date('d.m.Y') ?>" readonly>
                                    <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                    </span>
                                 </div>
                                 <span class="help-block">* Select date when we send the Welcome message</span>
                              </div>
                           </div>
                           <?=getInputLang($langs, $interview, 'Info text', 'info_text', 'text', 'textarea', 'ckeditor')?>
                           <div class="form-group">
                              <label class="col-md-1 control-label">Start/End Date:<span class="required">*</span> 
                              </label>
                              <div class="col-md-11">
                                 <div class="input-group input-large date-picker input-daterange" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control" value="<?=!empty($interview['date_start']) ? date('d.m.Y', $interview['date_start']) : ''?>" name="date_start">
                                    <span class="input-group-addon">
                                    - </span>
                                    <input type="text" class="form-control" value="<?=!empty($interview['date_end']) ? date('d.m.Y', $interview['date_end']) : ''?>" name="date_end">
                                 </div>
                                 <span class="help-block">* In this field you must specify the date of commencement and date of completion of the survey</span>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="control-label col-md-1">Status: <span class="required">*</span>
                              </label>
                              <div class="col-md-4">
                                 <div class="radio-list">  
                                    <?php foreach ($interview_status as $item): ?> 
                                    <?php
                                       $checked = '';
                                       if ($interview['status'] == $item['id']) {
                                          $checked = 'checked';
                                       }else if(empty($interview['status']) && $item['id'] == 1) {
                                          /* По умолчанию */
                                          $checked = 'checked'; 
                                       } 
                                    ?>
                                    <label>
                                    <input <?=$checked?> type="radio" name="status" value="<?=$item['id']?>"/>
                                    <?=$item['name']?> 
                                    </label>  
                                    <?php endforeach ?>  
                                 </div>
                              </div> 
                           </div>
                           <div class="form-group">
                              <label class="col-md-1 control-label">Project:<span class="required">*</span>
                              </label>
                              <div class="col-md-11">
                                 <select class="form-control" name="id_project">
                                    <option value="">Select...</option>
                                    <?php   
                                       function projectsInCat($arr, $pre='', $interview, $def_lang, $langs ) {  
                                          foreach ($arr as $item) {  
                                                $disabled = '';
                                                if (!array_key_exists($item['id_lang'], $langs)) { 
                                                   $disabled = 'disabled';
                                                } 

                                                $selectedProject = ($interview['id_project'] == $item['id']) ? 'selected' : '';

                                                // $disabled = '';
                                                // if (AccessProject($item['id']) === false) {
                                                //    $value    = '';
                                                //    $disabled = 'disabled';
                                                // }else{
                                                //    $value = $item['id'];
                                                // }
                                                $value = $item['id'];
                                          
                                                echo '<option '.$selectedProject.' '.$disabled.' value="'.$value.'">'.$pre.$item["name_$def_lang"].'</option>';
                                                if (!empty($item['childs'])) {
                                                   $pre=$pre.'&mdash; ';
                                                   projectsInCat($item['childs'], $pre, $interview, $def_lang, $langs);
                                                }

                                                if ($item['parent_id'] == '0') {
                                                   $pre      = ''; 
                                                }
                                              
                                          }
                                       } 
                                       projectsInCat($projects, '', $interview, $def_lang, $langs ); 
                                    ?> 
                                 </select>
                                 * The list will be available to only those projects that comply with the selected language
                              </div>
                           </div>
                        </div>
                        <?php endif ?>  
                        <?php if ($current_step == '3'): ?>  
                        <div class="tab-pane active">
                           <div class="form-group">
                              <div class="col-md-12">
                                 <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10" onclick="addNotifications(this)" style="position:relative; display:inline-block; ">
                                    <a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn yellow"> 
                                    <i class="fa fa-plus"></i> <?=alert('add')?> </a> 
                                 </div>
                                 <table class="table table-bordered table-hover" style="<?=!empty($notifications) ? 'display:block;' : 'display:none;'?>" id="put-wrapper">
                                    <thead>
                                       <tr role="row" class="heading">
                                          <th width="60%">Text</th>
                                          <th width="8%">Date</th>
                                          <th width="17%">Status</th>
                                          <th width="5%"></th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php if (!empty($notifications)): ?>
                                       <?php $i1=0  ?>
                                       <?php foreach ($notifications as $item): ?> 
                                        
                                       <tr>
                                          <td>
                                             <?php foreach ($langs as $l_key => $l_val): ?> 
                                             <div class="lang-area field_<?=$l_val?>"> 
                                                <textarea style="height:100px;" class="form-control ckeditor" name="notify_text[<?=$l_val?>][<?=$i1?>]" class="form-control" id="dscp" rows="3"><?=$item['text_'.$l_val]?></textarea> 
                                             </div>
                                             <?php endforeach ?> 
                                          </td>
                                          <td>
                                             <div class="input-group input-medium date date-picker" data-date-format="dd.mm.yyyy" data-date-viewmode="years">
                                                <input type="text" class="form-control" name="notify_date[<?=$i1?>]" readonly value="<?=!empty($item['date']) ? date('d.m.Y', $item['date']) : date('d.m.Y') ?>">
                                                <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                             </div>
                                          </td>
                                          <td>
                                             <?php if (!empty($notification_status)): ?> 
                                             <select name="notify_status[<?=$i1?>]" id="" class="form-control">
                                                <?php foreach ($notification_status as $row): ?>
                                                <?php $selectStatus = ($item['status'] == $row['id']) ? 'selected' : '';  ?>
                                                <option <?=$selectStatus?> value="<?=$row['id']?>"><?=$row['name']?></option>
                                                <?php endforeach ?>
                                             </select>
                                             <?php endif ?>
                                          </td>
                                          <td>
                                             <a data-toggle="modal" href="#myModal<?=$item['id']?>" class="btn default btn-sm">
                                             <i class="fa fa-times"></i> <?=alert('delete')?> </a>
                                             <div class="modal fade theme-modal" id="myModal<?=$item['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                         <button class="btn btn-success" type="button" onclick="toDelete(this,'<?=base_url('cp/deleteElement/')?>', '<?=$item['id']?>', 'notification_system')"><?=alert('delete')?></button>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </td>
                                       </tr>
                                       <?php $i1++ ?>
                                       <?php endforeach ?> 
                                       <?php endif ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                        <?php endif ?>  
                        <?php if ($current_step == '4'): ?> 
                        <div class="tab-pane active locked">
                           <?=getInputLang($langs, false, 'Chapter Name <span class="req">*</span>', 'name', 'text', 'input')?>  
                        </div> 
                        <?php endif ?> 
                     </div>
                  </div>
                  <div class="form-actions">
                     <div class="row">
                        <div class="col-md-offset-1 col-md-9">
                           <?php if ($current_step != '1'): ?>
                           <a href="/cp/interview/add/<?=$steps[$current_step-1]['url']?>" class="btn default button-previous">
                           <i class="m-icon-swapleft"></i> 
                           Back 
                           </a>
                           <?php endif ?>  
                           <button type="submit" class="btn green">Next <i class="m-icon-swapright m-icon-white"></i></button> 
                           <?php if (!empty($steps[$current_step+1]['access']) && $current_step < count($steps) && !empty($interview['id'])): ?>
                            <!--   <a href="/cp/interview/add/?step=<?=$current_step+1?>&iw_id=<?=$interview['id']?>" class="btn blue button-next">Continue <i class="m-icon-swapright m-icon-white"></i></a> --> 
                           <?php endif ?> 
                        </div>
                     </div>
                  </div>
               </div>
            </form> 

            <?php if (!empty($chapter) && $current_step == '4'): ?>  
               <div style="padding:15px;" class="locked">
                     <h2>Chapters</h2>
                     <table class="table table-bordered table-striped" style="margin: 0; margin-top: -1px;"> 
                        <thead>
                           <tr>
                              <td></td>
                              <td><i class="fa fa-eye fa-center tooltips" data-placement="top" data-original-title="Показать/Скрыть" data-toggle="tooltip"></i></td> 
                              <td>Chapter name</td>
                              <td></td>
                           </tr>
                        </thead>
                        <tbody id="sort-items" data-table="chapter">
                           <?php foreach ($chapter as $item): ?>
                              <tr id="<?=$item['id']?>">
                                 <td style="width:50px; text-align:center;" class="handle"> </td> 

                                 <td class="t-border" style="width:30px;"> 
                                    <?php if ($item['view'] == 1): ?>
                                    <input checked onclick="buttonView(this, 'chapter', '<?=$item['id']?>', 'view')" class="checkbox" type="checkbox"> 
                                    <?php else: ?>
                                    <input onclick="buttonView(this, 'chapter', '<?=$item['id']?>', 'view')" class="checkbox" type="checkbox">
                                    <?php endif ?>  
                                 </td>  
                                 <td style="width:47%;">
                                    <a style="display:block;" href="/cp/edit-chapter/<?=$item['id']?>/<?=$interview['id']?>"><?=$item['name_'.$def_lang]?></a> 
                                    <?php 
                                       $sql = $this->db->where('id_chapter', $item['id'])
                                                       ->where('delete', '0')
                                                       ->order_by('page_up', 'asc')
                                                       ->order_by('id', 'desc')
                                                       ->get('chapter_question')
                                                       ->result_array();

                                       $getQuestion = getTranslateArray($sql, array('question'), 'chapter_question_lang', true, $langs); 
                                     ?>
                                    <?php if (!empty($getQuestion)): ?>
                                       <ul class="sub_item">
                                          <?php foreach ($getQuestion as $value): ?>
                                             <li>
                                                <input onchange="setPageUp(this)" data-id="<?=$value['id']?>" data-table="chapter_question" value="<?=$value['page_up']?>" class="handle-input" type="text"> 
                                                <a href="/cp/question/<?=$item['id']?>/<?=$value['id']?>/?iw_id=<?=$interview['id']?>" target="_blank"><?=$value["question_{$def_lang}"]?> &nbsp; <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                             </li>
                                          <?php endforeach ?> 
                                       </ul> 
                                    <?php endif ?>   
                                 </td>  
                                 <td class="t-right">
                                    <a href="/cp/question/<?=$item['id']?>/?iw_id=<?=$interview['id']?>" target="_blank" class="btn btn-sm blue">Add Question <i class="fa fa-external-link" aria-hidden="true"></i></a>
                                    <a href="/cp/edit-chapter/<?=$item['id']?>/<?=$interview['id']?>" class="btn btn-sm yellow">Edit chapter <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a data-toggle="modal" href="#myModal<?=$item['id']?>" class="btn default btn-sm">
                                    <i class="fa fa-times"></i> <?=alert('delete')?> </a> 
                                    <div class="modal fade theme-modal" id="myModal<?=$item['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                <button class="btn btn-success" type="button" onclick="toDelete(this,'<?=base_url('cp/deleteElement/')?>','<?=$item['id']?>', 'chapter')"><?=alert('delete')?></button>
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
               <?php endif ?> 

         </div>
      </div>
   </div>
</div>
<style>
   .portlet > .portlet-title > .actions .btn-icon-only.change-lang{
      padding: 4px 6px 2px 6px;
   }

   .radio-list > label{
      display: block;
   }

   .sub_item{
      margin: 5px 0 0px 0px;
   }

   .add_q{ 
      margin-top: 10px !important;
   }

   .sub_item li{
      list-style: none;
      padding: 5px 0;
   }
</style>