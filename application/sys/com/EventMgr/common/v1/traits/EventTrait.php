<?php

namespace app\sys\com\EventMgr\common\v1\traits;

trait EventTrait {
	/**
	 * 事件列表
	 */
	//protected static $_events = [];
	
	public function _init() {
		$GLOBALS['event'] = [];
	}
	
	/**
	 * 注册事件
	 * @param string $event    事件名称
	 * @param mixed  $callback 回调
	 * @param bool   $top      是否添加到前列
	 * @param bool   $once     是否只执行一次
	 * @return EventTrait
	 */
	public function register($event, $callback, $top = false, $once = false) {
		if (!isset($GLOBALS['event'][$event])) {
			$GLOBALS['event'][$event] = [];
		}
		$item = [
			'callback' => $callback,
			'once'     => $once,
		];
		if ($top) {
			array_unshift($GLOBALS['event'][$event], $item);
		} else {
			$GLOBALS['event'][$event][] = $item;
		}
		
		return $this;
	}
	
	/**
	 * 注册事件(监听)
	 * @param string $event    事件名称
	 * @param mixed  $callback 回调
	 * @param bool   $top
	 * @return EventTrait
	 */
	public function on($event, $callback, $top = false) {
		return $this->register($event, $callback, $top);
	}
	
	/**
	 * 注册一次性事件(监听)
	 * @param string  $event    事件名称
	 * @param mixed   $callback 回调
	 * @param boolean $top      是否添加到前列
	 * @return EventTrait
	 */
	public function once($event, $callback, $top = false) {
		return $this->register($event, $callback, $top, true);
	}
	
	protected function doNext($event, $params = []) {
		$arr = next($GLOBALS['event'][$event]);
		if ($arr === false) {
			// 末尾超出默认返回空值
			//return rsErr('返回空值');
			return rsData(['event_eof' => 1]);
		}
		
		$re = call_user_func_array($arr['callback'], [$params, function () use ($event, $params) {
			return $this->doNext($event, $params);
		}]);
		
		if ($arr['once']) {
			unset($GLOBALS['event'][$event][key($GLOBALS['event'][$event])]);
		}
		
		return !empty($re) ? $re : rsErr('返回空值');
	}
	
	/**
	 * 触发事件
	 *
	 * @param string $event      事件名称
	 * @param array  $params     参数
	 * @param bool   $ignore_err 忽略错误
	 * @param bool   $ignore_result 忽略返回值
	 * @return mixed
	 */
	protected function trigger($event, $params = []) {
		// if (isset($GLOBALS['event'][$event])) {
		// 	foreach ($GLOBALS['event'][$event] as $key => $item) {
		// 		if ($item['once']) {
		// 			unset($GLOBALS['event'][$event][$key]);
		// 		}
		// 		$re = call_user_func_array($item['callback'], [$params]);
		// 		if (!$ignore_err && isErr($re)) {
		// 			// 事件返回失败时不继续执行其余事件
		// 			return !empty($re) ? $re : rsErr('返回空值');
		// 		}
		//
		// 		$reData = gData($re);
		// 		if (!$ignore_result && !empty($reData)) {
		// 			// 有返回值 不继续执行
		// 			return $re;
		// 		}
		// 	}
		// }
		// return rsOk();
		
		if (empty($GLOBALS['event'][$event])) {
			return rsErrCode(10014); // 未找到事件订阅者
		}
		
		$arr = reset($GLOBALS['event'][$event]);
		$re = call_user_func_array($arr['callback'],
		                           [$params, function () use ($event, $params) {
			                           return $this->doNext($event, $params);
		                           }]);
		
		return !empty($re) ? $re : rsErr('返回空值');
	}
	
	public function t($event, $params = []) {
		return $this->trigger($event, $params);
	}
}