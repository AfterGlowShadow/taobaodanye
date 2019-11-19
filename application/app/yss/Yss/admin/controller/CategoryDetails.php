<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller;

use app\app\yss\Yss\common\model\CategoryDetail;
use think\Db;

/**
 * Class CategoryDetails
 * @api_name CategoryDetails
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\admin\controller
 */
class CategoryDetails extends \app\app\yss\Yss\admin\controller\logic\CategoryDetails
{

    public function init_before()
    {
        parent::init_before();


    }

    /**
     * 获取列表
     * @api_name 获取CategoryDetails列表
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 0
     * @api_is_def_name 1
     * @api_url /app/admin/Yss.v1.CategoryDetails.getTree
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getTree()
    {
        /** @var $m CategoryDetail */
        $m = $this->_model;
        $_order = ['id' => 'DESC'];
        $field = '*';
        $_where = [];
        $re = $m->getTree($_where, $_order, $field);
        return return_json($re);
    }

    /**
     * 根据id获取分类列表
     * @api_name 获取CategoryDetails列表
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 0
     * @api_is_def_name 1
     * @api_url /app/admin/Yss.v1.CategoryDetails.getTreeById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getTreeById() {
        /** @var $m CategoryDetail */
        $m = $this->_model;
        $param = $this->param;
        $_order = ['id' => 'DESC'];
        $_where = [];
        $_where[] = ['pid', '=', $param['pid']];

        $reList = $m->getDataList($_where, $_order);
        if (!is_return_ok($reList)) {
           return return_json($reList);
        }
        if(isset($param['get_son']) && $param['get_son'] > 0){
            $reData = get_return_data($reList);
            $rows = $reData['data'];
            foreach ($rows as $k => &$v) {
                $_wh = [];
                $_wh[] = ['pid', '=', $v['id']];
                $reList1 = $m->getDataList($_wh, $_order);
                if (!is_return_ok($reList1)) {
                    return return_json($reList1);
                }
                $reData1 = get_return_data($reList1);
                $v['children'] = $reData1['data'];
            }
            return rjData($rows);
        }else{
            return return_json($reList);
        }

    }
}
