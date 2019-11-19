<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller;

use app\app\yss\Yss\common\model\Order;
use think\Db;

/**
 * Class Orders
 * 旅游订单表
 * @api_name 旅游订单
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\admin\controller
 */
class Orders extends \app\app\yss\Yss\admin\controller\logic\Orders {

    public function init_before() {
        parent::init_before();


    }

    /**
     * 更改状态
     * 企业转让订单表
     * @api_name 更改企业转让订单状态
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Yss.v1.Orders.setCustomer
     *
     * id
     * customer_id				专属客服id
     * @return mixed|string
     */
    public function setCustomer() {
        /** @var $m Order */
        $m = $this->_model;
        $param = $this->param;

        $id = $this->p('id');
        $customer_id = $this->p('customer_id');
        $customer_name = $this->p('customer_name');

        $_d = [];
        $_d['customer_id'] = $customer_id;
        $_d['customer_name'] = $customer_name;
        $re = $m->editById($id, $_d);
        return return_json($re);
    }


}
