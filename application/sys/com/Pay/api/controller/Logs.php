<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Pay\api\controller;

use app\sys\com\Pay\common\model\Log;
use think\Db;

/**
 * Class Logs
 * 支付表
 * @api_name 支付记录
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Pay\api\controller
 */
class Logs extends \app\sys\com\Pay\api\controller\logic\Logs {

    public function init_before() {
        parent::init_before();


    }



}
