<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller;

use app\app\yss\Yss\common\model\Customer;
use think\Db;

/**
 * Class Customers
 * @api_name Customers
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\api\controller
 */
class Customers extends \app\app\yss\Yss\api\controller\logic\Customers {

    public function init_before() {
        parent::init_before();


    }



}
