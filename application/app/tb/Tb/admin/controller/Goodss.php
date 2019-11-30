<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\admin\controller;

use app\app\tb\Attribute\common\model\Attri;
use app\app\tb\Attribute\common\model\Classgood;
use app\app\tb\Attribute\common\model\Classify;
use app\app\tb\Attribute\common\model\Goodattr;
use app\app\tb\Attribute\common\model\Specs;
use app\app\tb\Tb\common\model\Goods;
use app\app\tb\Tb\common\model\Model;
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
        if(array_key_exists("goodsname",$param)&&$param['goodsname']!=""&&array_key_exists("classify",$param)&&$param['classify']!=""&&array_key_exists("price",$param)&&$param['price']!=""&&array_key_exists("title",$param)&&$param['title']!=""&&array_key_exists("description",$param)&&$param['description']!=""&&array_key_exists("content",$param)&&$param['content']!=""){
            $GoodM=new Goods();
            $gwhere['goodsname']=$param['goodsname'];
            $res=$GoodM->getDataItem($gwhere);
            if(empty($res['result'])){
                $this->startTrans();
                $re=parent::add();
                $re=json_decode($re->getContent(),true);
                if(!empty($re['result'])){
                    if(array_key_exists("specs",$param)&&$param['specs']!=""){
                        $specsarray=$this->SpecsFormat($param['specs'],$re['result']['id']);
                        if(!empty($specsarray)){
                            $GoodattrM=new Goodattr();
                            $res=$GoodattrM->insertAll($specsarray);
                            if($res){
                                $this->commit();
                                return return_json($re);
                            }else{
                                $this->rollback();
                                return return_json_err("商品添加失败",400);
                            }
                        }else{
                            $this->commit();
                            return return_json($re);
                        }
                    }else{
                        $this->commit();
                        return return_json($re);
                    }
                }else{
                    $this->rollback();
                    return return_json_err("商品添加失败",400);
                }
            }else{
                return return_json_err("商品名不能重复",400);
            }
        }else{
            return return_json_err("缺少必要参数",400);
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
        $data=json_decode($data,true);
        $back=array();
        foreach ($data as $key => $value){
            if(array_key_exists("price",$value)&&$value['price']!=""&&array_key_exists("name",$value)&&$value['name']!=""&&array_key_exists("id",$value)&&$value['id']!=""){
                $value1['pricetype']=isset($value['pricetype']) ? $value['pricetype'] : 0;
                $value1['attribute']=$value['name'];
                $value1['goodsid']=$id;
                $value1['attrid']=$value['id'];
                $value1['price']=$value['price'];
                array_push( $back,$value1);
            }
        }
        return $back;
    }
    /**
     * 获取详情 通过id查询
     * 商品
     * @api_name 获取商品详情
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Goodss.getItemByIdM
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemByIdM()
    {
        $res=parent::getItemById();
        $res=json_decode($res->getContent(),true);
        if(!empty($res['result'])){
            if(array_key_exists("classify",$res['result'])&&$res['result']['classify']!=""&&$res['result']['classify']!=0){
                $classM=new Classify();
                $where['id']=$res['result']['classify'];
                $where['delete_time']=0;
                $re=$classM->getDataItem($where);
                if(!empty($re['result'])){
                    $res['result']['classifyname']=$re['result']['name'];
                }else{
                    $res['result']['classifyname']="未知";
                }
            }else{
                $res['result']['classifyname']="未知";
            }
            if(array_key_exists("modelid",$res['result'])&&$res['result']['modelid']!=""&&$res['result']['modelid']!=0) {
                if ($res['result']['modelid'] != "" && $res['result']['modelid'] != 0) {
                    $nodelM = new Model();
                    $where['id'] = $res['result']['modelid'];
                    $where['delete_time'] = 0;
                    $re = $nodelM->getDataItem($where);
                    if (!empty($re['result'])) {
                        $res['result']['modelidname'] = $re['result']['name'];
                    } else {
                        $res['result']['modelidname'] = "未知";
                    }
                } else {
                    $res['result']['modelidname']['modelidname'] = "未知";
                }
            }else{
                $res['result']['modelidname']="未知";
            }
            $GoodattrM = new Goodattr();
            $wherea['goodsid'] = $res['result']['id'];
            $wherea['delete_time'] = 0;
            $re = $GoodattrM->getList($wherea);
            if (!empty($re['result']['data'])) {
                $res['result']['specs'] = $re['result']['data'];
            } else {
                $res['result']['specs'] =array();
            }
            return rjData($res['result']);
        }else{
            return rjData("");
        }
    }
    /**
     * 获取列表
     * 商品
     * @api_name 获取商品列表
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Goodss.getListM
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getListM() {
        $res=parent::getList();
        $res=json_decode($res->getContent(),true);
        foreach ($res['result']['data'] as $key => $value){
            if($value['classify']!=""&&$value['classify']!=0){
                $classM=new Classify();
                $where['id']=$value['classify'];
                $where['delete_time']=0;
                $re=$classM->getDataItem($where);
                if(!empty($re['result'])){
                    $value['classifyname']=$re['result']['name'];
                }else{
                    $value['classifyname']="未知";
                }
                $res['result']['data'][$key]=$value;
            }else{
                $res['result']['data'][$key]['classifyname']="未知";
            }
            if($value['modelid']!=""&&$value['modelid']!=0){
                $nodelM=new Model();
                $where['id']=$value['modelid'];
                $where['delete_time']=0;
                $re=$nodelM->getDataItem($where);
                if(!empty($re['result'])){
                    $value['modelidname']=$re['result']['name'];
                }else{
                    $value['modelidname']="未知";
                }
                $res['result']['data'][$key]=$value;
            }else{
                $res['result']['data'][$key]['modelidname']="未知";
            }
            $res['result']['data'][$key]['create_time']=date("Y-m-d H:i:s",$value['create_time']);
        }
        return return_json($res);
    }

    /**
     * 更改
     * 商品
     * @api_name 更改商品
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Goodss.editM
     *
     * id
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
    public function editM() {
        $param=$this->param;
        if(array_key_exists("goodsname",$param)&&$param['goodsname']!=""&&array_key_exists("id",$param)&&$param['id']!=""&&array_key_exists("classify",$param)&&$param['classify']!=""&&array_key_exists("price",$param)&&$param['price']!=""&&array_key_exists("title",$param)&&$param['title']!=""&&array_key_exists("description",$param)&&$param['description']!=""&&array_key_exists("content",$param)&&$param['content']!=""){
            $GoodM=new Goods();
            $gwhere[]=["goodsname",'=',$param['goodsname']];
            $gwhere[]=['id',"!=",$param['id']];
            $res=$GoodM->getDataItem($gwhere);
            if(empty($res['result'])){
                $this->startTrans();
                $re=parent::edit();
                $re=json_decode($re->getContent(),true);
                if($re['msg']=="ok"){
                    if(array_key_exists("specs",$param)&&$param['specs']!=""){
                        $specsarray=$this->SpecsFormat($param['specs'],$param['id']);
                        if(!empty($specsarray)){
                            $GoodattrM=new Goodattr();
                            $gawhere['goodsid']=$param['id'];
                            $res1=$GoodattrM->where($gawhere)->delete();
                            $res=$GoodattrM->insertAll($specsarray);
                            if($res&&$res1){
                                $this->commit();
                                return return_json($re);
                            }else{
                                $this->rollback();
                                return rjData("商品修改失败");
                            }
                        }else{
                            $this->commit();
                            return return_json($re);
                        }
                    }else{
                        $this->commit();
                        return return_json($re);
                    }
                }else{
                    $this->rollback();
                    return return_json_err("商品修改失败",400);
                }
            }else{
                return return_json_err("商品名不能重复",400);
            }
        }else{
            return return_json_err("缺少必要参数",400);
        }
    }
    /**
     * 获得宣传页信息
     * @api_name 获得宣传页信息
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Goodss.GetSGood
     *
     * id
     * @return mixed|string
     * @throws \think\exception\PDOException
     */
    public function GetSGood() {
        $param=$this->param;
        if(array_key_exists("id",$param)){
            $gwhere[]=["id","=",$param['id']];
            $goodM=new Goods();
            $res=$goodM->getDataItem($gwhere);

            if(!empty($res['result'])){
                if($res['result']['modelid']!=""&&$res['result']['modelid']!=0){
                    $nodelM=new Model();
                    $where['id']=$res['result']['modelid'];
                    $where['delete_time']=0;
                    $re=$nodelM->getDataItem($where);
                    if(!empty($re['result'])){
                        $res['result']['url']=$re['result']['url']."?grood=".$param['id'];
                    }else{
                        $res['result']['url']="";
                    }
                    return return_json($res);
                }else{
                    return return_json($res);
                }
            }else{
                return rjData("未找到数据");
            }
        }else{
            return return_json_err("缺少必要参数",400);
        }
    }

    /**
     * 添加商品活动属性排列
     * @api_name 添加商品活动属性排列
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Goodss.AttrisArray
     *
     * id
     * @return mixed|string
     * @throws \think\exception\PDOException
     * @throws \think\Exception
     */
    public function AttrisArray() {
        $param=$this->param;
        if(array_key_exists("id",$param)){
            $classify=new Classify();
            $cwhere['id']=$param['id'];
            $classinfo=$classify->getDataItem($cwhere);
            $classinfo['attrlist']=array();
            if(!empty($classinfo['result'])) {
                $specssm = new Specs();
                $swhere['classifyid'] = $classinfo['result']['id'];
                $specslist = $specssm->getList($swhere);
                $item=array();
                if (!empty($specslist['result']['data'])) {
                    $attrim= new Attri();
                    foreach ($specslist['result']['data'] as $key => $value){
                        $awhere['specsid']=$value['id'];
                        $attrlist=$attrim->getList($awhere);
                        if(!empty($attrlist['result'])){
                            $specslist['result']['data'][$key]['attr']=$attrlist['result'];
                            if(!empty($attrlist['result']['data'])){
                                array_push($item,$attrlist['result']['data']);
                            }
                        }
                    }
//                    print_r($this->myFormatAttr($item,count($item)-1));
//                    exit;
                    $item=$this->combination($item);
                    $back=$this->FormatAttr($item);
                    $classinfo['result']['attr']=$back;
                    return rjData($classinfo);
                }else{
                    $classinfo['result']['attr']=array();
                    return rjData($classinfo);
                }
            }else{
                return return_json_err("没有此分类",400);
            }
        }else{
            return return_json_err("缺少必要参数",400);
        }
    }
    /**
     * 生成属性的排列组合列表
     * array数组
     * length数组长度
     * page当前数据执行到第几个
     * backarray返回的整合数组
     * npage数组内部执行到第几个
     */
    function combination(array $options)
    {
        $rows = [];
        foreach ($options as $option => $items) {
            if (count($rows) > 0) {
                // 2、将第一列作为模板
                $clone = $rows;
                // 3、置空当前列表，因为只有第一列的数据，组合是不完整的
                $rows = [];
                // 4、遍历当前列，追加到模板中，使模板中的组合变得完整
                foreach ($items as $item) {
                    $tmp = $clone;
                    foreach ($tmp as $index => $value) {
                        $value[$option] = $item;
                        $tmp[$index] = $value;
                    }
                    // 5、将完整的组合拼回原列表中
                    $rows = array_merge($rows, $tmp);
                }
            } else {
                // 1、先计算出第一列
                foreach ($items as $item) {
                    $rows[][$option] = $item;
                }
            }
        }
        return $rows;
    }

    /**
     * 对组合后的属性进行格式化 格式为1-2-3 array(name1 name2 name3)
     */
    public function FormatAttr($array)
    {
        $result=array();
        foreach ($array as $key => $value){
            $item=array();
            $item['id']="";
            $item['name']="";
            $item['namearray']=array();
            foreach ($value as $k => $v){
                $item['id'].=$v['id']."-";
                $item['name'].=$v['name']."-";
                array_push($item['namearray'],$v['name']);
            }
            $item['id']=substr($item['id'],0,strlen($item['id'])-1);
            $item['name']=substr($item['name'],0,strlen($item['name'])-1);
            array_push($result,$item);
        }
       return $result;
    }
}
