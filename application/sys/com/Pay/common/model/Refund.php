<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Pay\common\model;


use app\sys\com\Pay\common\service\AliPay;
use app\sys\com\Pay\common\service\WxPay;
use app\sys\com\Pay\event\Event;

class Refund extends \app\sys\com\Pay\common\model\table\Refund {
	
	public static $_PAY_TYPE = [
		'none' => 0,    // 未知
		'ali'  => 1,    // 支付宝
		'wx'   => 2,    // 微信
		'card' => 3,    // 银行卡
	];
	
	public static $_STATUS = [
		'none'          => 0,
		'paying'        => 1,
		'pay_ok'        => 2,
		'pay_err'       => 3,
		'pay_cancel'    => 4,
		'refunding'     => 5,
		'refund_ok'     => 6,
		'refund_err'    => 7,
		'refund_cancel' => 8,
	];
	
	/**
	 * 退款
	 *
	 * @param $param
	 * @param $out_trade_no
	 * @param $money
	 * @param $reason
	 * @return array|mixed|\Services_JSON_Error|string|\Yansongda\Supports\Collection
	 */
	public function refund($param, $out_trade_no, $money, $reason = '') {
		// 校验支付订单（支付单是否存在 金额是否超额）
		$paymentM = new Payment();
		$re = $paymentM->checkOutTradeNoOnRefund($out_trade_no, $money);
		if (isErr($re)) {
			return $re;
		}
		
		$rePayment = gData($re);
		$order_number = $rePayment['order_number'];
		$pay_type = $rePayment['pay_type'];
		$tag = $rePayment['tag'];
		$paymentId = $rePayment['id'];
		$order_type = $rePayment['order_type'];
		
		// $refund_no_admin_audit = app_config('pay.refund_no_admin_audit');
		
		// 先将之前的正在退款中的退款单更改状态为取消
		$_w = [];
		$_w[] = ['order_number', '=', $order_number];
		$_w[] = ['status', '=', self::$_STATUS['refunding']];
		$_d = [];
		$_d['status'] = self::$_STATUS['refund_cancel'];
		$re = $this->editByWhere($_w, $_d, false);
		if (isErr($re)) {
			return $re;
		}
		
		// 更改订单状态为退款中
		$value = [];
		//$value['addonParam'] = $this->_addon_param;//$addonParam;
		$value['paymentModel'] = $this;
		$value['param'] = $param;
		$value['order_number'] = $order_number;
		$value['type'] = 'refund';
		$value['status'] = 'refunding'; // 退款中
		$value['tag'] = $tag;
		$value['status_success'] = 1;
		$value['order_type'] = $order_type;
		$re = Event::t('setOrderStatus', $value);
		if (isErr($re)) {
			return $re;
		}
		
		// 写入退款数据
		$_d                 = [];
		$_d['order_number'] = $order_number;
		$_d['out_trade_no'] = $out_trade_no;
		$_d['money']        = $money;
		$_d['pay_type']     = $pay_type;
		$_d['reason']       = $reason;
		$_d['status']       = self::$_STATUS['refunding'];
		$_d['remark']       = '';
		$_d['tag']          = $tag;
		$_d['attach']       = '{}';
		$_d['notify_info']  = '';
		$_d['order_type']   = $order_type;
		
		switch ($pay_type) {
			case self::$_PAY_TYPE['ali']:
				// nothing
				break;
			case self::$_PAY_TYPE['wx']:
				$_d['openid'] = $rePayment['openid'];
				break;
			case self::$_PAY_TYPE['card']:
				
				break;
		}
		
		$re = $this->add($_d);
		if (isErr($re)) {
			return $re;
		}
		
		$reRefund = gData($re);
		$id       = $reRefund['id'];
		
		// 调用退款服务
		switch ($pay_type) {
			case self::$_PAY_TYPE['ali']:
				$aliPayService       = new AliPay();
				$_p                  = [];
				$_p['out_trade_no']  = $_d['out_trade_no'];
				// $_p['refund_amount'] = $_d['money'];
				$_p['refund_total']  = $_d['money'];
				$re                  = $aliPayService->refund($_p);
				log_record('### refund=' . json_encode_u($re));
				if ($re['code'] != 10000) {
					// 更改订单状态为退款中
					$value = [];
					//$value['addonParam'] = $this->_addon_param;//$addonParam;
					$value['paymentModel'] = $this;
					$value['param'] = $param;
					$value['order_number'] = $order_number;
					$value['type'] = 'refund';
					$value['status'] = 'refund_error'; // 退款中
					$value['status_success'] = 1;
					$value['tag'] = $tag;
					$value['order_type'] = $order_type;
					$re = Event::t('setOrderStatus', $value);
					if (isErr($re)) {
						return $re;
					}
					
					return rsErr('退款失败');
				}
				
				if ($re['out_trade_no'] != $_d['out_trade_no']) {
					return rsErr('外部订单号不匹配 退款失败');
				}
				
				// 更改退款单状态
				$_d = [];
				$_d['status'] = self::$_STATUS['refund_ok'];
				$_d['refund_time'] = time();
				$re = $this->editById($paymentId, $_d);
				if (isErr($re)) {
					return $re;
				}
				
				// 更改支付单为退款成功
				$_d = [];
				$_d['status'] = Payment::$_STATUS['refund_ok'];
				$_d['refund_time'] = time();
				$re = $paymentM->editById($paymentId, $_d);
				if (isErr($re)) {
					return $re;
				}
				
				// 更改订单状态为退款成功
				$value = [];
				//$value['addonParam'] = $this->_addon_param;//$addonParam;
				$value['paymentModel'] = $this;
				$value['param'] = $param;
				$value['order_number'] = $order_number;
				$value['type'] = 'refund';
				$value['status'] = 'refunded'; // 退款中
				$value['status_success'] = 1;
				$value['tag'] = $tag;
				$value['order_type'] = $order_type;
				$re = Event::t('setOrderStatus', $value);
				if (isErr($re)) {
					return $re;
				}
				
				return rsOk();
				break;
			case self::$_PAY_TYPE['wx']:
				$wxPayService       = new WxPay();
				$_p                  = [];
				$_p['out_trade_no']  = $_d['out_trade_no'];
				// $_p['refund_amount'] = $_d['money'];
				$_p['refund_total']  = $_d['money'];
				$re                  = $wxPayService->refund($_p);
				log_record('### refund=' . json_encode_u($re));
				if ($re['return_code'] != 'SUCCESS') {
					// 更改订单状态为退款中
					$value = [];
					//$value['addonParam'] = $this->_addon_param;//$addonParam;
					$value['paymentModel'] = $this;
					$value['param'] = $param;
					$value['order_number'] = $order_number;
					$value['type'] = 'refund';
					$value['status'] = 'refund_error'; // 退款中
					$value['status_success'] = 1;
					$value['tag'] = $tag;
					$value['order_type'] = $order_type;
					$re = Event::t('setOrderStatus', $value);
					if (isErr($re)) {
						return $re;
					}
					
					return rsErr('退款失败');
				}
				
				if ($re['out_trade_no'] != $_d['out_trade_no']) {
					return rsErr('外部订单号不匹配 退款失败');
				}
				
				// 更改退款单状态
				$_d = [];
				$_d['status'] = self::$_STATUS['refund_ok'];
				$_d['refund_time'] = time();
				$re = $this->editById($paymentId, $_d);
				if (isErr($re)) {
					return $re;
				}
				
				// 更改支付单为退款成功
				$_d = [];
				$_d['status'] = Payment::$_STATUS['refund_ok'];
				$_d['refund_time'] = time();
				$re = $paymentM->editById($paymentId, $_d);
				if (isErr($re)) {
					return $re;
				}
				
				// 更改订单状态为退款成功
				$value = [];
				//$value['addonParam'] = $this->_addon_param;//$addonParam;
				$value['paymentModel'] = $this;
				$value['param'] = $param;
				$value['order_number'] = $order_number;
				$value['type'] = 'refund';
				$value['status'] = 'refunded'; // 退款中
				$value['status_success'] = 1;
				$value['tag'] = $tag;
				$value['order_type'] = $order_type;
				$re = Event::t('setOrderStatus', $value);
				if (isErr($re)) {
					return $re;
				}
				
				return rsOk();
				break;
			case self::$_PAY_TYPE['card']:
				
				break;
		}
		
		// todo: 根据退款结果成功或失败更新状态
		
		return rsErr('退款失败');
	}
	
	/**
	 * 退款回调
	 *
	 * @param array $param
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function refund_notify($param) {
		$return_param = $param['param'];
		$out_trade_no = $param['out_trade_no'];
		$money = $param['money'];
		$type = $param['type'];
		$payType = $param['pay_type'];
		$status_success = $param['status_success'];
		$orderType = $param['order_type'];
		
		// 校验支付单号是否存在 状态是否正确
		$paymentM = new Payment();
		$re = $paymentM->checkOutTradeNoOnRefundClose($out_trade_no, $money);
		if (isErr($re)) {
			return $re;
		}
		
		$rePayment = gData($re);
		$id = $rePayment['id'];
		$order_number = $rePayment['order_number'];
		$tag = $rePayment['tag'];
		
		// 写入回调信息到库 更改状态
		$_d = [];
		$_d['notify_info'] = json_encode_u($return_param);
		
		if ($status_success) {
			$_d['status'] = self::$_STATUS['refund_ok'];
			$_d['refund_time'] = time();
		} else {
			$_d['status'] = self::$_STATUS['refund_err'];
		}
		
		// todo: 写入支付日志
		
		
		// 更改状态写入支付表
		$re = $this->editById($id, $_d);
		if (isErr($re)) {
			return $re;
		}
		
		// 写订单表状态
		$value = [];
		$value['paymentModel'] = $this;
		$value['param'] = $param;
		$value['order_number'] = $order_number;
		$value['type'] = 'refund_notify';
		$value['pay_type'] = $payType;
		$value['status_success'] = $status_success; // 是否成功
		$value['status'] = $status_success ? 'refund_ok' : 'refund_err'; // 状态成功或失败
		$value['tag'] = $tag;
		$value['order_type'] = $orderType;
		$re = Event::t('setOrderStatus', $value);
		if (isErr($re)) {
			return $re;
		}
		
		return $re;
	}
	
}
