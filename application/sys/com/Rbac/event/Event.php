<?php

namespace app\sys\com\Rbac\event;

use app\sys\com\Rbac\common\logic\Rbac;
use app\sys\com\Rbac\common\model\User;

class Event extends \app\sys\com\base\event\Event {
	public static $_EVENT_NAME = [
		'checkLoginAdmin' => 'check_login_admin',
		'ping' => 'ping',
	];
	
	public static function checkComponent($e = []) {
		$addonParam = isset($e['addonParam']) ? $e['addonParam'] : [];
		// return (isset($addonParam['component']) && isset($addonParam['type']) &&
		//     $addonParam['component'] == 'mao9' && $addonParam['type'] == 'mp');
		return true; // 后台本身就通用 其他插件也不需要拦截 这里不需要校验
	}
	
	public static function run() {
		$name = 'ping';
		static::on($name, function ($e, \Closure $next) {
			echo __NAMESPACE__ . '<br />';
			$next();
			return rsOk();
		});
		
		$name = 'checkLoginAdmin';
		static::on($name, function ($e, \Closure $next) use ($name) {
			if (!self::checkComponent($e)) {
				return $next();
			}
			
			$rbacModel = new Rbac();
			return $rbacModel->checkAuth($e);
		});
	}
}

Event::run();