<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\api\controller;

use app\app\tb\Attribute\common\model\Goodattr;
use think\Db;

/**
 * Class Goodattrs
 * 货物规格中间表
 * @api_name 货物规格
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Attribute\api\controller
 */
class Goodattrs extends \app\app\tb\Attribute\api\controller\logic\Goodattrs {

    public function init_before() {
        parent::init_before();


    }

    /**
     * 获取详情 通过id查询
     * 货物规格中间表
     * @api_name 获取货物规格详情
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Attribute.v1.Goodattrs.getItemByName
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemByName() {
        $param=$this->param;
         if(array_key_exists("goodsid",$param)&&$param['goodsid']!=""&&array_key_exists("attriname",$param)&&$param['attriname']!=""){
            $awhere['goodsid']=$param['goodsid'];
            $awhere['attribute']=$param['attriname'];
            $goodaM=new Goodattr();
            $res=$goodaM->getItem($awhere);
            if($res['result']){
                $res['result']['price']=bcdiv($res['result']['price'],100,2);
                return rjData($res);
            }else{
                return return_json_err("没有此规格",200);
            }
         }else{
             return return_json_err("参数错误",400);
         }
    }
}
