<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\admin\controller;

use app\app\tb\Attribute\common\model\Classify;
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
}
