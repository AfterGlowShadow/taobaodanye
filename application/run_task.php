<?php

use app\sys\com\EventMgr\common\v1\facade\Event;
use think\facade\Cache;

if (defined('RUN_TASK_LOAD')) {
	return false;
}

define('RUN_TASK_LOAD', 1);
define('RUN_TASK_INTERVAL_0', 0);
define('RUN_TASK_INTERVAL_10S', 10);
define('RUN_TASK_INTERVAL_30S', 30);
define('RUN_TASK_INTERVAL_1M', 60);

// 实时任务 每次入口都要先执行
function run_task_now() {
	$_t = RUN_TASK_INTERVAL_0;
	
	$value = [];
	$value['interval'] = $_t;
	$value['addonParam'] = sessionOrGLOBALS('addonParam');
	
	$re = Event::t('run_task', $value);
}

// 10秒执行一次
function run_task_10s() {
	$_t = RUN_TASK_INTERVAL_10S;
	$lastTime = Cache::tag('task')->get("{$_t}s");
	if (!empty($lastTime) && time() - $lastTime < $_t) {
		return;
	}
	
	Cache::tag('task')->set("{$_t}s", time());
	
	$value = [];
	$value['interval'] = $_t;
	$value['addonParam'] = sessionOrGLOBALS('addonParam');
	
	$re = Event::t('run_task', $value);
}

// 30秒执行一次
function run_task_30s() {
	$_t = RUN_TASK_INTERVAL_30S;
	$lastTime = Cache::tag('task')->get("{$_t}s");
	if (!empty($lastTime) && time() - $lastTime < $_t) {
		return;
	}
	
	Cache::tag('task')->set("{$_t}s", time());
	
	$value = [];
	$value['interval'] = $_t;
	$value['addonParam'] = sessionOrGLOBALS('addonParam');
	
	$re = Event::t('run_task', $value);
}

// 1分执行一次
function run_task_1m() {
	$_t = RUN_TASK_INTERVAL_1M;
	$lastTime = Cache::tag('task')->get("{$_t}s");
	if (!empty($lastTime) && time() - $lastTime < $_t) {
		return;
	}
	
	Cache::tag('task')->set("{$_t}s", time());
	
	$value = [];
	$value['interval'] = $_t;
	$value['addonParam'] = sessionOrGLOBALS('addonParam');
	
	$re = Event::t('run_task', $value);
}

// 实时
run_task_now();
// 10s
run_task_10s();
// 30s
run_task_30s();
// 1m
run_task_1m();

