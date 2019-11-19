<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\admin\controller\logic;

use app\sys\com\Rbac\common\model\UserStore;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class UserStores
 * 管理员店面关联表
 * @api_name 管理员店面关联
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Rbac\admin\controller\logic
 */
class UserStores extends ControllerCommon {
    protected $_route_url = '/sys/admin/Rbac.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new UserStore();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 管理员店面关联表
	 * @api_name 获取管理员店面关联列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.UserStores.getList
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
		$store_id = isset($param['store_id']) ? $param['store_id'] : 0;
		$identity_type = isset($param['identity_type']) ? $param['identity_type'] : 0;

        /** @var $m UserStore */
        $m = $this->_model;
        $_where = [];
		isset($param['user_id']) && $_where[] = ['user_id', '=', $user_id];
		isset($param['store_id']) && $_where[] = ['store_id', '=', $store_id];
		isset($param['identity_type']) && $_where[] = ['identity_type', '=', $identity_type];

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
	 * 管理员店面关联表
	 * @api_name 获取管理员店面关联详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.UserStores.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m UserStore */
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
	 * 管理员店面关联表
	 * @api_name 添加管理员店面关联
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.UserStores.add
	 * 
	 * user_id				用户id
	 * store_id				店面id
	 * identity_type		身份类型（0-未知 1-店长 2-店员）
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m UserStore */
		$m = $this->_model;
		$param = $this->param;
		
		$user_id = isset($param['user_id']) ? $param['user_id'] : 0;
		$store_id = isset($param['store_id']) ? $param['store_id'] : 0;
		$identity_type = isset($param['identity_type']) ? $param['identity_type'] : 0;
		
		$_data = [];
		$_data['user_id'] = $user_id;
		$_data['store_id'] = $store_id;
		$_data['identity_type'] = $identity_type;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 管理员店面关联表
	 * @api_name 更改管理员店面关联
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.UserStores.edit
	 *
	 * id					
	 * user_id				用户id
	 * store_id				店面id
	 * identity_type		身份类型（0-未知 1-店长 2-店员）
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m UserStore */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$user_id = isset($param['user_id']) ? $param['user_id'] : 0;
		$store_id = isset($param['store_id']) ? $param['store_id'] : 0;
		$identity_type = isset($param['identity_type']) ? $param['identity_type'] : 0;
		
		$_data = [];
		isset($param['user_id']) && $_data['user_id'] = $user_id;
		isset($param['store_id']) && $_data['store_id'] = $store_id;
		isset($param['identity_type']) && $_data['identity_type'] = $identity_type;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 管理员店面关联表
	 * @api_name 删除管理员店面关联
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.UserStores.delete
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
