<?php

namespace app\sys\com\Msg\event;

use app\sys\com\Msg\common\logic\Push;
use app\sys\com\Rbac\common\logic\Rbac;
use app\sys\com\Rbac\common\model\User;

class Event extends \app\sys\com\base\event\Event {
	public static $_EVENT_NAME = [
		'sendMsg' => 'send_msg',
		'sendMsgListData' => 'send_msg_list_data',
		'sendMsgItemData' => 'send_msg_item_data',
		'queueTask' => 'queue_task',
		'ping' => 'ping',
	];
	
	public static function checkComponent($e = []) {
		//$addonParam = isset($e['addonParam']) ? $e['addonParam'] : [];
		// return (isset($addonParam['component']) && isset($addonParam['type']) &&
		//     $addonParam['component'] == 'xxx' && $addonParam['type'] == 'mp');
		$taskMode = isset($e['taskMode']) ? $e['taskMode'] : [];
		return !empty($taskMode) && $taskMode == 'task_send_msg';
	}
	
	public static function run() {
		$name = 'ping';
		static::on($name, function ($e, \Closure $next) {
			echo __NAMESPACE__ . '<br />';
			$next();
			return rsOk();
		});
		
		$name = 'queueTask';
		static::on($name, function ($e, \Closure $next) use ($name) {
			if (!self::checkComponent($e)) {
				return $next();
			}
			
			// todo: 从队列取数据写库发推送
			//$id = $e['id'];
			$push = new Push();
			$re = $push->pushMessage($e);
			if (isErr($re)) {
				return $re;
			}
			
			return rsOk();
		});
	}
}

Event::run();