<?php

namespace app\sys\com\base\event;

use app\sys\com\EventMgr\common\v1\logic\EventCommon;

class Event {
	public static $_EVENT_NAME = [
		'checkLogin' => 'check_login',
		'checkLoginAdmin' => 'check_login_admin',
		'ping' => 'ping',
	];
	
	/**
	 * 实例对象
	 * @var Event
	 */
	protected static $instance;
	
	protected function __construct() {
	}
	
	protected function __clone() {
	}
	
	/**
	 * 单例模式获取实例
	 * @return Event
	 */
	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static;
		}
		return static::$instance;
	}
	
	public static function t($name, $params = []) {
		return \app\sys\com\EventMgr\common\v1\facade\Event::t(static::$_EVENT_NAME[$name], $params);
		//$event = EventCommon::getInstance();
		//return $event->t(static::$_EVENT_NAME[$name], $params, $ignore_err);
	}
	
	public static function on($name, $callback, $top = false) {
		return \app\sys\com\EventMgr\common\v1\facade\Event::on(static::$_EVENT_NAME[$name], $callback, $top);
		//$event = EventCommon::getInstance();
		//return $event->on(static::$_EVENT_NAME[$name], $callback, $top);
	}
	
	public static function run() {
		$name = 'ping';
		static::on($name, function ($e, \Closure $next) {
			echo __NAMESPACE__ . '<br />';
			$next();
			return rsOk();
		});
		
		// static::on('checkLogin', function ($e, \Closure $next) {
		// 	// 检查登录
		// 	// todo: checkLogin
		//
		// });
		
		
	}
}

Event::run();