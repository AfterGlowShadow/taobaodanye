<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Pay\admin\controller;

use app\sys\com\Pay\common\model\Refund;
use think\Db;

/**
 * Class Refunds
 * 退款表
 * @api_name 退款记录
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Pay\admin\controller
 */
class Refunds extends \app\sys\com\Pay\admin\controller\logic\Refunds {

    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 退款
	 * 退款表
	 *
	 * @api_name        退款
	 * @api_type        2
	 * @api_is_menu     0
	 * @api_is_maker    1
	 * @api_is_show     1
	 * @api_is_def_name 0
	 * @api_url         /sys/admin/Pay.v1.Refunds.refund
	 *
	 * @return \think\response\Json
	 * @throws \Throwable
	 */
	public function refund() {
		/** @var $m Refund */
		$m = $this->_model;
		$param = $this->param;
		
		$out_trade_no = $this->p('out_trade_no'); // 支付单号
		$money = $this->p('money');
		$reason = isset($param['reason']) ? $param['reason'] : '';
		
		$re = $this->transaction(function () use ($m, $param, $out_trade_no, $money, $reason) {
			$re = $m->refund($param, $out_trade_no, $money, $reason);
			return $re;
		});
		
		return return_json($re);
	}

}
