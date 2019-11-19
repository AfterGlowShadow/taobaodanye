<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller\logic;

use app\app\yss\Yss\common\model\CategoryDetail;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class CategoryDetails
 * 三级分类表
 * @api_name 三级分类
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\admin\controller\logic
 */
class CategoryDetails extends ControllerCommon {
    protected $_route_url = '/app/admin/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new CategoryDetail();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 三级分类表
	 * @api_name 获取三级分类列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.CategoryDetails.getList
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getList() {
        $param = $this->param;

        $page_num = isset($param['page_num']) ? $param['page_num'] : 1;
        $page_limit = isset($param['page_limit']) ? $param['page_limit'] : PHP_INT_MAX;

		$name = isset($param['name']) ? $param['name'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$pid = isset($param['pid']) ? $param['pid'] : 0;
		$is_show = isset($param['is_show']) ? $param['is_show'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;

        /** @var $m CategoryDetail */
        $m = $this->_model;
        $_where = [];
		isset($param['name']) && $_where[] = ['name', '=', $name];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['pid']) && $_where[] = ['pid', '=', $pid];
		isset($param['is_show']) && $_where[] = ['is_show', '=', $is_show];
		isset($param['type']) && $_where[] = ['type', '=', $type];

		$_order = [];

        $_field = isset($this->_buf['getList']['field']) ? $this->_buf['getList']['field'] : '*';
        $_link = isset($this->_buf['getList']['link']) ? $this->_buf['getList']['link'] : false;
        $_join = isset($this->_buf['getList']['join']) ? $this->_buf['getList']['join'] : [];
        $_where = isset($this->_buf['getList']['where']) ? array_merge($_where, $this->_buf['getList']['where']) : $_where;
        $_order = isset($this->_buf['getList']['order']) ? $this->_buf['getList']['order'] : $_order;
        $_param = isset($this->_buf['getList']['param']) ? $this->_buf['getList']['param'] : [];
        $re = $m->getList($_where, $_order, $page_num, $page_limit, $_field, $_link, $_join, $_param);
        if (!is_return_ok($re)) {
            return return_json($re);
        }

        $reData = get_return_data($re);
        return rjData($reData);
    }

    /**
     * 获取详情 通过id查询
	 * 三级分类表
	 * @api_name 获取三级分类详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.CategoryDetails.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m CategoryDetail */
        $m = $this->_model;
        $param = $this->param;

        $id = isset($param['id']) ? $param['id'] : 0;

        $_field = isset($this->_buf['getItemById']['field']) ? $this->_buf['getItemById']['field'] : '*';
        $_link = isset($this->_buf['getItemById']['link']) ? $this->_buf['getItemById']['link'] : false;
        $_join = isset($this->_buf['getItemById']['join']) ? $this->_buf['getItemById']['join'] : [];
        $_param = isset($this->_buf['getItemById']['param']) ? $this->_buf['getItemById']['param'] : [];
        $re = $m->getItemById($id, $_field, $_link, $_join, $_param);
        if (!is_return_ok($re)) {
            return return_json($re);
        }

        $reData = get_return_data($re);

        return rjData($reData);
    }

	/**
	 * 添加
	 * 三级分类表
	 * @api_name 添加三级分类
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.CategoryDetails.add
	 * 
	 * name				分类值
	 * pid				上级id
	 * is_show			是否导航显示
	 * type				0
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m CategoryDetail */
		$m = $this->_model;
		$param = $this->param;
		
		$name = isset($param['name']) ? $param['name'] : '';
		$pid = isset($param['pid']) ? $param['pid'] : 0;
		$is_show = isset($param['is_show']) ? $param['is_show'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		
		$_data = [];
		$_data['name'] = $name;
		$_data['pid'] = $pid;
		$_data['is_show'] = $is_show;
		$_data['type'] = $type;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 三级分类表
	 * @api_name 更改三级分类
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.CategoryDetails.edit
	 *
	 * id				
	 * name				分类值
	 * pid				上级id
	 * is_show			是否导航显示
	 * type				0
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m CategoryDetail */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$name = isset($param['name']) ? $param['name'] : '';
		$pid = isset($param['pid']) ? $param['pid'] : 0;
		$is_show = isset($param['is_show']) ? $param['is_show'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		
		$_data = [];
		isset($param['name']) && $_data['name'] = $name;
		isset($param['pid']) && $_data['pid'] = $pid;
		isset($param['is_show']) && $_data['is_show'] = $is_show;
		isset($param['type']) && $_data['type'] = $type;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 三级分类表
	 * @api_name 删除三级分类
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.CategoryDetails.delete
     *
     * id
     * @return \think\response\Json
     * @throws \Throwable
     * @throws \think\Exception\DbException
     */
    public function delete() {
        return parent::delete();
    }



}
