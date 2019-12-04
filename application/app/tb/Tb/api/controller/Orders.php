<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\api\controller;

use app\app\tb\Attribute\common\model\Goodattr;
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
        $param=$this->param;
        if(array_key_exists('username',$param)&&$param['username']!=""&&array_key_exists('phone',$param)&&$param['phone']!=""&&array_key_exists('address',$param)&&$param['address']!=""&&array_key_exists('guigeid',$param)&&$param['guigeid']!=""&&array_key_exists('nmber',$param['number'])){
            $param['number']=isset($param['number'])? $param['number']:0;
            //计算订单价格
            $goodattrM=new Goodattr();
            $where['id']=$param['guigeid'];
            $goodattr=$goodattrM->getDataItem($where);
            if(!empty($goodattr['result'])){
                if($goodattr['result']['pricetype']==0){
                    $param['price']=$goodattr['result']['price']/100*$param['number'];
                }else{
                    $param['price']=$goodattr['result']['zprice']/100*$param['number'];
                }
                $param['goodattrid']=$param['guigeid'];
                $param['productid']=$goodattr['result']['goodsid'];

            }
            //规格删除后 属性也要一并删除 以免现在添加商品时 添加上已经取消了的货物
            $param['status']=0;
            $param['ordersn']=date("YmdHis",time()).createCode(8);
            $param['orderoutsn']=md5($param['ordersn']);
            $this->param=$param;
            $res=parent::add();
            $res=json_decode($res->getContent(),true);
            $url='http://192.168.1.122/index.php?n='.$param['price'].'&b='.$param['username'];  //需改
            $url_val=urlencode(mb_convert_encoding("$url", 'utf-8'))."\n";
            $url_='alipays://platformapi/startapp?saId=10000007&qrcode='.$url_val;
            return redirect($url_);
        }else{
            return return_json_err("缺少必要参数",400);
        }
    }

}
