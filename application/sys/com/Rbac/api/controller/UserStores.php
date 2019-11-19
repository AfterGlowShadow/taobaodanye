<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\api\controller;

use app\sys\com\Rbac\common\model\UserStore;
use think\Db;

/**
 * Class UserStores
 * 管理员店面关联表
 * @api_name 管理员店面关联
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @package app\sys\com\Rbac\api\controller
 */
class UserStores extends \app\sys\com\Rbac\api\controller\logic\UserStores {

    public function init_before() {
        parent::init_before();

        $this->need_check_token = false;
		//$this->check_token_white_list = [
		    // ['c' => 'Index', 'a' => 'test'],
		//];
    }



}
