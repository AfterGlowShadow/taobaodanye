<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\api\controller\logic;

use app\sys\com\Rbac\common\model\Role;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Roles
 * 权限角色表
 * @api_name 角色
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Rbac\api\controller\logic
 */
class Roles extends ControllerCommon {
    protected $_route_url = '/sys/api/Rbac.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Role();

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
	 * 权限角色表
	 * @api_name 获取角色列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Rbac.v1.Roles.getList
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
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Role */
        $m = $this->_model;
        $_where = [];
		isset($param['name']) && $_where[] = ['name', '=', $name];
		isset($param['intro']) && $_where[] = ['intro', '=', $intro];
		isset($param['type']) && $_where[] = ['type', '=', $type];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['remark']) && $_where[] = ['remark', '=', $remark];
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
	 * 权限角色表
	 * @api_name 获取角色详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Rbac.v1.Roles.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Role */
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
	 * 权限角色表
	 * @api_name 添加角色
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Rbac.v1.Roles.add
	 * 
	 * name				用户名
	 * intro			简介
	 * type				类型（0-未知 1-通用）
	 * status			状态,1启用 0禁用
	 * remark			备注
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Role */
		$m = $this->_model;
		$param = $this->param;
		
		$name = isset($param['name']) ? $param['name'] : '';
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		
		$_data = [];
		$_data['name'] = $name;
		$_data['intro'] = $intro;
		$_data['type'] = $type;
		$_data['status'] = $status;
		$_data['remark'] = $remark;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 权限角色表
	 * @api_name 更改角色
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Rbac.v1.Roles.edit
	 *
	 * id				
	 * name				用户名
	 * intro			简介
	 * type				类型（0-未知 1-通用）
	 * status			状态,1启用 0禁用
	 * remark			备注
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Role */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$name = isset($param['name']) ? $param['name'] : '';
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		
		$_data = [];
		isset($param['name']) && $_data['name'] = $name;
		isset($param['intro']) && $_data['intro'] = $intro;
		isset($param['type']) && $_data['type'] = $type;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['remark']) && $_data['remark'] = $remark;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 权限角色表
	 * @api_name 删除角色
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Rbac.v1.Roles.delete
     *
     * id
     * @return \think\response\Json
     * @throws \Throwable
     * @throws \think\Exception\DbException
     */
    public function delete() {
        return parent::delete();
    }

	
	/**
	 * 更改状态
	 * 权限角色表
	 * @api_name 更改角色状态
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Rbac.v1.Roles.setStatus
	 *
	 * id				
	 * status			状态,1启用 0禁用
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Role */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $this->p('id');
		$status = $this->p('status');
		
		$_d = [];
		$_d['status'] = $status;
		$re = $m->editById($id, $_d);
		return return_json($re);
	}

}
