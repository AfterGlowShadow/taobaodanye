<?php

namespace app\sys\com\User\event;

class Event extends \app\sys\com\base\event\Event {
	public static $_EVENT_NAME = [
		'checkLogin' => 'check_login',
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
		
		$name = 'checkLogin';
		static::on($name, function ($e, \Closure $next) use ($name) {
			if (!self::checkComponent($e)) {
				return $next();
			}
			
			$userLogic = new \app\sys\com\User\common\logic\User();
			return $userLogic->checkLogin($e);
		});
	}
}

Event::run();