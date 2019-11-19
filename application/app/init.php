<?php

use think\Env;

function init_app_com_component($dir) {
	$files = [];
	if (@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
		while (($file = readdir($handle)) !== false) {
			if ($file != ".." && $file != ".") { //排除根目录；
				if (is_dir($dir . "/" . $file)) {
					// $files[$file] = my_dir($dir . "/" . $file);//如果是子文件夹，就进行递归
					$_dir = $dir . "/" . $file;
					// 自动加载common
					if (file_exists($_dir . '/common.php')) {
						include_once $_dir . '/common.php';
					}
					
					// 自动加载事件event
					if (file_exists($_dir . '/event/Event.php')) {
						include_once $_dir . '/event/Event.php';
					}
				}
			}
		}
		closedir($handle);
	}
}

function init_app_com($dir) {
	$files = [];
	if (@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
		// while (($file = readdir($handle)) !== false) {
			$file = APP_TAG;
			if ($file != ".." && $file != ".") { //排除根目录；
				if (is_dir($dir . "/" . $file)) {
					// $files[$file] = my_dir($dir . "/" . $file);//如果是子文件夹，就进行递归
					$_dir = $dir . "/" . $file;
					// 自动加载common
					init_app_com_component($_dir);
				}
			}
		// }
		closedir($handle);
	}
}

function init_app_autoload($classname) {
	$classpath = ROOT_PATH . "{$classname}.php";
	$classpath_com = LIB_APP_PATH . "{$classname}.php";
	if (file_exists($classpath)) {
		require_once(str_replace('\\', '/', $classpath));
	} elseif (file_exists($classpath)) {
		require_once(str_replace('\\', '/', $classpath_com));
	}
}

spl_autoload_register('init_app_autoload');

init_app_com(LIB_PATH . 'app/');