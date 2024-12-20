<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//specify route for post details page
$route['blogs/(:any)'] = 'blogs/details/$1';

// appliances
$route['appliances']                            = 'appliances/appliances/index';
// $route['appliances/cooking']                    = 'appliances/cooking/index';
$route['appliances/cooking/category/(:any)']    = 'appliances/cooking/category/$1';
$route['appliances/fabric/category/(:any)']     = 'appliances/fabric/category/$1';
$route['appliances/kitchen/category/(:any)']    = 'appliances/kitchen/category/$1';

// Electricals
$route['electricals'] = 'electricals/electricals/index';
$route['electricals/fans/category/(:any)']             = 'electricals/fans/category/$1';
$route['electricals/leds/category/(:any)']             = 'electricals/leds/category/$1';
$route['electricals/heaters/category/(:any)']          = 'electricals/heaters/category/$1';

// Design Hardware
$route['design-hardware']                               = 'design-hardware/designHardware/index';
$route['design-hardware/door-handles']                  = 'design-hardware/doorHandles/index'; 
$route['design-hardware/door-handles/category/(:any)']  = 'design-hardware/doorHandles/category/$1';
$route['design-hardware/door-locks-and-accessories']    = 'design-hardware/doorLocksAccessories/index'; 
$route['design-hardware/door-locks-and-accessories/category/(:any)'] = 'design-hardware/doorLocksAccessories/category/$1';
$route['design-hardware/furniture-fittings']                  = 'design-hardware/furnitureFittings/index'; 
$route['design-hardware/furniture-fittings/category/(:any)']  = 'design-hardware/furnitureFittings/category/$1';

// Sanitary Ware
$route['sanitaryware']                                = 'sanitaryware/sanitaryware/index';
$route['sanitaryware/wash-basins']                    = 'sanitaryware/washbasins/index';
$route['sanitaryware/wash-basins/category/(:any)']    = 'sanitaryware/washbasins/category/$1';
$route['sanitaryware/midnight-collection']            = 'sanitaryware/midnightcollection/index';
$route['sanitaryware/midnight-collection/category/(:any)'] = 'sanitaryware/midnightcollection/category/$1';
$route['sanitaryware/water-closets']                  = 'sanitaryware/waterclosets/index';
$route['sanitaryware/water-closets/category/(:any)']  = 'sanitaryware/waterclosets/category/$1';

// Tiles
$route['tiles']                                       = 'tiles/tiles/index';
$route['tiles/floor-tiles']                           = 'tiles/floortiles/index';
$route['tiles/floor-tiles/category/(:any)']           = 'tiles/floortiles/category/$1';
$route['tiles/wall-tiles']                            = 'tiles/walltiles/index';
$route['tiles/wall-tiles/category/(:any)']            = 'tiles/walltiles/category/$1';

// Bath Fittings
$route['bath-fittings']                                = 'bath-fittings/bathFittings/index';
$route['bath-fittings/faucets']                        = 'bath-fittings/faucets/index';
$route['bath-fittings/faucets/category/(:any)']        = 'bath-fittings/faucets/category/$1';
$route['bath-fittings/showers']                        = 'bath-fittings/showers/index';
$route['bath-fittings/showers/category/(:any)']        = 'bath-fittings/showers/category/$1';
$route['bath-fittings/accessories-and-mirrors']        = 'bath-fittings/accessoriesandmirrors/index';
$route['bath-fittings/accessories-and-mirrors/category/(:any)']    = 'bath-fittings/accessoriesandmirrors/category/$1';

// Modular Kitchen
// $route['modularkitchen']                              = 'modularkitchen/modularkitchen/index';
$route['modularkitchen/category/(:any)']              = 'modularkitchen/category/$1';

$route['quartz/category/(:any)'] = 'quartz/category/$1';
$route['product/(:any)'] = 'product/index/$1';

