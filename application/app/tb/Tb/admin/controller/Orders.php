<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\admin\controller;

use app\app\tb\Tb\common\model\Order;
use think\Db;

/**
 * Class Orders
 * 订单
 * @api_name 订单
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Tb\admin\controller
 */
class Orders extends \app\app\tb\Tb\admin\controller\logic\Orders {

    public function init_before() {
        parent::init_before();


    }



}
