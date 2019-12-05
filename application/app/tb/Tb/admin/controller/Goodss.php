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
use app\app\tb\Tb\common\model\Banner;
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

        if(array_key_exists("banners",$param)&&$param['banners']!=""&&array_key_exists("goodsname",$param)&&$param['goodsname']!=""&&array_key_exists("classify",$param)&&$param['classify']!=""&&array_key_exists("price",$param)&&$param['price']!=""&&array_key_exists("title",$param)&&$param['title']!=""&&array_key_exists("description",$param)&&$param['description']!=""&&array_key_exists("content",$param)&&$param['content']!=""){
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

                                if(!empty($param['banners'])){
                                    $bannerM=new Banner();
                                    $bannerdata=$this->BannerFormat($param['banners'],$re['result']['id']);

                                    $res1=$bannerM->insertAll($bannerdata);
                                    if($res1){
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
                                $this->rollback();
                                return return_json_err("商品添加失败",400);
                            }
                        }else{
                            $this->rollback();
                            return return_json_err("必须填写规格",400);
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
            if(array_key_exists("price",$value)&&$value['price']!=""&&array_key_exists("attribute",$value)&&$value['attribute']!=""&&array_key_exists("id",$value)&&$value['id']!=""){
                $value1['pricetype']=isset($value['pricetype']) ? $value['pricetype'] : 0;
                $value1['attribute']=$value['attribute'];
                $value1['goodsid']=$id;
                $value1['attrid']=$value['id'];
                $value1['price']=bcmul($value['price'],100,0);;
                array_push( $back,$value1);
            }
        }
        return $back;
    }
    /**
     *格式化数据 生成轮播图存储数据
     */
    public function BannerFormat($banner,$id){
        $data=array();
        $banner=json_decode($banner,true);
        foreach ($banner as $key => $value){
            $item=array();
//            if(array_key_exists("url",$value)&&$value['url']!=""){
                $item['url']=$value;
                $item['goodsid']=$id;
                array_push($data,$item);
//            }
        }
        return $data;
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
                foreach ($res['result']['specs'] as $key => $value){
                    $res['result']['specs'][$key]['price']=bcdiv($value['price'],100,2);
                }
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
        if(array_key_exists("banners",$param)&&$param['banners']!=""&&array_key_exists("goodsname",$param)&&$param['goodsname']!=""&&array_key_exists("id",$param)&&$param['id']!=""&&array_key_exists("classify",$param)&&$param['classify']!=""&&array_key_exists("price",$param)&&$param['price']!=""&&array_key_exists("title",$param)&&$param['title']!=""&&array_key_exists("description",$param)&&$param['description']!=""&&array_key_exists("content",$param)&&$param['content']!=""){
            $GoodM=new Goods();
            $gwhere[]=['goodsname','=',$param['goodsname']];
            $gwhere[]=['id','<>',$param['id']];
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
                            $GoodattrM->where($gawhere)->delete();
                            $res4=$GoodattrM->insertAll($specsarray);
                            $bannerM=new Banner();
                            $bdwhere['goodsid']=$param['id'];
                            $bannerM->where($bdwhere)->delete();
                            $bannerdata=$this->BannerFormat($param['banners'],$param['id']);
                            if(!empty($bannerdata)){
                                $res2=$bannerM->insertAll($bannerdata);
                            }else{
                                $res2=true;
                            }
                            if($res4&&$res2){
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
    //图片上传
    ///app/admin/Tb.v1.Goodss.UpfileImg
    public function UpfileImg()
    {
        $file = request()->file('image');
        $info = $file->move( '../../../../../public/Upload/Pic');
        if($info){
            $fileres=explode("\\",$info->getSaveName());
            $res="http://".request()->host()."/Upload/".$fileres[0]."/".$fileres[1];
            $data['url']=$res;
            $data['bkurl']="/Upload/".$fileres[0]."/".$fileres[1];
            return rjData($data);
        }else{
            return return_json_err("上传失败",400);
        }
    }
}
