<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\admin\controller;

use app\app\tb\Attribute\common\model\Attri;
use app\app\tb\Attribute\common\model\Specs;
use think\Db;

/**
 * Class Attris
 * 商品属性
 * @api_name 属性
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Attribute\admin\controller
 */
class Attris extends \app\app\tb\Attribute\admin\controller\logic\Attris {

    public function init_before() {
        parent::init_before();
    }
    /**
     * 添加
     * 商品属性
     * @api_name 添加属性
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Attribute.v1.Attris.addAttr
     *
     * name				名称
     * specsid			所属属性id
     * userid			用户id
     * @return mixed|string
     */
    public function addAttr() {
        $param = $this->param;
        if(array_key_exists("name",$param)&&$param['name']!=""&&array_key_exists("specsid",$param)&&$param['specsid']!="") {
            $where['id']=$param['specsid'];
            $SpecsM=new Specs();
            $ishas=$SpecsM->getDataItem($where);
            if(!empty($ishas['result'])) {
                $where1[] = ['name', '=', $param['name']];
                $where1[] = ['specsid', '=', $param['specsid']];
                $where1[] = ['delete_time', '=', 0];
                $AttrM = new Attri();
                $res = $AttrM->getDataItem($where1);
                if (!empty($res['result'])) {
                    return rjData("此属性已经存在");
                } else {
                    return parent::add();
                }
            }else{
                return rjData("此规格不存在,请核实后添加");
            }
        }else{
            return rjData("缺少参数");
        }
    }
    /**
     * 更改
     * 商品属性
     * @api_name 更改属性
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Attribute.v1.Attris.editAttr
     *
     * id
     * name				名称
     * specsid			所属属性id
     * userid			用户id
     * @return mixed|string
     */
    public function editAttr() {
        $param = $this->param;
            if(array_key_exists("name",$param)&&$param['name']!=""&&array_key_exists("specsid",$param)&&$param['specsid']!="") {
            $where['id']=$param['specsid'];
            $SpecsM=new Specs();
            $ishas=$SpecsM->getDataItem($where);
            if(!empty($ishas['result'])) {
                $swhere['specsid'] = $param['specsid'];
                $swhere['name'] = $param['name'];
                $swhere['delete_time']=0;
                $AttriM = new Attri();
                $res = $AttriM->getDataItem($swhere);
                if (empty($res['result'])) {
                    return $this->edit();
                } else {
                    return rjData("此属性已经存在,请确认后修改");
                }
            }else{
                return rjData("此规格不存在,请核实后修改");
            }
        }else{
            return rjData("缺少必要参数");
        }
    }

}
