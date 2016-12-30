
<?php if (!empty($_SESSION['msg'])): ?>
   <div class="row">
      <div class="col-md-12">
         <?=$_SESSION['msg']?>
         <?php unset($_SESSION['msg'])?>
      </div>
   </div> 
<?php endif ?>


<div id="fade-respond" class="alert"> </div> 

<div class="row">
   <div class="col-md-12">
      <div class="portlet light bg-inverse">
            <div class="portlet-title" style="border-bottom:0px; margin-bottom:0!important;">
               <div class="caption"> 
                  <span class="caption-subject font-red-sunglo bold uppercase"> </span>  
               </div>
               <div class="actions" id="change-content" style="padding-top:19px;"> 
                  <?php $i=0 ?>
                  <?php foreach ($langs as $key => $value): ?>
                     <a class="btn btn-circle btn-icon-only btn-default <?=$i==0 ? 'active' : ''?> change-lang" data-lang="<?=$value?>" href="javascript:;">
                        <span><?=$value?></span>
                     </a>
                  <?php $i++ ?>
                  <?php endforeach ?> 
               </div>
            </div>

            <div class="portlet-body form">
               <!-- BEGIN FORM-->
               <form action="/cp/<?=$method?>/<?=$chapter['id']?>/<?=$chapter['id_interview']?>/" class="form-horizontal onsubmit" data-redirect="/cp/<?=$method?>/<?=$chapter['id']?>/<?=$chapter['id_interview']?>/"> 
                  <div class="form-body"> 
                     <?=getInputLang($langs, $chapter, 'Name <span class="req">*</span>', 'name', 'text', 'input')?>     
                  </div>
                  <div class="form-actions">
                     <div class="row">
                        <div class="col-md-offset-1 col-md-4">
                           <a href="/cp/interview/add/?step=4&iw_id=<?=$id_interview?>" class="btn default button-previous">
                              <i class="m-icon-swapleft"></i> 
                              Back to Survey
                           </a>
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
 