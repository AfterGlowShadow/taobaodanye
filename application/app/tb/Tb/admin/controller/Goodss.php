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
        if(array_key_exists("goodsname",$param)&&$param['goodsname']!=""&&array_key_exists("price",$param)&&$param['price']!=""&&array_key_exists("title",$param)&&$param['title']!=""&&array_key_exists("description",$param)&&$param['description']!=""&&array_key_exists("content",$param)&&$param['content']!=""&&array_key_exists("modelid",$param)&&$param['modelid']!=""){
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
                    return rjData("商品添加失败");
                    return return_json_err("缺少必要参数",400);
                }
            }else{
                return rjData("商品名不能重复");
                return return_json_err("缺少必要参数",400);
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
            if(array_key_exists("goodsid",$value)&&isset($value['goodsid'])&&array_key_exists("attribute",$value)&&$value['attribute']!=""&&array_key_exists("price",$value)&&$value['price']!=""&&array_key_exists("zprice",$value)&&$value['zprice']!=""&&array_key_exists("img",$value)&&$value['img']!=""){
                $value['pricetype']=isset($value['pricetype']) ? $value['pricetype'] : 0;
                $value['goodsid']=$id;
                array_push( $back,$value);
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
            return rjData($res);
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
        if(array_key_exists("id",$param)&&array_key_exists("goodsname",$param)&&$param['goodsname']!=""&&array_key_exists("price",$param)&&$param['price']!=""&&array_key_exists("title",$param)&&$param['title']!=""&&array_key_exists("description",$param)&&$param['description']!=""&&array_key_exists("content",$param)&&$param['content']!=""&&array_key_exists("modelid",$param)&&$param['modelid']!=""){
            $GoodM=new Goods();
            $gwhere['goodsname']=$param['goodsname'];
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
                    $backarray=array();
                    print_r($this->CreateAttrlist($item,count($item),0,$backarray));
                    print_r($specslist);
                }else{
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
    public function CreateAttrlist($array,$length,$page,$backarray)
    {
        if($length==$page){
            return $backarray;
        }else{
            array_push($backarray,$array[$page]);
            print_r($this->CreateAttrlist($array,$length,$page+1,$backarray));
            exit;

        }
    }
}
