<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\admin\controller\logic;

use app\sys\com\Rbac\common\model\UserRole;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class UserRoles
 * 管理员角色关联表
 * @api_name 管理员角色关联
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Rbac\admin\controller\logic
 */
class UserRoles extends ControllerCommon {
    protected $_route_url = '/sys/admin/Rbac.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new UserRole();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 管理员角色关联表
	 * @api_name 获取管理员角色关联列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.UserRoles.getList
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

		$user_id = isset($param['user_id']) ? $param['user_id'] : 0;
		$role_id = isset($param['role_id']) ? $param['role_id'] : 0;

        /** @var $m UserRole */
        $m = $this->_model;
        $_where = [];
		isset($param['user_id']) && $_where[] = ['user_id', '=', $user_id];
		isset($param['role_id']) && $_where[] = ['role_id', '=', $role_id];

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
	 * 管理员角色关联表
	 * @api_name 获取管理员角色关联详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.UserRoles.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m UserRole */
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
	 * 管理员角色关联表
	 * @api_name 添加管理员角色关联
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.UserRoles.add
	 * 
	 * user_id			用户id
	 * role_id			角色id
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m UserRole */
		$m = $this->_model;
		$param = $this->param;
		
		$user_id = isset($param['user_id']) ? $param['user_id'] : 0;
		$role_id = isset($param['role_id']) ? $param['role_id'] : 0;
		
		$_data = [];
		$_data['user_id'] = $user_id;
		$_data['role_id'] = $role_id;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 管理员角色关联表
	 * @api_name 更改管理员角色关联
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.UserRoles.edit
	 *
	 * id				
	 * user_id			用户id
	 * role_id			角色id
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m UserRole */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$user_id = isset($param['user_id']) ? $param['user_id'] : 0;
		$role_id = isset($param['role_id']) ? $param['role_id'] : 0;
		
		$_data = [];
		isset($param['user_id']) && $_data['user_id'] = $user_id;
		isset($param['role_id']) && $_data['role_id'] = $role_id;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 管理员角色关联表
	 * @api_name 删除管理员角色关联
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.UserRoles.delete
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
