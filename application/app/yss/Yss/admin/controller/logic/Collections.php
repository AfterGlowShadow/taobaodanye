<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller\logic;

use app\app\yss\Yss\common\model\Collection;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Collections
 * 用户收藏表
 * @api_name 用户收藏
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\admin\controller\logic
 */
class Collections extends ControllerCommon {
    protected $_route_url = '/app/admin/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Collection();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 用户收藏表
	 * @api_name 获取用户收藏列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Collections.getList
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

		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$product_id = isset($param['product_id']) ? $param['product_id'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Collection */
        $m = $this->_model;
        $_where = [];
		isset($param['uid']) && $_where[] = ['uid', '=', $uid];
		isset($param['product_id']) && $_where[] = ['product_id', '=', $product_id];
		isset($param['type']) && $_where[] = ['type', '=', $type];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];

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
	 * 用户收藏表
	 * @api_name 获取用户收藏详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Collections.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Collection */
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
	 * 用户收藏表
	 * @api_name 添加用户收藏
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Collections.add
	 * 
	 * uid				用户
	 * product_id		收藏的企业或服务id
	 * type				1企业 2服务
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Collection */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$product_id = isset($param['product_id']) ? $param['product_id'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		
		$_data = [];
		$_data['uid'] = $uid;
		$_data['product_id'] = $product_id;
		$_data['type'] = $type;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 用户收藏表
	 * @api_name 更改用户收藏
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Collections.edit
	 *
	 * id				
	 * uid				用户
	 * product_id		收藏的企业或服务id
	 * type				1企业 2服务
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Collection */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$product_id = isset($param['product_id']) ? $param['product_id'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		
		$_data = [];
		isset($param['uid']) && $_data['uid'] = $uid;
		isset($param['product_id']) && $_data['product_id'] = $product_id;
		isset($param['type']) && $_data['type'] = $type;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 用户收藏表
	 * @api_name 删除用户收藏
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Collections.delete
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
