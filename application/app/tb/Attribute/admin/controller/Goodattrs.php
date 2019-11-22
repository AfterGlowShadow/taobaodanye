<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\admin\controller;

use app\app\tb\Attribute\common\model\Goodattr;
use think\Db;

/**
 * Class Goodattrs
 * 货物规格中间表
 * @api_name 货物规格
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Attribute\admin\controller
 */
class Goodattrs extends \app\app\tb\Attribute\admin\controller\logic\Goodattrs {

    public function init_before() {
        parent::init_before();
    }



}
