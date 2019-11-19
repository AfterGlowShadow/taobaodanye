<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller;

use app\app\yss\Yss\common\model\Industry;
use app\app\yss\Yss\common\model\Order;
use app\app\yss\Yss\common\model\OrderDetail;
use app\app\yss\Yss\common\model\Sell;
use app\app\yss\Yss\common\model\Yss;
use think\Db;

/**
 * Class Orders
 * 旅游订单表
 * @api_name 旅游订单
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\api\controller
 */
class Orders extends \app\app\yss\Yss\api\controller\logic\Orders
{

    public function init_before()
    {
        parent::init_before();


    }

    /**
     * 添加
     * 企业转让订单表
     * @api_name 添加企业转让订单
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Orders.add
     *
     * uid                    购买人id
     * realname                购买人姓名
     * mobile                购买人手机号手机号
     * product_number        数量
     * order_number            订单号
     * company_sn            企业编号
     * explor_id            出售企业人id
     * explor_name            出售人姓名
     * explor_phone            出售人手机号
     * title                标题
     * price                价格
     * customer_id            客服id
     * customer_name        客服名
     * remark                备注
     * real_price            真实价格（确认后的价格）
     * pay_price            支付价格
     * status                状态（0-未知 1-未付款 2-交接中 3-已完成）
     * type                    类型 1企业注册 2工商变更 3财税服务 4购买企业
     * pay_time                支付时间
     * @return mixed|string
     */
    public function add()
    {
        $this->param['uid'] = $this->uid;
        $this->param['realname'] = $GLOBALS['uInfo']['name'];
        $this->param['mobile'] = $GLOBALS['uInfo']['mobile'];
        $this->param['order_number'] = createOrderId();
        $industryModel = new Industry();
        $order_detail = [];
        $order_detail['type'] = $this->p('type');

        if ($this->param['type'] == 4) {
            $yssModel = new Yss();
            $re = $yssModel->getItemById($this->param['company_id'], 'user_id,user_name,phone,company_type_name,company_name,county,pay_taxes,establishment,industry_name,order_sn');
            if (!is_return_ok($re)) {
                return return_json($re);
            }
            $yssData = get_return_data($re);
            $this->param['explor_id'] = $yssData['user_id'];
            $this->param['conmpany_sn'] = $yssData['order_sn'];
            $this->param['explor_name'] = $yssData['user_name'];
            $this->param['explor_phone'] = $yssData['phone'];
            $this->param['price'] = $yssData['sell_price'];
            $this->param['real_price'] = $yssData['sell_price'];

            $order_detail['company_type'] = $yssData['company_type_name'];
            $order_detail['industry_type'] = $yssData['industry_name'];
            $order_detail['address'] = $yssData['county'];
            $order_detail['pay_taxes_type'] = $yssData['pay_taxes'];
            $order_detail['operating_time'] = ceil((time() - strtotime($yssData['establishment'])) / 365 / 24 / 3600);

        } elseif ($this->param['type'] == 2) {
            $attrs = explode(',', $this->param['company_id']);
            $total_price = 0;
            $total_shop_price = 0;
            $order_detail['company_type'] = '';
            $order_detail['industry_type'] = '';
            $order_detail['address'] = '';
            foreach ($attrs as $v) {
                $_where = [];
                $_where[] = ['a.id', '=', $v];
                $re = $industryModel->alias('a')->where($_where)->join('wp_app_yss_attribute b', 'a.id=b.ind_id')->field('sum(a.price)+sum(b.cat_price) as totalprice,shop_price,a.company_name,a.service_name,a.address')->find();
                if ($re === false) {
                    return return_json($re);
                }
                $total_price += $re['totalprice'];
                $total_shop_price += $re['shop_price'];

                $order_detail['company_type'] .= $re['company_name'].',';
                $order_detail['industry_type'] .= $re['service_name'].',';
                $order_detail['address'] .= $re['address'].',';
            }
            $this->param['price'] = $total_shop_price;
            $this->param['real_price'] = $total_price;
            trim($order_detail['company_type'],',');
            trim($order_detail['industry_type'],',');
            trim($order_detail['address'],',');
        } else {

            $re = $industryModel->getItemById($this->param['company_id'], 'shop_price,price,service_name,meal_name,address,company_name');
            if (!is_return_ok($re)) {
                return return_json($re);
            }
            $yssData = get_return_data($re);
            $this->param['price'] = $yssData['shop_price'];
            $this->param['real_price'] = $yssData['price'];

            $order_detail['meal_type'] = $yssData['meal_name'];
            $order_detail['company_type'] = $yssData['company_name'];
            $order_detail['industry_type'] = $yssData['service_name'];
            $order_detail['address'] = $yssData['address'];
        }
        $res = parent::add();
        if (!is_return_ok($res)) {
            return return_json($res);
        }
        $resData = get_return_data($res);
        $order_detail['order_id'] = $resData['result']['id'];
        $orderDetailModel =  new OrderDetail();
        $result = $orderDetailModel->add($order_detail);
        return return_json($result);
    }


}
