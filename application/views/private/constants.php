
<?php if ($this->session->userdata('msg')): ?>
<div class="row">
   <div class="col-md-12">
      <div class="alert alert-dismissible alert-success">
         <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i>  </button>
         <?=$this->session->userdata('msg')?>
         <?=$this->session->unset_userdata('msg')?>
      </div>
   </div>
</div>
<?php endif ?> 
<div id="fade-respond" class="alert"> </div>
<div class="row">
   <div class="col-md-12">
      <?php $attributes = array('class' => 'form-horizontal onsubmit', 'enctype'=>"multipart/form-data", 'data-url' => base_url('cp/constants'), 'data-ck' => true, 'data-redirect' => '/cp/constants');
            echo form_open('', $attributes); 
            ?>   
         <?php foreach ($text as $item): ?>   
               <div class="form-group"> 
                  <label class="col-lg-12 control-label const-descr" style="text-align:left;"><?=$item['description']?></label>  
                  
                  <?php foreach ($lang_arr as $key => $value_lang): ?>
                     <?php 
                        $result2 = $this->db->where('id_const', $item['id'])->where('id_lang', $key)->get('constants_value')->row_array();

                        if (empty($result2)) {
                           $data = array(
                              'id_const' => $item['id'] ,
                              'id_lang' => $key 
                           );
                           $this->db->insert('constants_value', $data);
                           $value_const = "";
                           $id_const = $this->db->insert_id();
                        }else{
                           $value_const = $result2['value'];
                           $id_const = $result2['id'];
                        } 
                     ?> 
                     <div class="col-sm-3">   
                        <label><?=$value_lang?></label> 
                        <textarea style="min-height:55px !important; max-height:55px;" name="text[<?=$id_const?>]" class="form-control <?=!empty($item['editor']) ? 'ckeditor' :''?>"><?=$value_const?></textarea>   
                     </div> 
                  <?php endforeach ?>  
               </div>  
               <br> 
         <?php endforeach ?> 
      <br> 
      <div class="form-group">
         <div class="col-lg-12">
            <input class="btn btn-submit btn-blue" type="submit" value="Сохранить"> 
         </div>
      </div>
      </form>
   </div>
</div>