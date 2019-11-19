<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\api\controller;

use app\sys\com\User\common\model\ShareRecord;
use think\Db;

/**
 * Class ShareRecords
 * 用户分享记录表
 * @api_name 用户分享记录
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 0
 * @package app\sys\com\User\api\controller
 */
class ShareRecords extends \app\sys\com\User\api\controller\logic\ShareRecords {

    public function init_before() {
        parent::init_before();

        $this->need_check_token = false;
		//$this->check_token_white_list = [
		    // ['c' => 'Index', 'a' => 'test'],
		//];
    }



}
