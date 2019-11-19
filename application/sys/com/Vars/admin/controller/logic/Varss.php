<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Vars\admin\controller\logic;

use app\sys\com\Vars\common\model\Vars;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Varss
 * 系统变量表
 * @api_name 系统变量
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 0
 * @package app\sys\com\Vars\admin\controller\logic
 */
class Varss extends ControllerCommon {
    protected $_route_url = '/sys/admin/Vars.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Vars();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 系统变量表
	 * @api_name 获取系统变量列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Vars.v1.Varss.getList
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

		$var = isset($param['var']) ? $param['var'] : '';
		$name = isset($param['name']) ? $param['name'] : '';
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$value = isset($param['value']) ? $param['value'] : '';
		$type = isset($param['type']) ? $param['type'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Vars */
        $m = $this->_model;
        $_where = [];
		isset($param['var']) && $_where[] = ['var', '=', $var];
		isset($param['name']) && $_where[] = ['name', '=', $name];
		isset($param['intro']) && $_where[] = ['intro', '=', $intro];
		isset($param['value']) && $_where[] = ['value', '=', $value];
		isset($param['type']) && $_where[] = ['type', '=', $type];
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
	 * 系统变量表
	 * @api_name 获取系统变量详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Vars.v1.Varss.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Vars */
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
	 * 系统变量表
	 * @api_name 添加系统变量
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Vars.v1.Varss.add
	 * 
	 * var				识别变量名
	 * name				名称
	 * intro			简介
	 * value			变量值（json）
	 * type				类型（普通）
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Vars */
		$m = $this->_model;
		$param = $this->param;
		
		$var = isset($param['var']) ? $param['var'] : '';
		$name = isset($param['name']) ? $param['name'] : '';
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$value = isset($param['value']) ? $param['value'] : '';
		$type = isset($param['type']) ? $param['type'] : '';
		
		$_data = [];
		$_data['var'] = $var;
		$_data['name'] = $name;
		$_data['intro'] = $intro;
		$_data['value'] = $value;
		$_data['type'] = $type;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 系统变量表
	 * @api_name 更改系统变量
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Vars.v1.Varss.edit
	 *
	 * id				
	 * var				识别变量名
	 * name				名称
	 * intro			简介
	 * value			变量值（json）
	 * type				类型（普通）
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Vars */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$var = isset($param['var']) ? $param['var'] : '';
		$name = isset($param['name']) ? $param['name'] : '';
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$value = isset($param['value']) ? $param['value'] : '';
		$type = isset($param['type']) ? $param['type'] : '';
		
		$_data = [];
		isset($param['var']) && $_data['var'] = $var;
		isset($param['name']) && $_data['name'] = $name;
		isset($param['intro']) && $_data['intro'] = $intro;
		isset($param['value']) && $_data['value'] = $value;
		isset($param['type']) && $_data['type'] = $type;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 系统变量表
	 * @api_name 删除系统变量
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Vars.v1.Varss.delete
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
