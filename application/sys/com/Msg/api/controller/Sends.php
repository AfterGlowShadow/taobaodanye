<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Msg\api\controller;

use app\sys\com\Msg\common\model\Send;
use think\Db;

/**
 * Class Sends
 * 站内消息发送表
 * @api_name 站内消息发送
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @package app\sys\com\Msg\api\controller
 */
class Sends extends \app\sys\com\Msg\api\controller\logic\Sends {

    public function init_before() {
        parent::init_before();

        $this->need_check_token = false;
		//$this->check_token_white_list = [
		    // ['c' => 'Index', 'a' => 'test'],
		//];
    }



}
