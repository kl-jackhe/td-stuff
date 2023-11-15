<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Admin
$route['admin']                          = 'admin/dashboard';
$route['check/session']                  = 'admin/dashboard/checkSession';
$route['admin/login']                    = 'admin/login';
// Auth
$route['auth']                           = 'auth';
$route['login']                          = 'login/index';
$route['login_v2']                       = 'login/index_v2';
$route['logout']                         = 'login/logout';
$route['register']                       = 'auth/create_user';
$route['forgot_password']                = 'login/forgot_password';
$route['auth/change_password']           = 'auth/change_password';
$route['auth/forgot_password']           = 'auth/forgot_password';
$route['auth/reset_password']            = 'auth/reset_password';
$route['auth/activate/(:num)']           = 'auth/activate/$1';
$route['auth/deactivate/(:num)']         = 'auth/deactivate/$1';
$route['auth/create_user']               = 'auth/create_user';
$route['auth/edit_user/(:any)']          = 'auth/edit_user/$1';
$route['auth/create_group']              = 'auth/create_group';
$route['auth/edit_group/(:num)']         = 'auth/edit_group/$1';
// 商品分類
$route['product/category/insert']        = 'product/insert_category';
$route['product/category/edit/(:num)']   = 'product/edit_category/$1';
$route['product/category/update/(:num)'] = 'product/update_category/$1';
$route['product/category/delete/(:num)'] = 'product/delete_category/$1';
// 優惠券
$route['coupon']                         = 'coupon/index';
$route['coupon/create']                  = 'pos/insert_coupon';
$route['coupon/edit/(:num)']             = 'pos/edit_coupon/$1';
$route['coupon/update/(:num)']           = 'pos/update_coupon/$1';
$route['coupon/delete/(:num)']           = 'pos/delete_coupon/$1';
// 其他
$route['admin/export/(:any)']            = 'admin/export/index/$1';
$route['backup_db']                      = 'others/backup_db';

$route['SingleSales/checkSingleSalesDate'] = 'SingleSales/checkSingleSalesDate';
$route['SingleSales/(:any)'] 			 = 'SingleSales/index/$1';

//////////////////////////////////////////////////////////////////////////////////////

//$route['(.+)']                         = "home";
$route['default_controller']             = 'home';
$route['404_override']                   = '';
$route['translate_uri_dashes']           = TRUE;

$route['sitemap\.xml']                   = "Sitemap/index";