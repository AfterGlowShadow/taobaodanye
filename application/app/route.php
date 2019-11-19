<?php

/**
 * 公共组件库com
 * com/组件名/小程序/版本/控制器/方法
 * com/goods/api/v1/group/list
 *
 * https://wx.uujia.net/com/test/api/v1/test/index
 */
/*Route::rule('/com<_mid?>/:component/:_type/:ver/:col/:act', '\\app\\sys\\RouteCall@run')*/
// 	->middleware('Param');

// https://wx.uujia.net/com/api/test.v1.test.index

Route::rule('/app[:_com]/:_type/:component[:ver].:col.:act', '\\app\\app\\RouteCall@run')
	->pattern(
		[
			'_com' => '_\w+',
			'_type' => '(admin|api)',
			'ver' => '.v\d+',
		])
	->middleware('Param');

// function init_app_route($dir) {
// 	$files = [];
// 	if (@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
// 		while (($file = readdir($handle)) !== false) {
// 			if ($file != ".." && $file != ".") { //排除根目录；
// 				if (is_dir($dir . "/" . $file)) {
// 					// $files[$file] = my_dir($dir . "/" . $file);//如果是子文件夹，就进行递归
// 					$_dir = $dir . "/" . $file;
// 					// 自动加载route
// 					if (file_exists($_dir . '/route.php')) {
// 						include_once $_dir . '/route.php';
// 					}
// 				}
// 			}
// 		}
// 		closedir($handle);
// 	}
// }
cache('jtdd', '122');
function init_app_route($dir) {
	cache('jtdd', 'init_app_route');
	$_dir = $dir . "/" . APP_TAG;
	// 自动加载route
	if (file_exists($_dir . '/route.php')) {
		include_once $_dir . '/route.php';
	}
}

init_app_route(LIB_APP_PATH);

return [

];