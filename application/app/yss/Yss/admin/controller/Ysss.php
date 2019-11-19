<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller;

use app\app\yss\Yss\common\model\Yss;
use think\Db;

/**
 * Class Ysss
 * @api_name Ysss
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\admin\controller
 */
class Ysss extends \app\app\yss\Yss\admin\controller\logic\Ysss {

    public function init_before() {
        parent::init_before();


    }

    /**
     * 获取列表
     * 卖家出售企业表
     * @api_name 获取卖家出售企业列表
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Yss.v1.Ysss.getList
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
            $where[] = ['company_name|user_name|phone', 'like', "%{$keywords}%"];
        }
        $this->_buf['getList']=[
            'link' => ['h_user'],
            'where' => $where,
        ];
        return parent::getList();
    }

}
