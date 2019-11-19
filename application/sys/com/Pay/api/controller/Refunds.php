<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Pay\api\controller;

use app\sys\com\Pay\common\model\Payment;
use app\sys\com\Pay\common\model\Refund;
use app\sys\com\Pay\event\Event;
use think\Db;

/**
 * Class Refunds
 * 退款表
 * @api_name 退款记录
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Pay\api\controller
 */
class Refunds extends \app\sys\com\Pay\api\controller\logic\Refunds {

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
	 * @api_url /sys/api/pay.v1.payments.pay
	 *
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function refund() {
		/** @var $m Refund */
		$m = $this->_model;
		$param = $this->param;
		
		$out_trade_no = $this->p('out_trade_no');
		$money = $this->p('money');
		
		$re = $this->transaction(function () use ($m, $param, $out_trade_no, $money) {
			$re = $m->refund($param, $out_trade_no, $money, '');
			return $re;
		});
		
		return return_json($re);
	}

}
