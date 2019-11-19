<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Pay\api\controller;

use app\sys\com\Pay\common\model\Payment;
use app\sys\com\Pay\common\service\AliPay;
use app\sys\com\Pay\common\service\WxPay;
use app\sys\com\Pay\event\Event;
use think\Db;
use think\facade\Request;

/**
 * Class Payments
 * 支付表
 * @api_name 支付记录
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Pay\api\controller
 */
class Payments extends \app\sys\com\Pay\api\controller\logic\Payments {

    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 支付
	 * 支付表
	 * @api_name 支付
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Pay.v1.Payments.pay
	 *
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function pay() {
		/** @var $m Payment */
		$m = $this->_model;
		$param = $this->param;
		
		$title = $this->p('title');
		$order_number = $this->p('order_number');
		$money = $this->p('money');
		$pay_type = $this->p('pay_type');
		$order_type = defi($param, 'order_type', Payment::$_ORDER_TYPE['normal']);
		
		$is_mobile = 0;
		
		if (!isset($param['terminal_type'])) {
			$terminal_type = Request::instance()->isMobile() ? 'wap' : 'web';
		} else {
			$terminal_type = $param['terminal_type'];
		}
		
		$re = $this->transaction(function () use ($m, $param, $title, $order_number, $money, $pay_type, $terminal_type, $order_type) {
			$re = $m->pay($param, $title, $order_number, $money, $pay_type, $terminal_type, $order_type);
			return $re;
		});
		
		return return_json($re);
	}
	
	public function ali_return_callback() {
		$aliPayService = new AliPay();
		$aliPayService->return_callback();
	}
	
	/**
	 * 异步回调
	 * @throws \think\exception\PDOException
	 */
	public function ali_notify_callback() {
		$re = $this->transaction(function () {
			$aliPayService = new AliPay();
			$re = $aliPayService->notify_callback();
			return $re;
		});
	}
	
	public function wx_return_callback() {
		$wxPayService = new WxPay();
		$wxPayService->return_callback();
	}
	
	/**
	 * 异步回调
	 * @throws \think\exception\PDOException
	 */
	public function wx_notify_callback() {
		log_record('wx_notify_callback start');
		$re = $this->transaction(function () {
			$wxPayService = new WxPay();
			$re = $wxPayService->notify_callback();
			return $re;
		});
	}
	
}
