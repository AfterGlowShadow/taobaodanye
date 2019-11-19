<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller;

use app\app\yss\Yss\common\model\Boutique;
use think\Db;

/**
 * Class Boutiques
 * 精选服务表
 * @api_name 精选服务
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\admin\controller
 */
class Boutiques extends \app\app\yss\Yss\admin\controller\logic\Boutiques {

    public function init_before() {
        parent::init_before();


    }

    /**
     * 获取列表
     * 精选服务表
     * @api_name 获取精选服务列表
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Yss.v1.Boutiques.getList
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
            $where[] = ['title', 'like', "%{$keywords}%"];
        }
        $this->_buf['getList']=[
            'where' => $where,
        ];
        return parent::getList();
    }

}
