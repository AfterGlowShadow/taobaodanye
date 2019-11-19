<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller;

use app\app\yss\Yss\common\model\Faceback;
use think\Db;

/**
 * Class Facebacks
 * @api_name Facebacks
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\api\controller
 */
class Facebacks extends \app\app\yss\Yss\api\controller\logic\Facebacks {

    public function init_before() {
        parent::init_before();


    }
    /**
     * 添加
     * 投诉建议表
     * @api_name 添加投诉建议
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Facebacks.add
     *
     * content			建议
     * uid				用户id
     * status			1已读 0未读
     * type				1投诉 2建议
     * nickname			称呼
     * phone			手机号
     * @return mixed|string
     */
    public function add() {
        $this->param['uid'] = $this->uid;
        return parent::add();
    }


}
