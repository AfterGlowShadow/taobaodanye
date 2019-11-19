<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Pay\admin\controller;

use app\sys\com\Pay\common\model\Payment;
use think\Db;

/**
 * Class Payments
 * 支付记录
 * @api_name 支付记录
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Pay\admin\controller
 */
class Payments extends \app\sys\com\Pay\admin\controller\logic\Payments {

    public function init_before() {
        parent::init_before();


    }



}
