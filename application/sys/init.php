<?php

use think\Env;

function init_sys_com_component($dir) {
	$files = [];
	if (@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
		while (($file = readdir($handle)) !== false) {
			if ($file != ".." && $file != ".") { //排除根目录；
				if (is_dir($dir . "/" . $file)) { //如果是子文件夹，就进行递归
					// $files[$file] = my_dir($dir . "/" . $file);
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

function init_sys_com($dir) {
	$files = [];
	if (@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
		while (($file = readdir($handle)) !== false) {
			if ($file != ".." && $file != ".") { //排除根目录；
				if (is_dir($dir . "/" . $file)) { //如果是子文件夹，就进行递归
					// $files[$file] = my_dir($dir . "/" . $file);
					$_dir = $dir . "/" . $file;
					// 自动加载common
					init_sys_com_component($_dir);
				}
			}
		}
		closedir($handle);
	}
}

function init_sys_autoload($classname) {
	$classpath = ROOT_PATH . "{$classname}.php";
	$classpath_com = LIB_SYS_PATH . "{$classname}.php";
	if (file_exists($classpath)) {
		require_once(str_replace('\\', '/', $classpath));
	} elseif (file_exists($classpath)) {
		require_once(str_replace('\\', '/', $classpath_com));
	}
}

spl_autoload_register('init_sys_autoload');

init_sys_com(LIB_PATH . 'sys/');