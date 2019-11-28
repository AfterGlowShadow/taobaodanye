<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\admin\controller;

use app\app\tb\Attribute\common\model\Attri;
use app\app\tb\Attribute\common\model\Classify;
use app\app\tb\Attribute\common\model\Specs;
use app\app\tb\Attribute\common\validate\vbase\Classify as ClassifyValidate;
use think\Db;

/**
 * Class Classifys
 * 商品分类
 * @api_name 分类
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Attribute\admin\controller
 */
class Classifys extends \app\app\tb\Attribute\admin\controller\logic\Classifys {

    public function init_before() {
        parent::init_before();


    }
    /**
     * 添加
     * 商品分类
     * @api_name 添加分类
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Attribute.v1.Classifys.add
     *
     * name				产品分类名称
     * pga				父亲分类id
     * level			层级(表明第几层)
     * @return mixed|string
     */
    public function addClass() {
        $param = $this->param;
        if(array_key_exists("name",$param)&&$param['name']!="") {
            $where[] = ['name', '=', $param['name']];
            $where[] = ['delete_time', '=', 0];
            $classM=new Classify();
            $res = $classM->getDataItem($where);
            if (!empty($res['result'])) {
                return rjData("此分类已经存在");
            } else {
                return parent::add();
            }
        }else{
            return rjData("缺少参数");
        }
    }
    /**
     * 更改
     * 商品分类
     * @api_name 更改分类
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Attribute.v1.Classifys.edit
     *
     * id
     * name				产品分类名称
     * pga				父亲分类id
     * level			层级(表明第几层)
     * @return mixed|string
     */
    public function editClass() {
        $param = $this->param;
        if(array_key_exists("name",$param)&&$param['name']!=""){
            $where[]=['name','=',$param['name']];
            $where[]=['delete_time','=',0];
            $classM=new Classify();
            $res = $classM->getDataItem($where);
            if(!empty($res['result'])){
                return rjData("此分类已经存在");
            }else{
                return parent::edit();
            }
        }else{
            return rjData("缺少参数");
        }
    }
    /**
     * 获取列表
     * 商品分类
     * @api_name 获取分类列表
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Attribute.v1.Classifys.getList
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getListM() {
        $res=parent::getList();
        $res=json_decode($res->getContent(),true);
        if(!empty($res['result'])){
            foreach ($res['result']['data'] as $key => $value){
                $specsM=new Specs();
                $shwere['classifyid']=$value['id'];
                $sres=$specsM->getList($shwere);
                $res['result']['data'][$key]['atype']=1;
                if(!empty($sres['result']['data'])){
                    $res['result']['data'][$key]['children']=$sres['result']['data'];
                    $Attrim=new Attri();
                    foreach ($sres['result']['data'] as $k => $v){
                        $awhere['specsid']=$v['id'];
                        $res['result']['data'][$key]['children'][$k]['atype']=2;
                        $res['result']['data'][$key]['children'][$k]['upid']=$value['id'];
                        $ares=$Attrim->getList($awhere);
                        if(!empty($ares['result']['data'])){
                            foreach ($ares['result']['data'] as $k1 => $v1){
                                $ares['result']['data'][$k1]['atype']=3;
                                $ares['result']['data'][$k1]['upid']=$v['id'];
                            }
                            $res['result']['data'][$key]['children'][$k]['children']=$ares['result']['data'];
                        }
                    }
                }
            }
            return rjData($res);
        }else{
            return rjData($res);
        }
    }
}
