<?php

namespace app\sys\com\Pay\event;

use app\sys\com\Pay\common\model\Payment;

class Event extends \app\sys\com\base\event\Event {
	public static $_EVENT_NAME = [
		'getOrderInfo' => 'get_order_info',
		'checkOrderOnPay' => 'check_order_on_pay',
		'setOrderStatus' => 'set_order_status',
		'payNotify' => 'pay_notify',
		'refundNotify' => 'refund_notify',
		'ping' => 'ping',
	];
	
	public static function checkComponent($e = []) {
		//$addonParam = isset($e['addonParam']) ? $e['addonParam'] : [];
		// return (isset($addonParam['component']) && isset($addonParam['type']) &&
		//     $addonParam['component'] == 'xx' && $addonParam['type'] == 'mp');
		return true;
	}
	
	public static function run() {
		$name = 'ping';
		static::on($name, function ($e, \Closure $next) {
			echo __NAMESPACE__ . '<br />';
			$next();
			return rsOk();
		});
		
		$name = 'payNotify';
		static::on($name, function ($e, \Closure $next) use ($name) {
			if (!self::checkComponent($e)) {
				return $next();
			}
		
			$paymentM = new Payment();
			return $paymentM->pay_notify($e);
		});
		
		$name = 'refundNotify';
		static::on($name, function ($e, \Closure $next) use ($name) {
			if (!self::checkComponent($e)) {
				return $next();
			}
			
			$paymentM = new Payment();
			return $paymentM->pay_notify($e);
		});
	}
}

Event::run();