<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller\logic;

use app\app\yss\Yss\common\model\Combo;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Combos
 * 套餐表
 * @api_name 套餐
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\api\controller\logic
 */
class Combos extends ControllerCommon {
    protected $_route_url = '/app/api/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Combo();

        // $this->need_check_token = false;
        // $this->check_token_white_list = [
        //     ['c' => 'Index', 'a' => 'test'],
        // ];
    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 套餐表
	 * @api_name 获取套餐列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Combos.getList
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
		$cat_ids = isset($param['cat_ids']) ? $param['cat_ids'] : '';
		$cat_names = isset($param['cat_names']) ? $param['cat_names'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Combo */
        $m = $this->_model;
        $_where = [];
		isset($param['name']) && $_where[] = ['name', '=', $name];
		isset($param['cat_ids']) && $_where[] = ['cat_ids', '=', $cat_ids];
		isset($param['cat_names']) && $_where[] = ['cat_names', '=', $cat_names];
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
	 * 套餐表
	 * @api_name 获取套餐详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Combos.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Combo */
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
	 * 套餐表
	 * @api_name 添加套餐
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Combos.add
	 * 
	 * name				名称
	 * cat_ids			所有子分类id
	 * cat_names		所有子分类名
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Combo */
		$m = $this->_model;
		$param = $this->param;
		
		$name = isset($param['name']) ? $param['name'] : '';
		$cat_ids = isset($param['cat_ids']) ? $param['cat_ids'] : '';
		$cat_names = isset($param['cat_names']) ? $param['cat_names'] : '';
		
		$_data = [];
		$_data['name'] = $name;
		$_data['cat_ids'] = $cat_ids;
		$_data['cat_names'] = $cat_names;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 套餐表
	 * @api_name 更改套餐
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Combos.edit
	 *
	 * id				
	 * name				名称
	 * cat_ids			所有子分类id
	 * cat_names		所有子分类名
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Combo */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$name = isset($param['name']) ? $param['name'] : '';
		$cat_ids = isset($param['cat_ids']) ? $param['cat_ids'] : '';
		$cat_names = isset($param['cat_names']) ? $param['cat_names'] : '';
		
		$_data = [];
		isset($param['name']) && $_data['name'] = $name;
		isset($param['cat_ids']) && $_data['cat_ids'] = $cat_ids;
		isset($param['cat_names']) && $_data['cat_names'] = $cat_names;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 套餐表
	 * @api_name 删除套餐
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Combos.delete
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
