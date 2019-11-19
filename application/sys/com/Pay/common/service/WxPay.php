<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Pay\common\service;


use app\sys\com\Pay\event\Event;
use think\facade\Log;
use Yansongda\Pay\Pay;

class WxPay {
	protected $config = [];

	public function __construct() {
		$this->config = app_config('pay.wxpay');
	}
	
	public function pay($param = []) {
		$order = [
   			'out_trade_no' => $param['out_trade_no'],
		    'total_fee' => $param['total_fee'] * 100, // **单位：分**
		    'body' => $param['body'],
		    // 'openid' => $param['openid'],
		];
		
		isset($param['openid']) && $order['openid'] = $param['openid'];
		
		$terminal_type = defi($param, 'terminal_type', 0);
		
		switch ($terminal_type) {
			case 'mp':
				$wxpay = Pay::wechat($this->config)->mp($order);
				break;
			case 'miniapp':
				$wxpay = Pay::wechat($this->config)->miniapp($order);
				break;
			case 'wap': // H5支付
				$wxpay = Pay::wechat($this->config)->wap($order);
				break;
			case 'app':
				$wxpay = Pay::wechat($this->config)->app($order);
				break;
		}
		
		// $pay->appId
		// $pay->timeStamp
		// $pay->nonceStr
		// $pay->package
		// $pay->signType
		return $wxpay;
	}
	
	public function refund($param = []) {
		$order = [
			'out_trade_no' => $param['out_trade_no'],
			'out_refund_no' => time(),
			'total_fee' => $param['refund_total'] * 100,
			'refund_fee' => $param['refund_total'] * 100,
			'refund_desc' => '退款',
		];
		
		$result = Pay::wechat($this->config)->refund($order);
		
		return $result;
	}
	
	public function return_callback() {
		$data = Pay::wechat($this->config)->verify(); // 是的，验签就这么简单！
		
		// 订单号：$data->out_trade_no
		// 支付宝交易号：$data->trade_no
		// 订单总金额：$data->total_amount
	}
	
	public function notify_callback() {
		log_record('wx notify_callback start');
		$pay = Pay::wechat($this->config);
		
		try{
			$data = $pay->verify(); // 是的，验签就这么简单！
			$re = $data->all();
			// $re = '{"appid":"wxe76fa26787c19834","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1560296211","nonce_str":"Byd8oCu86qe7wWjz","openid":"o37oX1X-OUbHLvf-NFVkLa9cNATA","out_trade_no":"20191025191913810355127420","result_code":"SUCCESS","return_code":"SUCCESS","sign":"EEAD0E7410C7C20934B354073B6D42B8","time_end":"20191025191919","total_fee":"1","trade_type":"APP","transaction_id":"4200000413201910250448135321"}';
			// $re = json_decode($re, true);
			logfile(json_encode_u($re));
			Log::debug('Wechat notify=' . json_encode_u($re));
			Log::debug('Wechat notify 1');
			
			// 支付完成处理支付单
			$value = [];
			$value['param'] = $re;
			$value['out_trade_no'] = $re['out_trade_no'];
			$value['money'] = bcdiv($re['total_fee'], 100, 2);
			$value['type'] = 'pay_notify';
			$value['pay_type'] = 'wx';
			$value['status_success'] = in_array($re['result_code'], ['SUCCESS']); // 支付中
			log_record('wx notify_callback 111');
			$re = Event::t('payNotify', $value);
			if (isErr($re)) {
				logfile(json_encode_u($re));
				Log::error('Wxpay notify err' . json_encode_u($re));
				return $re;
			}
			
			$pay->success()->send();// laravel 框架中请直接 `return $pay->success()`
			return rsOk();
		} catch (\Exception $e) {
			// $e->getMessage();
			Log::error('Wxpay notify err=' . $e->getMessage());
			logerr($e->getMessage());
			return rsErr($e->getMessage());
		}
	}
}
