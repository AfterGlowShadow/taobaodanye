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
use app\app\tb\Tb\common\model\Banner;
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
//            print_r($res['result']);
            $res['result']['price']=bcdiv($res['result']['price'],100,2);
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
            $bannerm=new Banner();
            $bwhere['goodsid']=$res['result']['id'];
            $bwhere['delete_time']=0;
            $bannerl=$bannerm->getList($bwhere);
            $res['result']['banner']=array();
            if(!empty($bannerl['result']['data'])){
                foreach ($bannerl['result']['data'] as $key => $value){
                    array_push($res['result']['banner'],$value['url']);
                }
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
            $bannerm=new Banner();
            $bwhere['goodsid']=$value['id'];
            $bwhere['delete_time']=0;
            $bannerl=$bannerm->getList($bwhere);
            $res['result']['data'][$key]['banner']=array();
            if(!empty($bannerl['result']['data'])){
                foreach ($bannerl['result']['data'] as $k => $v){
                    array_push($res['result']['data'][$key]['banner'],$v['url']);
                }
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
        if(array_key_exists("id",$param)&&array_key_exists("goodid",$param)){
            $classify=new Classify();
            $cwhere['id']=$param['id'];
            $classinfo=$classify->getDataItem($cwhere);
//            $classinfo['attrlist']=array();
            if(!empty($classinfo['result'])) {
                $specssm = new Specs();
                $swhere['classifyid'] = $classinfo['result']['id'];
                $specslist = $specssm->getList($swhere);
//                print_r($specslist);
                $item=array();
                $itemprice=array();
                if (!empty($specslist['result']['data'])) {
                    $attrim= new Attri();
                    foreach ($specslist['result']['data'] as $key => $value){
                        $awhere['specsid']=$value['id'];
                        $attrlist=$attrim->getList($awhere);
                        if(!empty($attrlist['result'])){
                            $specslist['result']['data'][$key]['attr']=$attrlist['result'];
                            if(!empty($attrlist['result']['data'])){
                                $temp=array();
                                foreach ($attrlist['result']['data'] as $k => $v){
                                    $gawhere=[];
                                    $gawhere[]=['goodsid','=',$param['goodid']];
                                    $gawhere[]=['attribute','like',"%".$v['name']."%"];
                                    $gattrM=new Goodattr();
                                    $fattr=$gattrM->getList($gawhere);
                                    if(!empty($fattr['result'])){
//                                        $classinfo['attrlist'][$v['id']][$value['id']]=$fattr['result'];
                                        array_push($temp,$v);
                                    }
                                }
                                if($temp){
                                    $temp1=array();
                                    $temp1['name']=$value['name'];
                                    $temp1['data']=$temp;
                                    array_push($item,$temp1);
                                }
                            }
                        }
                    }
//                    foreach ($item as $key=>$value){
//                        $item[$key]=$value['data'];
//                    }
//                    $res=$this->combination($item);
////                    print_r($res);
//                    print_r($res);
//                    exit;
//                    $classinfo['attrlist']=$itemprice;
                    $classinfo['result']['attr']=$item;
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
        $result = array();
        foreach ($array as $key => $value) {
            $item = array();
            $item['id'] = "";
            $item['attribute'] = "";
            $item['namearray'] = array();
            foreach ($value as $k => $v) {
                $item['id'] .= $v['id'] . "-";
                $item['attribute'] .= $v['name'] . "-";
                array_push($item['namearray'], $v['name']);
            }
            $item['id'] = substr($item['id'], 0, strlen($item['id']) - 1);
            $item['attribute'] = substr($item['attribute'], 0, strlen($item['attribute']) - 1);
            array_push($result, $item);
        }
        return $result;
    }
    /**
     * 获取宣传图片 只生成二维码图片不生成宣传图片
     * /app/admin/Tb.v1.Goodss.GetPublicityImg
     * goodid 商品id
     * bannerid  轮播图id
     */
    public function GetPublicityImg(){
        $param=$this->param;
        if(array_key_exists("id",$param)&&$param['id']!=""&&array_key_exists('bannerid',$param)&&$param['bannerid']!=""){
            $res=$this->getItemById();
            $res=json_decode($res->getContent(),true);
            if(!empty($res['result'])){
                if($res['result']['id']){
                    if($res['result']['qrcode']==""){
                        $url="http://shuerte.hbweipai.com/home/details.html?id=".$param['id'];
                        $res['result']['qrcode']=scerweima($url);
                    }
                    $modelM=new Model();
                    $mwhere['id']=$res['result']['modelid'];
                    $mres=$modelM->getDataItem($mwhere);
//                    $bannerM=new Banner();
//                    $bwhere['id']=$param['bannerid'];
//                    $bres=$bannerM->getDataItem($bwhere);
                    $brespath="../public".$param['bannerid'];
                    if(file_exists($brespath)){
                        $config=json_decode($mres['result']['config'],true);
                        if(strlen($res['result']['title'])>10){
                            $config['text'][0]['text']=mb_substr($res['result']['title'],0,10);
                            $config['text'][2]['text']=mb_substr($res['result']['title'],10,strlen($res['result']['title']))."...";
                        }else{
                            $config['text'][0]['text']=$res['result']['title']."...";
                        }
                        $config['text'][1]['text']="￥".$res['result']['price'];
                        $config['image'][1]['url']=$res['result']['qrcode'];
                        $config['image'][0]['url']=$brespath;
                        echo createPoster($config);
                    }else{
                        return return_json_err("生成失败",400);
                    }
                }else{
                    return return_json_err("参数错误1",400);
                }
            }else{
                return return_json_err("参数错误2",400);
            }
        }else{
            return return_json_err("缺少必要参数3",400);
        }
    }
}
