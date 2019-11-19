<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller;

use app\app\yss\Yss\common\model\CategoryDetail;
use app\app\yss\Yss\common\model\Industry;
use think\Db;

/**
 * Class Industrys
 * 工商服务表
 * @api_name 工商服务
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\api\controller
 */
class Industrys extends \app\app\yss\Yss\api\controller\logic\Industrys
{

    public function init_before()
    {
        parent::init_before();


    }

    /**
     * 获取详情 通过id查询
     * 工商服务表
     * @api_name 获取工商服务详情
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Industrys.getDetailById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getDetailById()
    {
        /** @var $m Industry */
        $m = $this->_model;
       return return_json($m->getDetailById($this->p('id')));
    }
}
