<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\admin\controller\logic;

use app\sys\com\Rbac\common\model\User;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Users
 * 管理员表
 * @api_name 管理员
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Rbac\admin\controller\logic
 */
class Users extends ControllerCommon {
    protected $_route_url = '/sys/admin/Rbac.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new User();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 管理员表
	 * @api_name 获取管理员列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.getList
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
		$passwd = isset($param['passwd']) ? $param['passwd'] : '';
		$nickname = isset($param['nickname']) ? $param['nickname'] : '';
		$avatar = isset($param['avatar']) ? $param['avatar'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$is_root = isset($param['is_root']) ? $param['is_root'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$pid = isset($param['pid']) ? $param['pid'] : 0;

        /** @var $m User */
        $m = $this->_model;
        $_where = [];
		isset($param['name']) && $_where[] = ['name', '=', $name];
		isset($param['passwd']) && $_where[] = ['passwd', '=', $passwd];
		isset($param['nickname']) && $_where[] = ['nickname', '=', $nickname];
		isset($param['avatar']) && $_where[] = ['avatar', '=', $avatar];
		isset($param['mobile']) && $_where[] = ['mobile', '=', $mobile];
		isset($param['is_root']) && $_where[] = ['is_root', '=', $is_root];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['pid']) && $_where[] = ['pid', '=', $pid];

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
	 * 管理员表
	 * @api_name 获取管理员详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m User */
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
	 * 管理员表
	 * @api_name 添加管理员
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.add
	 * 
	 * name				用户名
	 * passwd			密码
	 * nickname			昵称
	 * avatar			头像
	 * mobile			电话
	 * is_root			是否超级管理员（0-否 1-是）
	 * status			状态（1启用 0禁用）
	 * pid				所属的超管的id
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m User */
		$m = $this->_model;
		$param = $this->param;
		
		$name = isset($param['name']) ? $param['name'] : '';
		$passwd = isset($param['passwd']) ? $param['passwd'] : '';
		$nickname = isset($param['nickname']) ? $param['nickname'] : '';
		$avatar = isset($param['avatar']) ? $param['avatar'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$is_root = isset($param['is_root']) ? $param['is_root'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$pid = isset($param['pid']) ? $param['pid'] : 0;
		
		$_data = [];
		$_data['name'] = $name;
		$_data['passwd'] = $passwd;
		$_data['nickname'] = $nickname;
		$_data['avatar'] = $avatar;
		$_data['mobile'] = $mobile;
		$_data['is_root'] = $is_root;
		$_data['status'] = $status;
		$_data['pid'] = $pid;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 管理员表
	 * @api_name 更改管理员
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.edit
	 *
	 * id				
	 * name				用户名
	 * passwd			密码
	 * nickname			昵称
	 * avatar			头像
	 * mobile			电话
	 * is_root			是否超级管理员（0-否 1-是）
	 * status			状态（1启用 0禁用）
	 * pid				所属的超管的id
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m User */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$name = isset($param['name']) ? $param['name'] : '';
		$passwd = isset($param['passwd']) ? $param['passwd'] : '';
		$nickname = isset($param['nickname']) ? $param['nickname'] : '';
		$avatar = isset($param['avatar']) ? $param['avatar'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$is_root = isset($param['is_root']) ? $param['is_root'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$pid = isset($param['pid']) ? $param['pid'] : 0;
		
		$_data = [];
		isset($param['name']) && $_data['name'] = $name;
		isset($param['passwd']) && $_data['passwd'] = $passwd;
		isset($param['nickname']) && $_data['nickname'] = $nickname;
		isset($param['avatar']) && $_data['avatar'] = $avatar;
		isset($param['mobile']) && $_data['mobile'] = $mobile;
		isset($param['is_root']) && $_data['is_root'] = $is_root;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['pid']) && $_data['pid'] = $pid;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 管理员表
	 * @api_name 删除管理员
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.delete
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
	 * 管理员表
	 * @api_name 更改管理员状态
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.setStatus
	 *
	 * id				
	 * status			状态（1启用 0禁用）
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m User */
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
