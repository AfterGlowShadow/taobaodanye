<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\admin\controller;

use app\app\tb\Tb\common\model\Banner;
use think\Db;

/**
 * Class Banners
 * 轮播图
 * @api_name 轮播图
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Tb\admin\controller
 */
class Banners extends \app\app\tb\Tb\admin\controller\logic\Banners {

    public function init_before() {
        parent::init_before();


    }

    /**
     * Created by PhpStorm.
     * 根据商品ID获得轮播图
     */
    public function GetListM(){
        $param=$this->param;
        if(array_key_exists("goodid",$param)&&$param['goodid']!=""){
            $bannerm=new Banner();
            $bwhere['goodsid']=$param['goodid'];
            $res=$bannerm->getList($bwhere);
            return return_json($res);
        }else{
            return return_json_err("缺少必要参数",400);
        }
    }


}
