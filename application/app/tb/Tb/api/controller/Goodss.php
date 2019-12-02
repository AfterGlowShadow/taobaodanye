<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\api\controller;

use app\app\tb\Attribute\common\model\Attri;
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
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Tb\api\controller
 */
class Goodss extends \app\app\tb\Tb\api\controller\logic\Goodss {

    public function init_before() {
        parent::init_before();


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
     * @api_url /app/api/Tb.v1.Goodss.getItemByIdM
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
     * @api_url /app/api/Tb.v1.Goodss.getListM
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
     * 获得宣传页信息
     * @api_name 获得宣传页信息
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Tb.v1.Goodss.GetSGood
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
     * @api_url /app/api/Tb.v1.Goodss.AttrisArray
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
}
