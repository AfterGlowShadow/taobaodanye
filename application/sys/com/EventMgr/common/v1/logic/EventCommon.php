<?php

namespace app\sys\com\EventMgr\common\v1\logic;

use app\sys\com\EventMgr\common\v1\traits\EventTrait;

class EventCommon {
	use EventTrait;
	
	/**
	 * 实例对象
	 * @var EventCommon
	 */
	private static $instance;
	
	public function __construct() {
		$this->_init();
	}
	
	/**
	 * 单例模式获取实例
	 * @return EventCommon
	 */
	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static;
		}
		return static::$instance;
	}
	
	protected function __clone() {
	}
}