<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\admin\controller;

use app\app\tb\Attribute\common\model\Attri;
use app\app\tb\Attribute\common\model\Classify;
use app\app\tb\Attribute\common\model\Goodattr;
use app\app\tb\Attribute\common\model\Specs;
use app\app\tb\Tb\common\model\Goods;
use app\app\tb\Tb\common\model\Order;
use app\sys\com\Pay\common\service\AliPay;
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
    /**
     * 获取列表
     * 订单
     * @api_name 获取订单列表
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Orders.getListM
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getListM() {
        $param=$this->param;
        $res=parent::getList();
        $res=json_decode($res->getContent(),true);
        foreach ($res['result']['data'] as $key => $value){
            $res['result']['data'][$key]=$this->FormatOrder($value);
//            $res['result']['data'][$key]['price']=$value['price']/100;
//            $goodM=new Goods();
//            $where['id']=$value['productid'];
//            $goodinfo=$goodM->getDataItem($where);
//            if(!empty($goodinfo['result'])){
//
//                $res['result']['data'][$key]['goodname']=$goodinfo['result']['goodsname'];
//            }else{
//                $res['result']['data'][$key]['goodname']="未知";
//            }
        }
        return return_json($res);
    }
    /**
     * 获取列表
     * 订单
     * @api_name 获取订单列表(带时间和一个模糊字段的查询)
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Orders.getSList
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getSList() {
        $param=$this->param;
        $where=[];
        $page_num = isset($param['page_num']) ? $param['page_num'] : 1;
        $page_limit = isset($param['page_limit']) ? $param['page_limit'] : PHP_INT_MAX;
        if(array_key_exists("starttime",$param)&&array_key_exists("endtime",$param)&&$param['starttime']<$param['endtime']){
            $where[]=['create_time',">=",$param['starttime']];
            $where[]=['create_time',"<=",$param['endtime']];
            //添加时间限制的查询
        }
        if(array_key_exists("search",$param)&&array_key_exists("searchfield",$param)){
            $where[]=[$param['searchfield'],"like","%".$param['search']."%"];
        }
        $_field = isset($this->_buf['getList']['field']) ? $this->_buf['getList']['field'] : '*';
        $_link = isset($this->_buf['getList']['link']) ? $this->_buf['getList']['link'] : false;
        $_join = isset($this->_buf['getList']['join']) ? $this->_buf['getList']['join'] : [];
        $_param = isset($this->_buf['getList']['param']) ? $this->_buf['getList']['param'] : [];
        $orderm=new Order();
//        $orderm->getDataItem($where);
        $re = $orderm->getList($where, "id desc", $page_num, $page_limit, $_field, $_link, $_join, $_param);
//        print_r($re);
//        exit;
//        $res=json_decode($re->getContent(),true);
        foreach ($re['result']['data'] as $key => $value){
            $re['result']['data'][$key]=$this->FormatOrder($value);
//            $re['result']['data'][$key]['price']=$value['price']/100;
//            $goodM=new Goods();
//            $where['id']=$value['productid'];
//            $goodinfo=$goodM->getDataItem($where);
//            if(!empty($goodinfo['result'])){
//                $re['result']['data'][$key]['goodname']=$goodinfo['result']['goodsname'];
//            }else{
//                $re['result']['data'][$key]['goodname']="未知";
//            }
        }
        return return_json($re);
    }
    /**
     * 获取详情 通过id查询
     * 订单
     * @api_name 获取订单详情
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Orders.getItemByIdM
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemByIdM() {
        $res=parent::getItemById();
        $res=json_decode($res->getContent(),true);
        if(!empty($res['result'])){
//            $res['result']['price']=$res['result']['price']/100;
//            $goodM=new Goods();
//            $where['id']=$res['result']['productid'];
//            $goodinfo=$goodM->getDataItem($where);
//            if(!empty($goodinfo['result'])){
//                $res['result']['goodname']=$goodinfo['result']['goodsname'];
//            }else{
//                $res['result']['goodname']="未知";
//            }
//            $GoodattrM=new Goodattr();
//            $where['id']=$res['result']['goodattrid'];
//            $goodinfo=$GoodattrM->getDataItem($where);
//            if(!empty($goodinfo['result'])){
//                $attribute=$goodinfo['result']['attribute'];
//                $attr=explode("-",$attribute);
//                //获得分类
//                $classM=new Classify();
//                $cwhere['id']=$attr[0];
//                $classinfo=$classM->getDataItem($cwhere);
//                //获得规格
//                $attriM=new Attri();
//                $awhere['id']=$attr[1];
//                $attrinfo=$attriM->getDataItem($awhere);
//                //获得属性
//                $specsM=new Specs();
//                $swhere['id']=$attr[1];
//                $specsinfo=$specsM->getDataItem($swhere);
//                if(!empty($attrinfo['result'])){
//                    $res['result']['attrname']=$attrinfo['result']['name'];
//                }else{
//                    $res['result']['attrname']="未知";
//                }
//                if(!empty($classinfo['result'])){
//                    $res['result']['classifysname']=$classinfo['result']['name'];
//                }else{
//                    $res['result']['classifysname']="未知";
//                }
//                if(!empty($specsinfo['result'])){
//                    $res['result']['specssname']=$specsinfo['result']['name'];
//                }else{
//                    $res['result']['specssname']="未知";
//                }
//            }else{
//                $res['result']['attrname']="未知";
//                $res['result']['classifysname']="未知";
//                $res['result']['specssname']="未知";
//            }
            $res['result']=$this->FormatOrder($res['result']);
            return return_json($res);
        }else{
            return return_json_err("未找到此订单",400);
        }
    }

    /**
     * Date: 2019-11-22 17:50
     * 处理每条订单信息
     */
    public function FormatOrder($res)
    {
        $res['price']=$res['price']/100;
        $goodM=new Goods();
        $where['id']=$res['productid'];
        $goodinfo=$goodM->getDataItem($where);
        if(!empty($goodinfo['result'])){
            $res['goodname']=$goodinfo['result']['goodsname'];
        }else{
            $res['goodname']="未知";
        }
        $GoodattrM=new Goodattr();
        $where['id']=$res['goodattrid'];
        $goodinfo=$GoodattrM->getDataItem($where);
        if(!empty($goodinfo['result'])){
            $attribute=$goodinfo['result']['attribute'];
            $attr=explode("-",$attribute);
            //获得分类
            $classM=new Classify();
            $cwhere['id']=$attr[0];
            $classinfo=$classM->getDataItem($cwhere);
            //获得规格
            $attriM=new Attri();
            $awhere['id']=$attr[1];
            $attrinfo=$attriM->getDataItem($awhere);
            //获得属性
            $specsM=new Specs();
            $swhere['id']=$attr[1];
            $specsinfo=$specsM->getDataItem($swhere);
            if(!empty($attrinfo['result'])){
                $res['attrname']=$attrinfo['result']['name'];
            }else{
                $res['attrname']="未知";
            }
            if(!empty($classinfo['result'])){
                $res['classifysname']=$classinfo['result']['name'];
            }else{
                $res['classifysname']="未知";
            }
            if(!empty($specsinfo['result'])){
                $res['specssname']=$specsinfo['result']['name'];
            }else{
                $res['specssname']="未知";
            }
        }else{
            $res['attrname']="未知";
            $res['classifysname']="未知";
            $res['specssname']="未知";
        }
        return $res;
    }
    /**
     * 下订单
     * @api_name 下订单
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Orders.addM
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
        //计算订单价格
        //规格删除后 属性也要一并删除 以免现在添加商品时 添加上已经取消了的货物
        $param['price'];
        $param['status']=0;
        $param['ordersn']=date("YmdHis",time()).rand(8);
        $param['out_trade_no']=md5($param['ordersn']);
        $param['total_amount']="12";
        $param['subject']="fdsafdsa";
        $param['terminal_type']="web";
//        print_r($Pay->pay($param));
        print_r($res=parent::add());
    }
}
