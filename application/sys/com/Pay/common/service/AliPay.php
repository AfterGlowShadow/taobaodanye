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

class AliPay {
	protected $config = [];

	public function __construct() {
		$this->config = app_config('pay.alipay');
	}
	
	public function pay($param = []) {
		// $order = [
		// 	'out_trade_no' => time(),
		// 	'total_amount' => '1',
		// 	'subject' => 'test subject - 测试',
		// ];
		
		// $alipay = Pay::alipay($this->config)->web($order);
		
		$order = [
   			'out_trade_no' => $param['out_trade_no'],
			'total_amount' => $param['total_amount'],
			'subject' => $param['subject'],
		];
		
		$terminal_type = defi($param, 'terminal_type', 0);
		
		switch ($terminal_type) {
			case 'web':
				$alipay = Pay::alipay($this->config)->web($order);
				break;
			case 'wap':
				$alipay = Pay::alipay($this->config)->wap($order);
				break;
			case 'app':
				$alipay = Pay::alipay($this->config)->app($order);
				break;
		}
		
		//$alipay = Pay::alipay($this->config)->web($order);
		
		//return $alipay->send();// laravel 框架中请直接 `return $alipay`
		return $alipay;
	}
	
	public function refund($param = []) {
		$order = [
			'out_trade_no' => $param['out_trade_no'],
			'refund_amount' => $param['refund_total'],
		];
		
		$result = Pay::alipay($this->config)->refund($order);
		
		return $result;
	}
	
	public function return_callback() {
		$data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！
		
		// 订单号：$data->out_trade_no
		// 支付宝交易号：$data->trade_no
		// 订单总金额：$data->total_amount
	}
	
	public function notify_callback() {
		Log::record('### ali_notify_callback start');
		$alipay = Pay::alipay($this->config);
		
		try{
			$data = $alipay->verify(); // 是的，验签就这么简单！
			
			// 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
			// 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
			// 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
			// 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
			// 4、验证app_id是否为该商户本身。
			// 5、其它业务逻辑情况
			
			logfile(json_encode_u($data->all()));
			Log::debug('Alipay notify' . json_encode_u($data->all()));
			
			switch ($data->trade_status) {
				case 'TRADE_SUCCESS':
				case 'TRADE_FINISHED':
					// 支付完成处理支付单
					$value = [];
					$value['param'] = $data->all();
					$value['out_trade_no'] = $data->out_trade_no;
					$value['money'] = $data->total_amount;
					$value['type'] = 'pay_notify';
					$value['pay_type'] = 'ali';
					$value['status_success'] = in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED']); // 支付中
					$value['trade_success'] = $data->trade_status;
					$re = Event::t('payNotify', $value);
					if (isErr($re)) {
						logfile(json_encode_u($re));
						Log::error('Alipay notify err' . json_encode_u($re));
						return $re;
					}
					
					$alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
					break;
				case 'TRADE_CLOSED':
					// 退款交易关闭
					$value = [];
					$value['param'] = $data->all();
					$value['out_trade_no'] = $data->out_trade_no;
					$value['money'] = $data->total_amount;
					$value['type'] = 'refund_notify';
					$value['pay_type'] = 'ali';
					$value['status_success'] = in_array($data->trade_status, ['TRADE_CLOSED']);
					$value['trade_success'] = $data->trade_status;
					$re = Event::t('refundNotify', $value);
					if (isErr($re)) {
						logfile(json_encode_u($re));
						Log::error('Alipay notify err' . json_encode_u($re));
						return $re;
					}
					
					$alipay->success()->send();
					break;
			}
			
			return rsOk();
		} catch (\Exception $e) {
			// $e->getMessage();
			logerr($e->getMessage());
			return rsErr($e->getMessage());
		}
	}
}
