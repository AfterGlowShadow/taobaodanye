<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Slide\api\controller;

use app\sys\com\Slide\common\model\Slide;
use think\Db;

/**
 * Class Slides
 * 站内消息内容表
 * @api_name 站内消息内容
 * @api_type 3
 * @api_is_menu 1
 * @api_is_maker 1
 * @api_is_def_name 0
 * @package app\sys\com\Slide\api\controller
 */
class Slides extends \app\sys\com\Slide\api\controller\logic\Slides {

    public function init_before() {
        parent::init_before();

        $this->need_check_token = false;
		//$this->check_token_white_list = [
		    // ['c' => 'Index', 'a' => 'test'],
		//];
    }



}
