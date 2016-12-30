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
   <i class="fa fa-plus"></i> Добавить
</div>
<?php endif ?>
<?php if (!$this->uri->segment(3)): ?> 
<div class="row taggle_win">
   <div class="col-md-12">
      <div class="portlet light bg-inverse">
         <div class="portlet-title">
            <div class="caption">
               <span class="caption-subject font-red-sunglo bold uppercase"> </span> 
               <div class="tabbable-line">
                  <ul class="nav nav-tabs">
                     <li class="active">
                        <a href="#tab_general" data-toggle="tab">
                        Основная информация </a>
                     </li> 
                     <li>
                        <a href="#char_cat" data-toggle="tab">
                        Категория и характеристики
                        </a>
                     </li>
                     <li>
                        <a href="#seo" data-toggle="tab">
                        SEO
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="actions" id="change-content" style="padding-top:19px;">
               <?php $i=0 ?>
               <?php foreach ($lang_arr as $key => $value): ?>
               <a class="btn btn-circle btn-icon-only btn-default <?=$i==0 ? 'active' : ''?> change-lang" data-lang="<?=$value?>" href="javascript:;">
               <span><?=$value?></span>
               </a>
               <?php $i++ ?>
               <?php endforeach ?> 
            </div>
         </div>
         <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="/cp/<?=$method?>/" class="form-horizontal onsubmit" data-redirect="/cp/<?=$method?>/">
               <div class="form-body">
                  <div class="portlet-body">
                     <div class="tabbable">
                        <div class="tab-content no-space">
                           <div class="tab-pane active" id="tab_general">
                              <?=getInputLang($lang_arr, false, 'Название', 'name', 'text', 'input', false, array('label_col' => 'col-md-1', 'field_col' => 'col-md-11'))?> 
                              <div class="form-group">
                                 <label class="col-md-1 control-label">Ссылка</label>
                                 <div class="col-md-11">
                                    <input type="text" class="form-control" name="url"> 
                                    <span class="help-block" style="color:#e86161">
                                    Без http://www и.т.п просто английская фраза, без пробелов, отражающая пункт меню, например <i>Наш подход - our-approach</i>
                                    </span>
                                 </div>
                              </div>
                              <?=getInputLang($lang_arr, false, 'Описание', 'description', false, 'textarea', false, array('label_col' => 'col-md-1', 'field_col' => 'col-md-11'))?>
                              <?=getInputLang($lang_arr, false, 'Текст', 'text', false, 'textarea', 'ckeditor', array('label_col' => 'col-md-1', 'field_col' => 'col-md-11'))?>    
                              <div class="form-group">
                                 <label class="col-md-1 control-label">Ссылка на видео ролик </label>
                                 <div class="col-md-11">
                                    <input type="text" name="video" class="form-control">  
                                    <span class="help-block" style="color:#e86161">
                                    Полный путь к видео, например <i>https://youtu.be/mWRsgZuwf_8</i>
                                    </span>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-1 control-label">Номер товара</label>
                                 <div class="col-md-11">
                                    <input type="text" class="form-control" name="articul">  
                                 </div>
                              </div>
                              <div class="form-group last">
                                 <label class="control-label col-md-1">Цена (MDL):</label>
                                 <div class="col-md-11">
                                    <input class="form-control" id="mask_price" name="price" type="text"/> 
                                 </div>
                              </div>

                              <div class="form-group last">
                                 <label class="control-label col-md-1">Цена (у.е):</label>
                                 <div class="col-md-11">
                                    <input class="form-control" id="mask_price" name="price_ye" type="text"/> 
                                 </div>
                              </div>

                              <div class="form-group last">
                                 <label class="control-label col-md-1">Количество:</label>
                                 <div class="col-md-11">
                                    <input class="form-control" name="quantity" type="text"/> 
                                 </div>
                              </div>
                                
                              <div class="form-group">
                                 <label class="control-label col-md-1">Промо-акция</label>
                                 <div class="col-md-1">
                                    <input type="checkbox" class="action-switch" data-size="small" name="action"> 
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-1 control-label">Период акции:  
                                 </label>
                                 <div class="col-md-11">
                                    <div class="input-group input-large date-picker input-daterange" data-date-format="dd.mm.yyyy">
                                       <input type="text" class="form-control" name="action_from">
                                       <span class="input-group-addon">
                                       - </span>
                                       <input type="text" class="form-control" name="action_to">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="control-label col-md-1">Новинка</label>
                                 <div class="col-md-1">
                                    <input type="checkbox" class="action-switch" data-size="small" name="is_new"> 
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="control-label col-md-1">Изображения</label>
                                 <div class="col-md-11">
                                    <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10" style="position:relative; display:inline-block; ">
                                       <a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn yellow">
                                       <input type="file" multiple="multiple" id="annonce-multi" name="images[]" onchange="multiImageDescription(this)" class="default" style="position:absolute; top:0; right:0; width:100%; height:100%; direction:ltr; opacity:0;">
                                       <i class="fa fa-plus"></i> Выбрать </a> 
                                    </div>
                                    <div class="row">
                                       <div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12">
                                       </div>
                                    </div>
                                    <table class="table table-bordered table-hover" id="multi-image">
                                       <thead>
                                          <tr role="row" class="heading">
                                             <th width="10%">
                                                Изображение
                                             </th>
                                             <th width="85%">
                                                Короткое описание
                                             </th>
                                             <th width="5%"></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                           <div id="char_cat" class="tab-pane">
                              <div class="form-group">
                                 <label class="col-md-1 control-label">Категория: <span class="req">*</span>
                                 </label>
                                 <div class="col-md-11">
                                    <select class="table-group-action-input form-control select2me" id="char_cat_load" data-placeholder="Search..." name="id_category">
                                       <option value="">Выбрать...</option>
                                       <?php foreach ($categories as $item): ?>
                                       <?php if (isLastLevel($item['id'])): ?>
                                       <option value="<?=$item['id']?>"><?=$item['name_ru']?></option>
                                       <?php endif ?> 
                                       <?php endforeach ?> 
                                    </select>
                                 </div>
                              </div>

                              <div class="form-group">
                                 <div class="col-md-11 col-md-offset-1" id="char_load" style="display:none;">
                                    
                                 </div>
                              </div> 
                           </div>
                           <div class="tab-pane" id="seo">
                              <?=getInputLang($lang_arr, false, 'Заголовок', 'seo_title', 'text', 'input')?>
                              <?=getInputLang($lang_arr, false, 'Описание', 'seo_description', false, 'textarea', false)?>
                              <?=getInputLang($lang_arr, false, 'Ключевые слова', 'seo_keywords', false, 'input', false, array('id' => 'tags_1'))?>
                           </div>
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
<div id="fade-respond" class="alert"> </div>
 
<div class="row">
   <div class="col-md-12">
      <div class="table-container">
         <div class="table-actions-wrapper" style="display:block; float:left;">
            <form action="/cp/catalog" method="get">
               <input type="hidden" name="filter" value="search">  
               <?php if (isset($_GET['filter'])): ?> 
                  <div class="alert alert-info">
                     Результаты поиска: <strong><?=count($data)?></strong>
                  </div>   
               <?php endif ?>

               <input type="text" placeholder="Поиск..." value="<?=@$_GET['val']?>" name="val" style="width:200px !important;" class="table-group-action-input form-control input-inline input-small input-sm">
               <select class="table-group-action-input form-control input-inline input-small input-sm" name="cat">
                  <option value="">Выбрать...</option>
                  <?php foreach ($categories as $item): ?>
                  <?php if ($this->db->where('id_category', $item['id'])->get('catalog')->result_array() && isLastLevel($item['id'])): ?>
                  <?php if (@$_GET['cat'] == $item['id']): ?>
                  <option selected value="<?=$item['id']?>"><?=$item['name_ru']?></option>
                  <?php else: ?>
                  <option value="<?=$item['id']?>"><?=$item['name_ru']?></option>
                  <?php endif ?> 
                  <?php endif ?> 
                  <?php endforeach ?> 
               </select>
                
               <button class="btn btn-sm yellow table-group-action-submit" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Найти</button>
               <a href="/cp/catalog/" class="btn btn-sm red table-group-action-submit" type="submit" style="margin-left:0 !important;"><i class="fa fa-refresh" aria-hidden="true"></i> Сбросить</a>
            </form>
         </div> 

         <div class="portlet" style="float:right;">
            <div class="portlet-title" style="border-bottom:none;"> 
               <div class="actions"> 
                  <div class="btn-group">
                     <a class="btn default yellow-stripe dropdown-toggle" href="javascript:;" data-toggle="dropdown">
                     <i class="fa fa-share"></i>
                     <span class="hidden-480">
                     Опции </span>
                     <i class="fa fa-angle-down"></i>
                     </a>
                     <ul class="dropdown-menu pull-right"> 
                        <li>
                           <a href="/cp/catalog?export">
                           Экспорт</a>
                        </li>
                        <li>
                           <a data-toggle="modal" href="#loadCSV">
                           Импорт</a>
                        </li> 
                     </ul>
                  </div>
               </div>
            </div> 
          </div>

          <div class="modal fade" id="loadCSV" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Импорт</h4>
                  </div>
                  <div class="modal-body">
                      <form action="/cp/uploadCsv/" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                           <label for="exampleInputFile1">Выберите файл</label>
                           <input type="file" id="exampleInputFile1" name="file">
                           <p class="help-block">
                              *Формат <i>Csv</i>
                           </p>
                        </div>
                        <button class="btn blue" type="submit">Сохранить</button>
                      </form>
                  </div>
                  <div class="modal-footer">
                     <button type="button" data-dismiss="modal" class="btn btn-default">Отмена</button> 
                  </div>
               </div>
               <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
         </div>

         <br clear="all">
         <?php if (!empty($data)): ?>
         <?php foreach ($data as $row): ?>
         <?php if (!empty($row['childs'])): ?>
         <h3 class="page-title"><?=$row['name']?></h3>
         <table class="table table-striped table-advance" style="margin: 0; margin-top: -1px;">
            <thead>
               <tr class="heading">
                  <td></td>
                  <td><i class="fa fa-eye fa-center"></i></td>
                  <td><i class="fa fa-shopping-bag tooltips" data-placement="top" data-original-title="Статус:Новый" data-toggle="tooltip"></i></td>
                  <td style="width:60px;"></td>
                  <td></td>
                  <td></td>
               </tr>
            </thead>
            <tbody id="sort-items" data-table="<?=$db_table?>">
               <?php foreach ($row['childs'] as $item): ?>
               <?php $image = $this->db->where('parent_id', $item['id'])->order_by('page_up', 'asc')->order_by('id', 'desc')->get('catalog_images')->row_array(); ?>
               <tr id="<?=$item['id']?>">
                  <td style="width:50px; text-align:center;" class="handle"> </td>
                  <td class="t-border" style="width:30px;">  
                     <?php if ($item['view'] == 1): ?>
                     <input checked onclick="buttonView(this, '<?=$db_table?>', '<?=$item['id']?>')" class="checkbox" name="view" type="checkbox"> 
                     <?php else: ?>
                     <input onclick="buttonView(this, '<?=$db_table?>', '<?=$item['id']?>')" class="checkbox" name="view" type="checkbox">
                     <?php endif ?>  
                  </td>
                  <td class="t-border" style="width:30px;">  
                     <?php if ($item['is_new'] == 1): ?>
                     <input checked onclick="buttonView(this, '<?=$db_table?>', '<?=$item['id']?>', 'is_new')" class="checkbox" type="checkbox"> 
                     <?php else: ?>
                     <input onclick="buttonView(this, '<?=$db_table?>', '<?=$item['id']?>', 'is_new')" class="checkbox" type="checkbox">
                     <?php endif ?>  
                  </td>
                  <td>
                     <div class="fileupload-new thumbnail" style="max-width:60px; max-height:60px; margin:0;"> 
                        <?php if (!empty($image['image'])): ?>
                        <img src="/<?=newthumbs($image['image'], 'public/image/catalog', 60, 60, 'admin_list', 1)?>" style="max-width:49px; max-height:49px;" alt="">
                        <?php else: ?> 
                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" style="max-width:49px; max-height:49px;" alt=""/>
                        <?php endif ?> 
                     </div>
                  </td>
                  <td><a href="/cp/<?=$method?>/<?=$item['id']?>"><?=$item['name_ru']?></a></td>
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
         <?php endif ?>
         <?php endforeach ?>
         <?php endif ?>
      </div>
   </div>
</div>
<?php else: ?>
<div class="row">
   <div class="col-md-12">
      <div class="portlet light bg-inverse">
         <div class="portlet-title">
            <div class="caption">
               <span class="caption-subject font-red-sunglo bold uppercase"> </span> 
               <div class="tabbable-line">
                  <ul class="nav nav-tabs">
                     <li class="active">
                        <a href="#tab_general" data-toggle="tab">
                        Основная информация </a>
                     </li>

                     <li>
                        <a href="#char_cat" data-toggle="tab">
                        Категория и характеристики
                        </a>
                     </li>

                     <li>
                        <a href="#seo" data-toggle="tab">
                        SEO
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="actions" id="change-content" style="padding-top:19px;">
               <?php $i=0 ?>
               <?php foreach ($lang_arr as $key => $value): ?>
               <a class="btn btn-circle btn-icon-only btn-default <?=$i==0 ? 'active' : ''?> change-lang" data-lang="<?=$value?>" href="javascript:;">
               <span><?=$value?></span>
               </a>
               <?php $i++ ?>
               <?php endforeach ?> 
            </div>
         </div>
         <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="/cp/<?=$method?>/<?=$data['id']?>/" class="form-horizontal onsubmit" data-redirect="/cp/<?=$method?>/">
               <div class="form-body">
                  <input type="hidden" class="form-control" name="id" value="<?=$data['id']?>">
                  <div class="portlet-body">
                     <div class="tabbable">
                        <div class="tab-content no-space">
                           <div class="tab-pane active" id="tab_general">
                              <?=getInputLang($lang_arr, $data, 'Название', 'name', 'text', 'input', false, array('label_col' => 'col-md-1', 'field_col' => 'col-md-11'))?> 
                              <div class="form-group">
                                 <label class="col-md-1 control-label">Ссылка</label>
                                 <div class="col-md-11">
                                    <input type="text" class="form-control" name="url" value="<?=$data['url']?>"> 
                                    <span class="help-block" style="color:#e86161">
                                    Без http://www и.т.п просто английская фраза, без пробелов, отражающая пункт меню, например <i>Наш подход - our-approach</i>
                                    </span>
                                 </div>
                              </div>
                              <?=getInputLang($lang_arr, $data, 'Описание', 'description', false, 'textarea', false, array('label_col' => 'col-md-1', 'field_col' => 'col-md-11'))?>
                              <?=getInputLang($lang_arr, $data, 'Текст', 'text', false, 'textarea', 'ckeditor', array('label_col' => 'col-md-1', 'field_col' => 'col-md-11'))?>    
                              <div class="form-group">
                                 <label class="col-md-1 control-label">Ссылка на видео ролик </label>
                                 <div class="col-md-11">
                                    <input type="text" name="video" class="form-control" value="<?=$data['url']?>"> 
                                    <span class="help-block" style="color:#e86161">
                                    Полный путь к видео, например <i>https://youtu.be/mWRsgZuwf_8</i>
                                    </span>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-1 control-label">Номер товара</label>
                                 <div class="col-md-11">
                                    <input type="text" class="form-control" name="articul" value="<?=$data['articul']?>">  
                                 </div>
                              </div>
                              <div class="form-group last">
                                 <label class="control-label col-md-1">Цена (MDL):</label>
                                 <div class="col-md-11">
                                    <input class="form-control" id="mask_price" name="price" value="<?=$data['price']?>" type="text"/> 
                                 </div>
                              </div>
                              <div class="form-group last">
                                 <label class="control-label col-md-1">Цена (у.е):</label>
                                 <div class="col-md-11">
                                    <input class="form-control" id="mask_price" name="price_ye" value="<?=$data['price_ye']?>" type="text"/> 
                                 </div>
                              </div> 

                              <div class="form-group last">
                                 <label class="control-label col-md-1">Количество:</label>
                                 <div class="col-md-11">
                                    <input class="form-control" name="quantity" value="<?=$data['quantity']?>" type="text"/> 
                                 </div>
                              </div>

                              <div class="form-group">
                                 <label class="control-label col-md-1">Промо-акция</label>
                                 <div class="col-md-11">
                                    <?php if ($data['action'] == '1'): ?>
                                    <input type="checkbox" checked class="action-switch" data-size="small" name="action">
                                    <?php else: ?>
                                    <input type="checkbox" class="action-switch" data-size="small" name="action">
                                    <?php endif ?> 
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-md-1 control-label">Период акции:  
                                 </label>
                                 <div class="col-md-11">
                                    <div class="input-group input-large date-picker input-daterange" data-date-format="dd.mm.yyyy">
                                       <input type="text" class="form-control" name="action_from" value="<?=!empty($data['action_from']) ? date('d.m.Y', $data['action_from']) : ''?>">
                                       <span class="input-group-addon">
                                       - </span>
                                       <input type="text" class="form-control" name="action_to" value="<?=!empty($data['action_to']) ? date('d.m.Y', $data['action_to']) : ''?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="control-label col-md-1">Новинка</label>
                                 <div class="col-md-1">
                                    <?php if ($data['is_new'] == '1'): ?>
                                    <input type="checkbox" checked class="action-switch" data-size="small" name="is_new">
                                    <?php else: ?>
                                    <input type="checkbox" class="action-switch" data-size="small" name="is_new">
                                    <?php endif ?>  
                                 </div>
                              </div>
                              <?php 
                                 $img = $this->db->where('parent_id', $data['id'])->order_by('page_up', 'asc')->get('catalog_images')->result_array();
                                 ?> 
                              <div class="form-group">
                                 <label class="control-label col-md-1">Изображения</label>
                                 <div class="col-md-11">
                                    <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10" style="position:relative; display:inline-block; ">
                                       <a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn yellow">
                                       <input type="file" multiple="multiple" id="annonce-multi" name="images[]" onchange="multiImageDescription(this)" class="default" style="position:absolute; top:0; right:0; width:100%; height:100%; direction:ltr; opacity:0;">
                                       <i class="fa fa-plus"></i> Добавить </a> 
                                    </div>
                                    <div class="row">
                                       <div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12">
                                       </div>
                                    </div>
                                    <table class="table table-bordered table-hover" id="multi-image">
                                       <thead>
                                          <tr role="row" class="heading">
                                             <th width="10%">
                                                Изображение
                                             </th>
                                             <th width="85%">
                                                Короткое описание
                                             </th>
                                             <th width="5%"></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       </tbody>
                                    </table>
                                    <?php if (!empty($img)): ?>
                                    <table class="table table-bordered table-hover">
                                       <thead>
                                          <tr role="row" class="heading">
                                             <th width="5%"></th>
                                             <th></th>
                                             <th width="5%">
                                                Изображение
                                             </th>
                                             <th width="85%">
                                                Короткое описание
                                             </th>
                                             <th width="5%"></th>
                                          </tr>
                                       </thead>
                                       <tbody id="sort-items2" data-table="catalog_images">
                                          <?php $dsc=0  ?>
                                          <?php foreach ($img as $item): ?> 
                                          <tr id="<?=$item['id']?>">
                                             <td style="width:50px; text-align:center;" class="handle"> </td>
                                             <td class="t-border" style="width:30px;"> 
                                                <?php if ($item['view'] == 1): ?>
                                                <input checked onclick="buttonView(this, 'catalog_images', '<?=$item['id']?>')" class="checkbox" name="view" type="checkbox"> 
                                                <?php else: ?>
                                                <input onclick="buttonView(this, 'catalog_images', '<?=$item['id']?>')" class="checkbox" name="view" type="checkbox">
                                                <?php endif ?>  
                                             </td>
                                             <td>
                                                <a href="/<?=newthumbs($item['image'], 'public/image/catalog', 1200, 0, 'admin_edit_big', 0)?>" class="fancybox-button" data-rel="fancybox-button">
                                                <img class="img-responsive" src="/<?=newthumbs($item['image'], 'public/image/catalog', 150, 150, 'admin_edit', 1)?>" alt=""> 
                                                </a>
                                             </td>
                                             <td>
                                                <textarea style="height:100px;" class="lang-area form-control" id="field_ru" name="update_mini_description[ru][<?=$item['id']?>]" class="form-control" id="dscp" rows="3"><?=strip_tags($item['description_ru'])?></textarea>
                                                <textarea style="height:100px;" class="lang-area form-control" id="field_ro" name="update_mini_description[ro][<?=$item['id']?>]" class="form-control" id="dscp" rows="3"><?=strip_tags($item['description_ro'])?></textarea>
                                             </td>
                                             <td>
                                                <a data-toggle="modal" href="#myModal<?=$item['id']?>" class="btn default btn-sm">
                                                <i class="fa fa-times"></i> Удалить </a>
                                                <div class="modal fade theme-modal" id="myModal<?=$item['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                   <div class="modal-dialog">
                                                      <div class="modal-content">
                                                         <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h4 class="modal-title">Подтвердить операцию</h4>
                                                         </div>
                                                         <div class="modal-body"> 
                                                            Вы действительно желаете удалить?
                                                         </div>
                                                         <div class="modal-footer">
                                                            <button data-dismiss="modal" class="btn btn-default" type="button">Отмена</button>
                                                            <button class="btn btn-success" type="button" onclick="toDelete(this,'<?=base_url('cp/deleteElement/')?>','<?=$item['id']?>', 'catalog_images')">Удалить</button>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </td>
                                          </tr>
                                          <?php $dsc++ ?>
                                          <?php endforeach ?> 
                                       </tbody>
                                    </table>
                                    <?php endif ?>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane" id="seo">
                              <?=getInputLang($lang_arr, $data, 'Заголовок', 'seo_title', 'text', 'input')?>
                              <?=getInputLang($lang_arr, $data, 'Описание', 'seo_description', false, 'textarea', false)?>
                              <?=getInputLang($lang_arr, $data, 'Ключевые слова', 'seo_keywords', false, 'input', false, array('id' => 'tags_1'))?>
                           </div>

                           <div class="tab-pane" id="char_cat">
                              <script>
                                $(document).ready(function(){
                                     $('#char_cat_load').change();
                                });
                              </script>
                              <div class="form-group">
                                 <label class="col-md-1 control-label">Категория: <span class="req">*</span> 
                                 </label>
                                 <div class="col-md-11">
                                    <select class="table-group-action-input form-control select2me" id="char_cat_load" data-placeholder="Search..." name="id_category">
                                       <option value="">Выбрать...</option>
                                       <?php foreach ($categories as $item): ?>
                                       <?php if (isLastLevel($item['id'])): ?>
                                       <?php $active_cat = $data['id_category']==$item['id'] ? 'selected' : '' ?>
                                       <option <?=$active_cat?> value="<?=$item['id']?>"><?=$item['name_ru']?></option>
                                       <?php endif ?> 
                                       <?php endforeach ?> 
                                    </select>
                                 </div>
                              </div>

                              <div class="form-group">
                                 <div class="col-md-11 col-md-offset-1" id="char_load" style="display:none;">
                                    
                                 </div>
                              </div>

                           </div>
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