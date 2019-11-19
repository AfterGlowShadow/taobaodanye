<?php

if(file_exists(LIB_PATH . 'common.php')) {
	include_once 'common.php';
}

function init_lib($dir) {
	$files = [];
	if (@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
		while (($file = readdir($handle)) !== false) {
			if ($file != ".." && $file != ".") { //排除根目录；
				if (is_dir($dir . "/" . $file)) { //如果是子文件夹，就进行递归
					// $files[$file] = my_dir($dir . "/" . $file);
					$_dir = $dir . "/" . $file;
					// 自动加载common
					if(file_exists($_dir .'/init.php')){
						include_once $_dir .'/init.php';
					}
					
					// 自动加载事件event
					if(file_exists($_dir .'/event/Event.php')){
						require_once $_dir .'/event/Event.php';
					}
				}
			}
		}
		closedir($handle);
	}
}

// function init_autoload($classname) {
// 	echo $classname." not be found!";
// }

// spl_autoload_register('init_autoload');

init_lib(APP_PATH);