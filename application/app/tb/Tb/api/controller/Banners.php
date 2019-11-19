<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\api\controller;

use app\app\tb\Tb\common\model\Banner;
use think\Db;

/**
 * Class Banners
 * 轮播图
 * @api_name 轮播图
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Tb\api\controller
 */
class Banners extends \app\app\tb\Tb\api\controller\logic\Banners {

    public function init_before() {
        parent::init_before();


    }



}
