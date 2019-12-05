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
        if(array_key_exists('username',$param)&&$param['username']!=""&&array_key_exists('phone',$param)&&$param['phone']!=""&&array_key_exists('address',$param)&&$param['address']!=""&&array_key_exists('guigeid',$param)&&$param['guigeid']!=""&&array_key_exists('number',$param)&&$param['number']!=""&&$param['number']!=0){
            $check = '/^(1(([35789][0-9])|(47)))\d{8}$/';
            if (preg_match($check,$param['phone'])) {
                if ((floor($param['number']) - $param['number']) !=0){
                    return return_json_err("只能购买整数货物",400);
                }else{
                    $param['number']=isset($param['number'])? $param['number']:0;
                    //计算订单价格
                    $goodattrM=new Goodattr();
                    $where['id']=$param['guigeid'];
                    $goodattr=$goodattrM->getDataItem($where);
                    if(!empty($goodattr['result'])){
                        if($goodattr['result']['pricetype']==0){
                            $param['price']=$goodattr['result']['price']*$param['number'];
                        }else{
                            $param['price']=$goodattr['result']['zprice']*$param['number'];
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
                    $param['price']=$goodattr['result']['price']/100*$param['number'];
                    $res=json_decode($res->getContent(),true);
                    if(!empty($res['result'])){
                        $url="http://".$_SERVER['HTTP_HOST'].'/test.php?n='.$param['price'].'&b='.$param['username'];  //需改
                        $url_val=urlencode(mb_convert_encoding("$url", 'utf-8'))."\n";
                        $url_='alipays://platformapi/startapp?saId=10000007&qrcode='.$url_val;



//                        $url="http://".$_SERVER['HTTP_HOST'].'/test.php?n='.$param['price'].'&b='.$param['username'];  //需改

//                        $url_val=urlencode(mb_convert_encoding("$url", 'utf-8'))."\n";
//                        $url_='alipays://platformapi/startapp?saId=10000007&qrcode='.$url_val;
                        $res['result']['url']=$url_;
//                        echo "<html><script type='text/javascript'>$().ready(function(){window.location.href='alipays://platformapi/startapp?saId=10000007&qrcode=http%3A%2F%2F192.168.1.122%2Findex.php%3Fn%3D1%26b%3Dtian'})</script></html>";
//                $redirect=$url_;
//                $this->redirect($url,301);
//                header("HTTP/1.1 301 Moved Permanently");
//                header("Location:$url");
//                exit;
                        return return_json($res);
                    }else{
                        return return_json_err("下单失败",400);
                    }
                }
            }else{
                return return_json_err("请检测手机号",400);
            }
        }else{
            return return_json_err("缺少必要参数",400);
        }
    }

}
