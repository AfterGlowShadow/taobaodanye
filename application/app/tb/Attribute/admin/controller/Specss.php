<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\admin\controller;

use app\app\tb\Attribute\common\model\Classify;
use app\app\tb\Attribute\common\model\Specs;
use think\Db;

/**
 * Class Specss
 * 商品规格
 * @api_name 规格
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Attribute\admin\controller
 */
class Specss extends \app\app\tb\Attribute\admin\controller\logic\Specss {

    public function init_before() {
        parent::init_before();


    }

    /**
     * 添加
     * 商品规格
     * @api_name 添加规格
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Attribute.v1.Specss.add
     *
     * name                规格名称
     * classifyid        所属分类id
     * @return mixed|string
     * @throws \think\Exception
     */
    public function addSpecss() {
        $param = $this->param;
        if(array_key_exists("classifyid",$param)&&$param['classifyid']!=""&&array_key_exists("name",$param)&&$param['name']!=""){
            $where['id']=$param['classifyid'];
            $classifysM=new Classify();
            $ishas=$classifysM->getItem($where);
            if(!empty($ishas['result'])){
                $swhere['classifyid']=$param['classifyid'];
                $swhere['name']=$param['name'];
                $swhere['delete_time']=0;
                $SpecsM=new Specs();
                $res=$SpecsM->getItem($swhere);
                if(empty($res['result'])){
                    return $this->add();
                }else{
                    return rjData("此规格已经存在,请勿重复添加");
                }
            }else{
                return rjData("此分类不存在,请核实后添加");
            }
        }else{
            return rjData("缺少必要参数");
        }
    }
    /**
     * 更改
     * 商品规格
     * @api_name 更改规格
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Attribute.v1.Specss.editSpecss
     *
     * id
     * name				规格名称
     * classifyid		所属分类id
     * userid			用户id
     * @return mixed|string
     */
    public function editSpecss() {
        $param = $this->param;
        if(array_key_exists("classifyid",$param)&&$param['classifyid']!=""&&array_key_exists("name",$param)&&$param['name']!=""){
            $where['id']=$param['classifyid'];
            $classifysM=new Classify();
            $ishas=$classifysM->getItem($where);
            if(!empty($ishas['result'])) {
                $swhere['classifyid'] = $param['classifyid'];
                $swhere['name'] = $param['name'];
                $swhere['delete_time']=0;
                $SpecsM = new Specs();
                $res = $SpecsM->getItem($swhere);
                if (empty($res['result'])) {
                    return $this->edit();
                } else {
                    return rjData("此规格已经存在,请确认后修改");
                }
            }else{
                return rjData("此分类不存在,请核实后添加");
            }
        }else{
            return rjData("缺少必要参数");
        }
    }
}
