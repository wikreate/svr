<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 

$route['default_controller'] = "pages";
$route['404_override'] = '';

/*admin routes*/
$route['login']                              	= 'login/log_in';
$route['updatePassword']                        = 'login/updatePassword';
 
$route['cp']                                    = 'admin/menu';
  
/*login*/ 
$route['cp/logout']                             = 'login/logout';

$route['cp/(:any)'] = 'admin/controller/$1';
   
// $lang = '(ru|ro)';  
// $route['(ru|ro)'] = 'pages';  

$route['(:any)/faq/(:any)'] = 'pages/faq';
$route['(:any)'] = 'pages/top_menu';
// $route['(:any)'] = 'pages/display_404';
  

 
 
 