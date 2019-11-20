<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\admin\controller;

use app\app\tb\Attribute\common\model\Classgood;
use app\app\tb\Attribute\common\model\Specs;
use app\app\tb\Tb\common\model\Goods;
use think\Db;

/**
 * Class Goodss
 * 商品
 * @api_name 商品
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Tb\admin\controller
 */
class Goodss extends \app\app\tb\Tb\admin\controller\logic\Goodss {

    public function init_before() {
        parent::init_before();


    }

    /**
     * 添加
     * 商品
     * @api_name 添加商品
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Goodss.addGoods
     *
     * goodsname        商品名称
     * price            价格
     * title            标题
     * description        描述
     * content            详情
     * modelid            宣传模型id
     * classify            商品分类id
     * @return mixed|string
     * @throws \think\exception\PDOException
     */
    public function addGoods() {
        $param=$this->param;
        if(array_key_exists("goodsname",$param)&&$param['goodsname']!=""&&array_key_exists("price",$param)&&$param['price']!=""&&array_key_exists("title",$param)&&$param['title']!=""&&array_key_exists("description",$param)&&$param['description']!=""&&array_key_exists("content",$param)&&$param['content']!=""&&array_key_exists("modelid",$param)&&$param['modelid']!=""&&array_key_exists("classify",$param)&&$param['classify']!=""){
            $GoodM=new Goods();
            $gwhere['goodsname']=$param['goodsname'];
            $res=$GoodM->getItem($gwhere);
            if(empty($res['result'])){
                $this->startTrans();
                $re=parent::add();
                $re=json_decode($re->getContent(),true);
                if(!empty($re['result'])){
                    if(array_key_exists("specs",$param)&&$param['specs']!=""){
                        $specsarray=$this->SpecsFormat($param['specs'],$re['result']['id']);
                        print_r($specsarray);
                        exit;
                        $back['specs']=array();
                        $back['class']=array();
                        if(!empty($specsarray['specs'])&&!empty($specsarray['class'])){
                            $specsM=new Specs();
                            $res=$specsM->insertAll($specsarray['specs']);
                            $ClassGoodM=new Classgood();
                            $res1=$ClassGoodM->insertAll($specsarray['class']);
                            if($res&&$res1){
                                $this->commit();
                                return $re;
                            }else{
                                $this->rollback();
                                return rjData("商品添加失败");
                            }
                        }else{
                            $this->commit();
                            return $re;
                        }
                    }else{
                        $this->commit();
                        return $re;
                    }
                }else{
                    $this->rollback();
                    return rjData("商品添加失败");
                }
            }else{
                return rjData("商品名不能重复");
            }
        }else{
            return rjData("缺少必要参数");
        }
    }

    /**
     * 对商品的规格进行格式化
     * User: Administrator
     * Date: 2019-11-20 16:55
     * RequestType:
     * requestInfo:
     * apiSuccessMock:
     * apiFailureMock:
     */
    public function SpecsFormat($data,$id){
        print_r($data);
        exit;
        $data=json_decode($data,true);
        $back['specs']=array();
        $back['class']=array();
        foreach ($data as $key => $value){
            if(array_key_exists("classify",$value)&&isset($value['classify'])&&array_key_exists("id",$value['classify'])&&array_key_exists("specs",$value['classify'])){
                if(array_key_exists("specsidl",$value['classify']['specs'])&&$value['specsidl']!=""&&array_key_exists("price",$value['classify']['specs'])&&$value['price']!=""&&array_key_exists("zprice",$value['classify']['specs'])&&$value['zprice']!=""){
                    $value['pricetype']=isset($value['pricetype']) ? $value['pricetype'] : 0;
                    $value['goodsid']=$id;
                    array_push( $back['specs'],$value);
                    $temp['goodsid']=$id;
                    $temp['classify']=$value['classify']['id'];
                    array_push($back['class'],$value);
                }
            }
        }
        return $back;
    }


}
