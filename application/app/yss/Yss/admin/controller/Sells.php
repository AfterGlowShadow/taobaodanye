<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller;

use app\app\yss\Yss\common\model\Sell;
use think\Db;

/**
 * Class Sells
 * @api_name Sells
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\admin\controller
 */
class Sells extends \app\app\yss\Yss\admin\controller\logic\Sells {

    public function init_before() {
        parent::init_before();


    }

    /**
     * 获取列表
     * 买家求购企业表
     * @api_name 获取买家求购企业列表
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Yss.v1.Sells.getList
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getList() {
        $param = $this->param;
        $where = [];
        if (isset($param['keywords'])) {
            $keywords = $param['keywords'];
            $where[] = ['title|phone', 'like', "%{$keywords}%"];
        }
        $this->_buf['getList']=[
            'where' => $where,
        ];
        return parent::getList();
    }

}
