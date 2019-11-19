<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\admin\controller\logic;

use app\sys\com\Rbac\common\model\Rule;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Rules
 * 权限规则表
 * @api_name 权限规则
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 0
 * @package app\sys\com\Rbac\admin\controller\logic
 */
class Rules extends ControllerCommon {
    protected $_route_url = '/sys/admin/Rbac.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Rule();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 权限规则表
	 * @api_name 获取权限规则列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Rules.getList
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

		$pid = isset($param['pid']) ? $param['pid'] : 0;
		$name = isset($param['name']) ? $param['name'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$icon = isset($param['icon']) ? $param['icon'] : '';
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$url = isset($param['url']) ? $param['url'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$is_auth = isset($param['is_auth']) ? $param['is_auth'] : 0;
		$is_menu = isset($param['is_menu']) ? $param['is_menu'] : 0;
		$is_api = isset($param['is_api']) ? $param['is_api'] : 0;
		$is_show = isset($param['is_show']) ? $param['is_show'] : 0;
		$is_maker = isset($param['is_maker']) ? $param['is_maker'] : 0;
		$tag = isset($param['tag']) ? $param['tag'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$sort = isset($param['sort']) ? $param['sort'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Rule */
        $m = $this->_model;
        $_where = [];
		isset($param['pid']) && $_where[] = ['pid', '=', $pid];
		isset($param['name']) && $_where[] = ['name', '=', $name];
		isset($param['title']) && $_where[] = ['title', '=', $title];
		isset($param['icon']) && $_where[] = ['icon', '=', $icon];
		isset($param['intro']) && $_where[] = ['intro', '=', $intro];
		isset($param['url']) && $_where[] = ['url', '=', $url];
		isset($param['type']) && $_where[] = ['type', '=', $type];
		isset($param['is_auth']) && $_where[] = ['is_auth', '=', $is_auth];
		isset($param['is_menu']) && $_where[] = ['is_menu', '=', $is_menu];
		isset($param['is_api']) && $_where[] = ['is_api', '=', $is_api];
		isset($param['is_show']) && $_where[] = ['is_show', '=', $is_show];
		isset($param['is_maker']) && $_where[] = ['is_maker', '=', $is_maker];
		isset($param['tag']) && $_where[] = ['tag', '=', $tag];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['sort']) && $_where[] = ['sort', '=', $sort];
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
	 * 权限规则表
	 * @api_name 获取权限规则详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Rules.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Rule */
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
	 * 权限规则表
	 * @api_name 添加权限规则
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Rules.add
	 * 
	 * pid				父级id
	 * name				用户名
	 * title			标题（用于菜单显示）
	 * icon				图标（用于菜单显示）
	 * intro			简介
	 * url				链接
	 * type				类型（0-未知 1-通用 2-后台 3-前端）
	 * is_auth			是否校验权限（0-不校验 1-校验）
	 * is_menu			是否菜单（0-否 1-是）
	 * is_api			是否输出接口文档（0-否 1-是）
	 * is_show			是否显示在权限列表或菜单中（0-否 1-是）
	 * is_maker			是否为生成器生成（0-否 1-是）
	 * tag				标签（生成器用来识别）
	 * status			状态,1启用 0禁用
	 * sort				排序
	 * remark			备注
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Rule */
		$m = $this->_model;
		$param = $this->param;
		
		$pid = isset($param['pid']) ? $param['pid'] : 0;
		$name = isset($param['name']) ? $param['name'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$icon = isset($param['icon']) ? $param['icon'] : '';
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$url = isset($param['url']) ? $param['url'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$is_auth = isset($param['is_auth']) ? $param['is_auth'] : 0;
		$is_menu = isset($param['is_menu']) ? $param['is_menu'] : 0;
		$is_api = isset($param['is_api']) ? $param['is_api'] : 0;
		$is_show = isset($param['is_show']) ? $param['is_show'] : 0;
		$is_maker = isset($param['is_maker']) ? $param['is_maker'] : 0;
		$tag = isset($param['tag']) ? $param['tag'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$sort = isset($param['sort']) ? $param['sort'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		
		$_data = [];
		$_data['pid'] = $pid;
		$_data['name'] = $name;
		$_data['title'] = $title;
		$_data['icon'] = $icon;
		$_data['intro'] = $intro;
		$_data['url'] = $url;
		$_data['type'] = $type;
		$_data['is_auth'] = $is_auth;
		$_data['is_menu'] = $is_menu;
		$_data['is_api'] = $is_api;
		$_data['is_show'] = $is_show;
		$_data['is_maker'] = $is_maker;
		$_data['tag'] = $tag;
		$_data['status'] = $status;
		$_data['sort'] = $sort;
		$_data['remark'] = $remark;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 权限规则表
	 * @api_name 更改权限规则
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Rules.edit
	 *
	 * id				
	 * pid				父级id
	 * name				用户名
	 * title			标题（用于菜单显示）
	 * icon				图标（用于菜单显示）
	 * intro			简介
	 * url				链接
	 * type				类型（0-未知 1-通用 2-后台 3-前端）
	 * is_auth			是否校验权限（0-不校验 1-校验）
	 * is_menu			是否菜单（0-否 1-是）
	 * is_api			是否输出接口文档（0-否 1-是）
	 * is_show			是否显示在权限列表或菜单中（0-否 1-是）
	 * is_maker			是否为生成器生成（0-否 1-是）
	 * tag				标签（生成器用来识别）
	 * status			状态,1启用 0禁用
	 * sort				排序
	 * remark			备注
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Rule */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$pid = isset($param['pid']) ? $param['pid'] : 0;
		$name = isset($param['name']) ? $param['name'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$icon = isset($param['icon']) ? $param['icon'] : '';
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$url = isset($param['url']) ? $param['url'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$is_auth = isset($param['is_auth']) ? $param['is_auth'] : 0;
		$is_menu = isset($param['is_menu']) ? $param['is_menu'] : 0;
		$is_api = isset($param['is_api']) ? $param['is_api'] : 0;
		$is_show = isset($param['is_show']) ? $param['is_show'] : 0;
		$is_maker = isset($param['is_maker']) ? $param['is_maker'] : 0;
		$tag = isset($param['tag']) ? $param['tag'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$sort = isset($param['sort']) ? $param['sort'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		
		$_data = [];
		isset($param['pid']) && $_data['pid'] = $pid;
		isset($param['name']) && $_data['name'] = $name;
		isset($param['title']) && $_data['title'] = $title;
		isset($param['icon']) && $_data['icon'] = $icon;
		isset($param['intro']) && $_data['intro'] = $intro;
		isset($param['url']) && $_data['url'] = $url;
		isset($param['type']) && $_data['type'] = $type;
		isset($param['is_auth']) && $_data['is_auth'] = $is_auth;
		isset($param['is_menu']) && $_data['is_menu'] = $is_menu;
		isset($param['is_api']) && $_data['is_api'] = $is_api;
		isset($param['is_show']) && $_data['is_show'] = $is_show;
		isset($param['is_maker']) && $_data['is_maker'] = $is_maker;
		isset($param['tag']) && $_data['tag'] = $tag;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['sort']) && $_data['sort'] = $sort;
		isset($param['remark']) && $_data['remark'] = $remark;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 权限规则表
	 * @api_name 删除权限规则
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Rules.delete
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
	 * 权限规则表
	 * @api_name 更改权限规则状态
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Rules.setStatus
	 *
	 * id				
	 * status			状态,1启用 0禁用
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Rule */
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
