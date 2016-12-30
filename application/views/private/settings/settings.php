<div class="profile-content">
    
    <?php if (!empty($settings)): ?> 
         <div class="row">
            <div class="col-md-12">
               <form action="/cp/saveSettings/" class="onsubmit" data-redirect="/cp/settings/?p=settings">
                     
                  <table class="table table-bordered table-striped" style="margin: 0; margin-top: -1px;"> 
                     <?php foreach ($settings as $item): ?> 
                        <tr> 
                           <td style="width:30%;"><?=$item['name']?></td>
                           <td>
                              <?php if ($item['type'] == 'input'): ?>
                                 <input type="text" name="settings[<?=$item['id']?>]" value="<?=$item['value']?>" class="form-control">
                              <?php elseif($item['type'] == 'select' ): ?>
                                 <?php if ($item['var'] == 'data_lang'): ?>
                                    <select name="settings[<?=$item['id']?>]" class="form-control"> 
                                       <?php foreach ($lang_arr as $key => $value): ?>
                                          <?php 
                                             $check = ($value==var_data_lang) ? 'selected' : '';
                                           ?>
                                          <option <?=$check?> value="<?=$value?>"><?=$value?></option>
                                       <?php endforeach ?>
                                    </select>
                                 <?php endif ?>
                              <?php endif ?>
                           </td> 
                        </tr>
                     <?php endforeach ?> 
                  </table> 
                  <br>
                  <div class="row">
                     <div class="col-md-12"> 
                        <button type="submit" class="btn green">Save</button> 
                     </div>
                  </div> 
               </form> 
            </div>
         </div> 
   <?php endif ?>  
</div>


 