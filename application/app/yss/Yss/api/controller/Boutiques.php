<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller;

use app\app\yss\Yss\common\model\Boutique;
use think\Db;

/**
 * Class Boutiques
 * 精选服务表
 * @api_name 精选服务
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\api\controller
 */
class Boutiques extends \app\app\yss\Yss\api\controller\logic\Boutiques {

    public function init_before() {
        parent::init_before();


    }



}
