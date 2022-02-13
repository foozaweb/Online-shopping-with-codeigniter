<?php
defined('BASEPATH') or exit('No direct script access allowed');


$route['item/(:any)']    =    'wholesale/item/$1';
$route['wholesale/(:any)']    =    'wholesale/chb/$1';
$route['wholesale']    =    'wholesale/chb';

$route['invoice/(:any)']    =    'Cart/invoice/$1';
$route['ct/(:any)']    =    'Cart/ct/$1';
$route['brand/(:any)']    =    'Cart/brand/$1';
$route['compare/(:any)']    =    'Cart/compare/$1';
$route['product/(:any)']    =    'Cart/product/$1';
$route['(:any)']    =    'Cart/chb/$1';
$route['default_controller'] = 'Cart/chb';
$route['Cart'] = 'Cart/chb';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
