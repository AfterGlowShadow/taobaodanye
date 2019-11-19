<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//use app\common\model\MiniappAddon;

$result = [];

function route_lib($dir) {
	$files = [];
	$_route = [];
	if (@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
		while (($file = readdir($handle)) !== false) {
			if ($file != ".." && $file != ".") { //排除根目录；
				if (is_dir($dir . "/" . $file)) { //如果是子文件夹
					// $files[$file] = my_dir($dir . "/" . $file);
					$_dir = $dir . "/" . $file;
					// 自动加载route
					if (file_exists($_dir . '/route.php')) {
						$file_route = include_once $_dir . '/route.php';
						if (is_array($file_route)) {
							$_route = array_merge($_route, $file_route);
						}
					}
				}
			}
		}
		closedir($handle);
	}
	
	return $_route;
}

$route = route_lib(LIB_PATH);
if (is_array($route)) {
	$result = array_merge($result, $route);
}

// $filename = COM_PATH . 'route.php';
//
// if (!is_dir($filename) && file_exists($filename)) {
// 	$result_com = include_once $filename;
// 	if (is_array($result_com)) {
// 		$result = array_merge($result, $result_com);
// 	}
// }


// $addonListByDb = MiniappAddon::field('addon')->where('status', 1)->select();
//
// if (!empty($addonListByDb)) {
// 	foreach ($addonListByDb as $row) {
// 		$pathname = MINIAPP_PATH . $row['addon'];
// 		$filename = $pathname . DS . 'route.php';
// 		if (is_dir($pathname) && file_exists($filename)) {
// 			$_re = include_once $filename;
// 			!empty($_re) && is_array($_re) && $result = array_merge($result, $_re);
// 		}
// 	}
// }
//

$result = array_merge($result, [

]);

return $result;
