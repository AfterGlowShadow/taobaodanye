<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\api\controller;

use app\app\tb\Attribute\common\model\Attrigood;
use think\Db;

/**
 * Class Attrigoods
 * 货物规格中间表(规格没有排列组合的 只为了根据规格添加图片)
 * @api_name 货物规格
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Attribute\api\controller
 */
class Attrigoods extends \app\app\tb\Attribute\api\controller\logic\Attrigoods {

    public function init_before() {
        parent::init_before();


    }



}
