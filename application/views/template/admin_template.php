<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 4.0.1
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Admin Panel</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="/theme/theme/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="/theme/theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="/theme/theme/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="/theme/theme/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="/theme/theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->

<link rel="stylesheet" type="text/css" href="/theme/theme/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>

<link rel="stylesheet" type="text/css" href="/theme/theme/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
 
<link href="/theme/theme/assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" type="text/css" href="/theme/theme/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="/theme/theme/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/theme/theme/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>

<link rel="stylesheet" type="text/css" href="/theme/theme/assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>

<link href="/css/loader.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="/theme/theme/assets/global/plugins/jstree/dist/themes/default/style.min.css"/>

<link href="/theme/theme/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>

<link href="/theme/theme/assets/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css"/> 

<!-- BEGIN THEME STYLES -->
<link href="/theme/theme/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="/theme/theme/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="/theme/theme/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link id="style_color" href="/theme/theme/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"/>
<link href="/theme/theme/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<link href="/theme/theme/assets/admin/layout/css/mine.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" href="/js/admin/multiCategory/nestable.css">

<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
<script src="/theme/theme/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/theme/theme/assets/global/plugins/jstree/dist/jstree.min.js"></script> 
<script type="text/javascript" src="/theme/theme/assets/global/plugins/select2/select2.min.js"></script>
<script>   
  $(window).on('load', function() { // makes sure the whole site is loaded 
    $('#status').fadeOut(); // will first fade out the loading animation 
    $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website. 
    $('body').delay(350).css({'overflow':'visible'});
  }); 

   var getLang = JSON.parse('<?=json_encode($lang_arr)?>');
   _LANG = []; 
   $.each(getLang, function(key,value) {
      _LANG.push(value);
   }); 

</script> 
 
</head>
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<?php 
       
      $uri3 = $this->uri->segment(3);   
      $uri2 = $this->uri->segment(2);
      if ($this->uri->segment(1) == 'cp' && empty($uri2)) {
         $uri2 = 'menu';
      } 
        
      $menu = array(
            'menu' => array(
                  'name' => 'Разделы сайта', 
                  'icon' => '<i class="fa fa-bars" aria-hidden="true"></i>',
                  'link' => '/cp/menu/',
                  'view' => true,
                  'edit' => 'Редактировать',
                  'childs' => array(
                        'edit'
                     )
               ),   

            'projects' => array(
                  'name' => 'Projects', 
                  'icon' => '<i class="fa fa-sitemap" aria-hidden="true"></i>',
                  'link' => '/cp/projects/',
                  'view' => true,
                  'edit' => 'Edit',
                  'childs' => array(
                        'edit'
                     )
               ),  

            'faq' => array(
                  'name' => 'Faq', 
                  'icon' => '<i class="fa fa-question-circle-o" aria-hidden="true"></i>',
                  'link' => '/cp/faq/',
                  'view' => true,
                  'edit' => 'Edit',
                  'childs' => array(
                        'edit'
                     )
               ),  

            'faq-categories' => array(
                  'name' => 'Faq Categories', 
                  'icon' => '<i class="fa fa-level-up" aria-hidden="true"></i>',
                  'link' => '/cp/faq-categories/',
                  'view' => true,
                  'edit' => 'Edit',
                  'childs' => array(
                        'edit'
                     )
               ),  


            'emails-list' => array(
                  'name' => 'Emails List', 
                  'icon' => '<i class="fa fa-sitemap" aria-hidden="true"></i>',
                  'link' => '/cp/emails-list/',
                  'view' => false,
                  'edit' => 'Edit',
                  'childs' => array(
                        'edit'
                     )
               ), 

            'interview' => array(
                  'name' => 'Survey', 
                  'icon' => '<i class="fa fa-commenting" aria-hidden="true"></i>',
                  'link' => '/cp/interview/',
                  'view' => true,
                  'edit' => 'Edit',
                  'childs' => array(
                        'edit'
                     )
               ),   
 
            // 'notification-status' => array(
            //       'name' => 'Notification Status', 
            //       'icon' => '<i class="fa fa-calendar" aria-hidden="true"></i>',
            //       'link' => '/cp/notification-status/',
            //       'view' => true,
            //       'edit' => 'Edit',
            //       'childs' => array(
            //             'edit'
            //          )
            //    ),   

            'edit-chapter' => array(
                  'name' => 'Edit Chapter', 
                  'icon' => '<i class="fa fa-calendar" aria-hidden="true"></i>',
                  'link' => '/cp/edit-chapter/',
                  'view' => false,
                  'edit' => 'Edit',
                  'childs' => array(
                        'edit'
                     )
               ), 

            'question' => array(
                  'name' => 'Chapter Question', 
                  'icon' => '<i class="fa fa-calendar" aria-hidden="true"></i>',
                  'link' => '/cp/question/',
                  'view' => false,
                  'edit' => 'Edit',
                  'childs' => array(
                        'edit'
                     )
               ),  
 
            'languages' => array(
                  'name' => 'Languages', 
                  'icon' => '<i class="fa fa-language" aria-hidden="true"></i>',
                  'link' => '/cp/languages/',
                  'view' => true,
                  'edit' => 'Edit' 
               ),

            'settings' => array(
                  'name' => 'Settings', 
                  'icon' => '<i class="fa fa-sliders" aria-hidden="true"></i>',
                  'link' => '/cp/settings/',
                  'view' => true,
                  'edit' => 'Edit' 
               ),

            'edit-user' => array(
                  'name' => 'Settings', 
                  'icon' => '<i class="fa fa-sliders" aria-hidden="true"></i>',
                  'link' => '/cp/edit-user/',
                  'view' => false,
                  'edit' => 'Edit' 
               ),


            'constants' => array(
                  'name' => 'Constants', 
                  'icon' => '<i class="fa fa-anchor" aria-hidden="true"></i>',
                  'link' => '/cp/constants/',
                  'view' => true,
                  'edit' => 'Редактировать' 
               ),
 
         );

 ?>
 
<body class="page-header-fixed page-quick-sidebar-over-content">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
   <!-- BEGIN HEADER INNER -->
   <div class="page-header-inner">
      <!-- BEGIN LOGO -->
      <div class="page-logo">
         <!-- <a href="http://www.ilab.md/" target="blank">
         <img src="/img/admin_logo.png" alt="logo" style="width:95px; margin:9px 0 0 0;" class="logo-default"/>
         </a> -->
         <div class="menu-toggler sidebar-toggler hide">
            <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
         </div>
      </div>
      <!-- END LOGO -->
      <!-- BEGIN RESPONSIVE MENU TOGGLER -->
      <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
      </a>
      <!-- END RESPONSIVE MENU TOGGLER -->
      <!-- BEGIN TOP NAVIGATION MENU -->
      <div class="top-menu">
         <ul class="nav navbar-nav pull-right"> 
            <li class="dropdown dropdown-user">
               <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                
               <span class="username username-hide-on-mobile">
               <?=ucfirst(getAdminUser('login'))?> </span>
               <i class="fa fa-angle-down"></i>
               </a>
               <ul class="dropdown-menu dropdown-menu-default">
                  <li>
                     <a href="/cp/settings/">
                     <i class="icon-user"></i> My Profile </a>
                  </li>
                  
                  <li>
                     <a href="/cp/logout">
                     <i class="icon-key"></i> Log Out </a>
                  </li>
               </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
            
            <!-- END QUICK SIDEBAR TOGGLER -->
         </ul>
      </div>
      <!-- END TOP NAVIGATION MENU -->
   </div>
   <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
   <!-- BEGIN SIDEBAR -->
   <div class="page-sidebar-wrapper">
      <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
      <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
      <div class="page-sidebar navbar-collapse collapse">
         <!-- BEGIN SIDEBAR MENU -->
         <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
         <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
         <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
         <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
         <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
         <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
         <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
               <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
               <div class="sidebar-toggler">
               </div>
               <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
          
            <li class="sidebar-search-wrapper"><br></li>
            <?php foreach ($menu as $key => $value): ?>
               <?php if (!empty($value['view'])): ?> 
                  <?php if ($uri2 == $key) { $active = 'active'; }else{ $active = ''; } ?> 
                  
                  <?php  
                     $span_book = '';
                     $span_request = '';

                     $interviewAccess = array();
                     if (Can(array('WORKING_WITH_SURVEY')) === false) { 
                        $interviewAccess = array('interview', 'edit-chapter', 'question');

                        if (in_array($key, $interviewAccess)) { 
                           continue;
                        }
                     }  
                  ?> 
                  <li class="start <?=$active?>">
                     <a href="<?=$value['link']?>">
                     <?=$value['icon']?>
                     <span class="title"><?=$value['name']?></span> 
                     <?=$span_book?>
                     <?=$span_request?>
                     </a> 
                  </li> 
               <?php endif ?>
            <?php endforeach ?> 
         </ul>
         <!-- END SIDEBAR MENU -->
      </div>
   </div>
   <!-- END SIDEBAR -->
   <!-- BEGIN CONTENT -->

   <div class="page-content-wrapper">
      <div class="page-content"> 
         <!-- BEGIN PAGE HEADER-->
         <h3 class="page-title">
            <?=$menu[$uri2]['name']?>
         </h3>
         <div class="page-bar">
            <ul class="page-breadcrumb">
               <?php if (empty($breadcrumbs)): ?>  
                  <li>
                     <i class="fa fa-home"></i>
                     <a href="/cp/projects/">Home</a>
                     <i class="fa fa-angle-right"></i> 
                  </li>
                  <li> 
                     <a href="<?=$menu[$uri2]['link']?>"><?=$menu[$uri2]['name']?></a>
                     <?php if ($uri3): ?>
                        <i class="fa fa-angle-right"></i>
                     <?php endif ?> 
                  </li>
                  <?php if ($uri3): ?>
                     <li>
                        <a href="javascript:;" style="text-decoration:none; cursor:pointer;"><?=!empty($crumb2) ? $crumb2 : $menu[$uri2]['edit']?></a> 
                     </li> 
                  <?php endif ?>  
               <?php else: ?>
                  <?=$breadcrumbs?>
               <?php endif ?>
            </ul>  
         </div>
         <!-- END PAGE HEADER-->
         <!-- BEGIN PAGE CONTENT-->
         {content}
         <!-- END PAGE CONTENT-->
      </div>
   </div>
 
   <!-- END CONTENT -->
   <!-- BEGIN QUICK SIDEBAR -->
   <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
 
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
  
   <div class="scroll-to-top">
      <i class="icon-arrow-up"></i>
   </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/theme/theme/assets/global/plugins/respond.min.js"></script>
<script src="/theme/theme/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
 
<script src="/theme/theme/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/theme/theme/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/theme/theme/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/theme/theme/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/theme/theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/theme/theme/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/theme/theme/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/theme/theme/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/theme/theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script> 

<script type="text/javascript" src="/theme/theme/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>

<script type="text/javascript" src="/theme/theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> 
<script src="/theme/theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.ru.js" type="text/javascript"></script>

<script src="/theme/theme/assets/admin/pages/scripts/components-pickers.js"></script>

<script src="/theme/theme/assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
 
<script type="text/javascript" src="/theme/theme/assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="/theme/theme/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/theme/theme/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="/theme/theme/assets/global/plugins/jquery-multi-select/js/jquery.quicksearch.js"></script>

<script type="text/javascript" src="/theme/theme/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"></script>

<script type="text/javascript" src="/theme/theme/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
 
<script type="text/javascript" src="/theme/theme/assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
 
  
<!-- END CORE PLUGINS -->
<script src="/theme/theme/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/theme/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/theme/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="/theme/theme/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="/theme/theme/assets/admin/pages/scripts/components-form-tools.js"></script>
<script src="/theme/theme/assets/admin/pages/scripts/components-dropdowns.js"></script>
 
<script src="/theme/theme/assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>

<!-- personal scripts --> 
<script src="/js/admin/multiCategory/jquery.nestable.js"></script>

<script src="/theme/theme/assets/admin/pages/scripts/components-form-tools2.js"></script> 
 
<script src="/public/lib/js-url/url.js"></script>
<script src="/js/admin/ajax.js"></script>
<script src="/js/admin/scripts.js"></script>
<script src="/js/admin/load.image.js"></script>
<script src="/js/admin/jquery.tablednd.js"></script> 

<script type="text/javascript" src="/theme/theme/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="/theme/theme/assets/admin/pages/scripts/form-wizard.js"></script>

<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBx4awp-dXh9PgZoW5cCC6DydmBTGvzrMU"></script> -->

<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBx4awp-dXh9PgZoW5cCC6DydmBTGvzrMU"></script> -->

<script type="text/javascript" src="/theme/theme/assets/global/plugins/ckeditor/ckeditor.js"></script> 
<script>
   
      $('.fancybox-button').fancybox();

      jQuery(document).ready(function() {    
         Metronic.init(); // init metronic core components
         Layout.init(); // init current layout
         QuickSidebar.init(); // init quick sidebar
         Demo.init(); // init demo features 
         ComponentsPickers.init();
         ComponentsDropdowns.init();
         FormWizard.init();
         ComponentsFormTools2.init(); 
         // ComponentsFormTools.init();
      }); 

      $('.number').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
      });

      $('.c-picker').datepicker({
           rtl: Metronic.isRTL(),
           orientation: "left",
           autoclose: true,
           format: "mm.yyyy",
           startView: "months", 
           minViewMode: "months",
           language: 'ru-RU' 
      });

         var i = 1;
         $('#tags_1:hidden, #tags_1:visible').each(function() {
              $(this).attr('id', 'tags_1_' + i);
              
               $('#tags_1_' + i).tagsInput({
                  width: 'auto',
                  defaultText:'',
                  minChars:0,
                  'onAddTag': function () { 
                  },
              });

              i = i + 1;
         });  

         function startMaskNewInput(){
            $('.rp').each(function(i){
               $(this).attr('id', 'mask_'+i);
               $("#mask_"+i).inputmask("decimal",{
                alias: 'numeric',
                radixPoint:".", 
                    groupSeparator: " ", 
                    digits: 2,
                    autoGroup: true,
                    allowMinus: false 

                });
            });
         }

         startMaskNewInput();
           
         $("#mask_price, #mask_old_price").inputmask("decimal",{
                alias: 'numeric',
                radixPoint:".", 
                    groupSeparator: " ", 
                    digits: 2,
                    autoGroup: true,
                    allowMinus: false 

                });
      
      $(document).ready(function(){
         $('input.select_type').change(function(){
            var val = $(this).val(); 
            var charBlock=$('#char-display');
            var charCheckboxInput=$('#char-select-val');
             
            if (val=='checkbox') {
               $(charBlock).show();
               $(charCheckboxInput).show();
            }else if(val=='default'){
               $(charBlock).show();
               $(charCheckboxInput).hide();
            }
         });  
      }); 

      $(window).load(function(){
         if ($('[data-map="multi"]').length>0) {
            initMap();
         }  
           
         if ($('[data-map="unique"]').length>0) {
            uniqueMap();
         } 
      });  
 
      $(document).ready(function(){
         if ($('#char_cat_load').length) {
            $('#char_cat_load').select2().on("change", function(e) {
                  var val = $(this).val();
                  $( "#char_load" ).load( "/cp/loadChar/",{val: val, prod:'<?=$this->uri->segment(3)?>'}, function( response, status, xhr ) { 
                     if ( response == "error" ) {
                       $('#char_load').hide();
                     }else{
                       $('#char_load').show();
                     }
                  });
            });  
         } 
      });
</script>

<script>
   $(document).ready(function(){
      function closeAllAttrBlock(item){
         var arr = [];
         $(item).each(function(){
            var idAttrBlock = $(this).attr('data-href');   
            if ($(this).prop('checked')) {
               arr.push(idAttrBlock);
            }else{
               $(idAttrBlock).hide();
            } 
         }); 

         for (var i = 0; i < arr.length; i++) {
            $(arr[i]).show(); 
         } 
      } 
      closeAllAttrBlock('.open_attr_block');
        
      $('.open_attr_block').change(function(){
         var state = $(this).prop('checked');   
         var idAttrBlock = $(this).attr('data-href');
         closeAllAttrBlock('.open_attr_block');
         if (state == true) {
            $(idAttrBlock).show();
         }else{
            $(idAttrBlock).hide();
         }
      });
   });
</script> 
 
   <style>
   .section_checkbox{
      padding-left: 15px;
   }
</style>

<script>
   function setCheckchild(item) {
      var id = $(item).attr('data-val');
      var dataParent = $(item).attr('data-parent');

      if ($(item).prop('checked') == true) {  
         $('.parent_'+dataParent).find('input#p_id').prop('checked', true);
         $('.parent_'+dataParent).find('.checker span').addClass('checked'); 
      }else{  
         $('.parent_'+dataParent).find('input#p_id').prop('checked', false);
         $('.parent_'+dataParent).find('.checker span').removeClass('checked');  
      } 
   }

   $('.clear_actions').each(function(){
      $(this).find('a').attr('href', 'javascript:;');
      $(this).find('a').attr('onclick', 'return false;'); 
      $(this).find('input').attr('name', '');
      $(this).find('input').val(null);  
   });

</script>

<style>
   .section_checkbox{
      margin-bottom: 10px;
   }
</style>
<style> 
   .req{
      color: red;
   }
   .f-right{
      float: right;
   }

   input.handle-input{
       width: 30px;
       border: 1px solid #ddd;
       color:  #888;
       text-align: center;
       display: inline-block;
       margin-right: 10px;
   }

   .lock-project{
      opacity: 0.5;
      cursor: default;
      pointer-events: none;
   }

   .filter-cheackbox{
      margin-left: 15px;
      padding:0;
   }

   .filter-cheackbox li{
      list-style: none;
   }

   li.no-active a{
      cursor: default;
   }

</style> 

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>