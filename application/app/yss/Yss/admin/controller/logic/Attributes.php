<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller\logic;

use app\app\yss\Yss\common\model\Attribute;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Attributes
 * @api_name Attributes
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\admin\controller\logic
 */
class Attributes extends ControllerCommon {
    protected $_route_url = '/app/admin/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Attribute();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * @api_name 获取Attributes列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Yss.v1.Attributes.getList
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

		$ind_id = isset($param['ind_id']) ? $param['ind_id'] : 0;
		$cat_ids = isset($param['cat_ids']) ? $param['cat_ids'] : '';
		$cat_price = isset($param['cat_price']) ? $param['cat_price'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Attribute */
        $m = $this->_model;
        $_where = [];
		isset($param['ind_id']) && $_where[] = ['ind_id', '=', $ind_id];
		isset($param['cat_ids']) && $_where[] = ['cat_ids', '=', $cat_ids];
		isset($param['cat_price']) && $_where[] = ['cat_price', '=', $cat_price];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];

		$_order = ['create_time' => 'DESC'];

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
	 * @api_name 获取Attributes详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Yss.v1.Attributes.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Attribute */
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
	 * @api_name 添加Attributes
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Yss.v1.Attributes.add
	 * 
	 * ind_id			工商变更id
	 * cat_ids			属性id 中划线隔开
	 * cat_price		属性钱
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Attribute */
		$m = $this->_model;
		$param = $this->param;
		
		$ind_id = isset($param['ind_id']) ? $param['ind_id'] : 0;
		$cat_ids = isset($param['cat_ids']) ? $param['cat_ids'] : '';
		$cat_price = isset($param['cat_price']) ? $param['cat_price'] : 0;
		
		$_data = [];
		$_data['ind_id'] = $ind_id;
		$_data['cat_ids'] = $cat_ids;
		$_data['cat_price'] = $cat_price;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * @api_name 更改Attributes
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Yss.v1.Attributes.edit
	 *
	 * id				
	 * ind_id			工商变更id
	 * cat_ids			属性id 中划线隔开
	 * cat_price		属性钱
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Attribute */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$ind_id = isset($param['ind_id']) ? $param['ind_id'] : 0;
		$cat_ids = isset($param['cat_ids']) ? $param['cat_ids'] : '';
		$cat_price = isset($param['cat_price']) ? $param['cat_price'] : 0;
		
		$_data = [];
		isset($param['ind_id']) && $_data['ind_id'] = $ind_id;
		isset($param['cat_ids']) && $_data['cat_ids'] = $cat_ids;
		isset($param['cat_price']) && $_data['cat_price'] = $cat_price;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * @api_name 删除Attributes
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Yss.v1.Attributes.delete
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
