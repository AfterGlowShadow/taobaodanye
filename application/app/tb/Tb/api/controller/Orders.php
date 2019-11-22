<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\api\controller;

use app\app\tb\Tb\common\model\Order;
use app\sys\com\Pay\admin\controller\Payments;
use app\sys\com\Pay\common\model\Payment;
use app\sys\com\Pay\common\service\AliPay;
use think\Db;

/**
 * Class Orders
 * 订单
 * @api_name 订单
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Tb\api\controller
 */
class Orders extends \app\app\tb\Tb\api\controller\logic\Orders {

    public function init_before() {
        parent::init_before();


    }
    /**
     * 下订单
     * @api_name 下订单
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Tb.v1.Orders.addM
     *
     * phone			收件人手机号
     * address			寄货地址
     * productid		商品id
     * price			价格
     * pay_time			支付时间
     * status			支付状态0未支付 1支付成功 2支付中 3待审核 4支付失败
     * ordersn			订单编号
     * orderoutsn		外部订单编号
     * number			购买产品数量
     * typeid			产品类型id
     * @return mixed|string
     */
    public function addM() {
        $Pay=new AliPay();
        $param['out_trade_no']="fdsafsafs";
        $param['total_amount']="12";
        $param['subject']="fdsafdsa";
        $param['terminal_type']="wap";
        echo"tian";
        print_r($Pay->pay($param));
    }


}
