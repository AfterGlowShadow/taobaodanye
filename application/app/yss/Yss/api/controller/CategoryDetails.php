<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller;

use app\app\yss\Yss\common\model\CategoryDetail;
use think\Db;

/**
 * Class CategoryDetails
 * @api_name CategoryDetails
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\api\controller
 */
class CategoryDetails extends \app\app\yss\Yss\api\controller\logic\CategoryDetails {

    public function init_before() {
        parent::init_before();


    }
    /**
     * 获取分类列表
     * @api_name 获取CategoryDetails列表
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 0
     * @api_is_def_name 1
     * @api_url /app/api/Yss.v1.CategoryDetails.getTree
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getTree() {
        /** @var $m CategoryDetail */
        $m = $this->_model;
        $_order = ['pid' => 'DESC'];
        $field = '*';
        $_where = [];
        $_where[] = ['is_show','=',1];
        $re = $m->getTree($_where, $_order, $field);
        return return_json($re);
    }

    /**
     * 根据id获取分类列表
     * @api_name 获取CategoryDetails列表
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 0
     * @api_is_def_name 1
     * @api_url /app/api/Yss.v1.CategoryDetails.getTreeById
     *
     * pid
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
        if(isset($param['is_show'])) $_where[] = ['is_show', '=', $param['is_show']];

        $reList = $m->getDataList($_where, $_order);
        if (!is_return_ok($reList)) {
            return return_json($reList);
        }
        $reData = get_return_data($reList);
        $rows = $reData['data'];
        foreach ($rows as $k => &$v) {
            if($param['is_price']){
                $_wh = [];
                $_wh[] = ['a.pid', '=', $v['id']];
                $_field = "a.id as aid,a.name as name,b.title_desc,b.price";
                $datas = $m->alias('a')->where($_wh)->join('wp_app_yss_industry b','a.id=b.cat_second_id')->field($_field)->order('b.price asc')->find();
            }else{
                $_wh = [];
                $_wh[] = ['pid', '=', $v['id']];
                $reList = $m->getDataList($_wh, $_order);
                if (!is_return_ok($reList)) {
                    return return_json($reList);
                }
                $reData = get_return_data($reList);
                $datas = $reData['data'];
            }
            $v['children'] = $datas;
        }
        return return_json($rows);
    }


    /**
     * 根据id获取分类详情
     * @api_name 获取CategoryDetails列表
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 0
     * @api_is_def_name 1
     * @api_url /app/api/Yss.v1.CategoryDetails.getDetailById
     *
     * pid
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getDetailById() {

    }

}
