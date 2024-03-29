<?php


namespace app\sys\com\base\common\v1\traits;


trait InstanceBase{
	/**
	 * 实例对象
	 */
	protected static $instance;
	
	// protected function __clone() {
	// }
	
	/**
	 * 单例模式获取实例
	 */
	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static;
		}
		return static::$instance;
	}
}