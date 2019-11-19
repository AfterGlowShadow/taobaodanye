<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Msg\api\controller;

use app\sys\com\Msg\common\model\Text;
use think\Db;

/**
 * Class Texts
 * 站内消息内容表
 * @api_name 站内消息内容
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @package app\sys\com\Msg\api\controller
 */
class Texts extends \app\sys\com\Msg\api\controller\logic\Texts {

    public function init_before() {
        parent::init_before();

        $this->need_check_token = false;
		//$this->check_token_white_list = [
		    // ['c' => 'Index', 'a' => 'test'],
		//];
    }



}
