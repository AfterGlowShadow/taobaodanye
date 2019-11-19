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

class Payment extends \app\sys\com\Pay\common\model\table\Payment {
	
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
		'close'         => 9,
	];
	
	public static $_ORDER_TYPE = [
		'normal' => 0,
	];

	public function _init() {
		parent::_init();
		
		
	}
	
	/**
	 * 根据订单号查找支付单
	 * @param $order_number
	 * @return array
	 */
	public function findOfOrderNumber($order_number) {
		$_w = [];
		$_w[] = ['order_number', '=', $order_number];
		$_w[] = ['status', '=', self::$_STATUS['pay_ok']];
		
		$param = [
			'order' => ['id' => 'DESC']
		];
		$re = $this->getItem($_w, '*', false, [], $param);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		if (empty($reData)) {
			return rsErrCode(13005); // 找不到支付单
		}
		
		return rsData($reData);
	}
	
	/**
	 * 校验支付单号（支付回调时校验）
	 * （支付单是否存在 状态是否为支付中 金额是否一致）
	 *
	 * @param $out_trade_no
	 * @param $money
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function checkOutTradeNoOnPayNotify($out_trade_no, $money) {
		$_w = [];
		$_w[] = ['out_trade_no', '=', $out_trade_no];
		$re = $this->getItem($_w);
		if (isErr($re)) {
			return $re;
		}
		
		$rePayment = gData($re);
		
		if (empty($rePayment)) {
			return rsErr('支付订单号无效', 10010);
		}
		
		if (!in_array($rePayment['status'], [self::$_STATUS['paying']])) {
			return rsErr('支付单状态不正确', 10011);
		}
		
		if ($rePayment['money'] != $money) {
			return rsErr('金额不符', 10011);
		}
		
		return rsData($rePayment);
	}
	
	/**
	 * 校验支付单号（退款时校验）
	 * （支付单是否存在 状态是否为支付完成 金额是否超）
	 *
	 * @param $out_trade_no
	 * @param $money
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function checkOutTradeNoOnRefund($out_trade_no, $money) {
		$_w = [];
		$_w[] = ['out_trade_no', '=', $out_trade_no];
		$re = $this->getItem($_w);
		if (isErr($re)) {
			return $re;
		}
		
		$rePayment = gData($re);
		
		if (empty($rePayment)) {
			return rsErr('支付订单号无效', 10010);
		}
		
		if (!in_array($rePayment['status'], [self::$_STATUS['pay_ok']])) {
			return rsErr('支付单状态不正确！', 10011);
		}
		
		if ($rePayment['money'] < $money) {
			return rsErr('金额超额', 10011);
		}
		
		return rsData($rePayment);
	}
	
	/**
	 * 校验支付单号（退款关闭校验）
	 * （支付单是否存在 状态是否为支付完成 金额是否超 退款已完成 关闭订单）
	 *
	 * @param $out_trade_no
	 * @param $money
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function checkOutTradeNoOnRefundClose($out_trade_no, $money) {
		$_w = [];
		$_w[] = ['out_trade_no', '=', $out_trade_no];
		$re = $this->getItem($_w);
		if (isErr($re)) {
			return $re;
		}
		
		$rePayment = gData($re);
		
		if (empty($rePayment)) {
			return rsErr('支付订单号无效', 10010);
		}
		
		if (!in_array($rePayment['status'], [self::$_STATUS['refund_ok']])) {
			return rsErr('支付单状态不正确！', 10011);
		}
		
		if ($rePayment['money'] < $money) {
			return rsErr('金额超额', 10011);
		}
		
		return rsData($rePayment);
	}
	
	/**
	 * 支付
	 *
	 * @param        $param
	 * @param        $title
	 * @param        $order_number
	 * @param        $money
	 * @param        $pay_type
	 * @param string $terminal_type
	 * @param int    $order_type
	 * @return AliPay|array
	 */
	public function pay($param, $title, $order_number, $money, $pay_type, $terminal_type = 'web', $order_type = 0) {
		// 获取校验订单（订单是否存在 状态是否为待支付 金额是否一致）
		$value = [];
		$value['paymentModel'] = $this;
		$value['param'] = $param;
		$value['order_number'] = $order_number;
		$value['money'] = $money;
		$value['type'] = 'pay';
		$value['order_type'] = $order_type;
		$value['tag'] = APP_TAG;
		$re = Event::t('checkOrderOnPay', $value);
		if (isErr($re)) {
			return $re;
		}
		
		$reOrder = gData($re);
		
		// 先将之前的正在支付中的支付单更改状态为取消
		$_w = [];
		$_w[] = ['order_number', '=', $order_number];
		$_w[] = ['status', '=', self::$_STATUS['paying']];
		$_d = [];
		$_d['status'] = self::$_STATUS['pay_cancel'];
		$re = $this->editByWhere($_w, $_d, false);
		if (isErr($re)) {
			return $re;
		}
		
		// 更改订单状态为支付中
		// $value = [];
		// $value['addonParam'] = $this->_addon_param; // $addonParam;
		// $value['paymentModel'] = $this;
		// $value['param'] = $param;
		// $value['order_number'] = $order_number;
		// $value['type'] = 'pay';
		// $value['status'] = 'paying'; // 支付中
		// $re = Event::t('setOrderStatus', $value);
		// if (isErr($re)) {
		// 	return return_json($re);
		// }
		
		// 写入支付数据
		$_d = [];
		$_d['title'] = $title;
		$_d['order_number'] = $order_number;
		$_d['out_trade_no'] = createOrderId_pay();
		$_d['money'] = $money;
		$_d['pay_type'] = $pay_type;
		$_d['status'] = self::$_STATUS['paying'];
		$_d['remark'] = '';
		$_d['tag'] = APP_TAG;
		$_d['attach'] = '{}';
		$_d['notify_info'] = '';
		$_d['order_type'] = $order_type;
		
		switch ($pay_type) {
			case self::$_PAY_TYPE['ali']:
				// nothing
				break;
			case self::$_PAY_TYPE['wx']:
				// if (!isset($param['openid'])) {
				// 	return rsErrCode(10001); // 缺少参数
				// }
				//
				// $openid = $param['openid'];
				// $_d['openid'] = $openid;
				break;
			case self::$_PAY_TYPE['card']:
				
				break;
		}
		
		$re = $this->add($_d);
		if (isErr($re)) {
			return $re;
		}
		
		$rePayment = gData($re);
		$id = $rePayment['id'];
		
		// 调用支付服务
		switch ($pay_type) {
			case self::$_PAY_TYPE['ali']:
				$aliPayService = new AliPay();
				$_p = [];
				$_p['out_trade_no'] = $_d['out_trade_no'];
				$_p['total_amount'] = $_d['money'];
				$_p['subject'] = $_d['title'];
				$_p['terminal_type'] = $terminal_type;
				$re = $aliPayService->pay($_p);
				if ($re->getStatusCode() != 200) {
					return rsErr('支付失败');
				}
				
				$result = [
					'data' => $re->getContent(),
				];
				
				return rsData($result);
				break;
			case self::$_PAY_TYPE['wx']:
				$wxPayService = new WxPay();
				$_p = [];
				$_p['out_trade_no'] = $_d['out_trade_no'];
				$_p['total_fee'] = $_d['money'];
				$_p['body'] = $_d['title'];
				$_p['terminal_type'] = $terminal_type;
				$re = $wxPayService->pay($_p);
				if ($re->getStatusCode() != 200) {
					return rsErr('支付失败');
				}
				
				$result = [
					'data' => $re->getContent(),
				];
				
				return rsData($result);
				break;
			case self::$_PAY_TYPE['card']:
				
				break;
		}
		
		return rsErr('支付失败');
	}
	
	/**
	 * 支付回调
	 *
	 * @param array $param
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function pay_notify($param) {
		log_record('pay_notify start');
		$return_param = $param['param'];
		$out_trade_no = $param['out_trade_no'];
		$money = $param['money'];
		$type = $param['type'];
		$payType = $param['pay_type'];
		$orderType = defi($param, 'order_type', self::$_ORDER_TYPE['normal']); // 订单类型（用来支持同项目多种不同类型订单）（0-默认）
		$status_success = $param['status_success'];
		
		// 查询解出将外部订单号换订单号
		// $_w = [];
		// $_w[] = ['out_trade_no', '=', $out_trade_no];
		// $re = $this->getItem($_w);
		// if (isErr($re)) {
		// 	log_record('查询外部订单号错误 ' . json_encode_u($re));
		// 	return $re;
		// }
		//
		// $rePaymentOrder = gData($re);
		// if (empty($rePaymentOrder)) {
		// 	log_record('查询外部订单号错误 找不到订单');
		// 	return rsErrCode(13001); // 找不到订单
		// }
		//
		// $order_number = $rePaymentOrder['order_number'];
		
		// 校验支付单号是否存在 状态是否正确
		$re = $this->checkOutTradeNoOnPayNotify($out_trade_no, $money);
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
			$_d['status'] = self::$_STATUS['pay_ok'];
			$_d['pay_time'] = time();
		} else {
			$_d['status'] = self::$_STATUS['pay_err'];
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
		$value['type'] = 'pay_notify';
		$value['pay_type'] = $payType;
		$value['status_success'] = $status_success; // 是否成功
		$value['status'] = $status_success ? 'pay_ok' : 'pay_err'; // 状态成功或失败
		$value['order_type'] = $orderType;
		$value['tag'] = $tag;
		$re = Event::t('setOrderStatus', $value);
		if (isErr($re)) {
			return $re;
		}
		
		return $re;
	}
	
}
