<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\api\controller;

use app\sys\com\Rbac\common\model\Store;
use think\Db;

/**
 * Class Stores
 * 店面表
 * @api_name 店面
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @package app\sys\com\Rbac\api\controller
 */
class Stores extends \app\sys\com\Rbac\api\controller\logic\Stores {

    public function init_before() {
        parent::init_before();

        $this->need_check_token = false;
		//$this->check_token_white_list = [
		    // ['c' => 'Index', 'a' => 'test'],
		//];
    }



}
