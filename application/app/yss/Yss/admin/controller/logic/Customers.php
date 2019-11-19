<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller\logic;

use app\app\yss\Yss\common\model\Customer;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Customers
 * 客服表
 * @api_name 客服
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\admin\controller\logic
 */
class Customers extends ControllerCommon {
    protected $_route_url = '/app/admin/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Customer();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 客服表
	 * @api_name 获取客服列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Customers.getList
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
		$head_img = isset($param['head_img']) ? $param['head_img'] : '';
		$honor = isset($param['honor']) ? $param['honor'] : '';
		$major = isset($param['major']) ? $param['major'] : 0;
		$major_name = isset($param['major_name']) ? $param['major_name'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$qq = isset($param['qq']) ? $param['qq'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$is_recommend = isset($param['is_recommend']) ? $param['is_recommend'] : 0;

        /** @var $m Customer */
        $m = $this->_model;
        $_where = [];
		isset($param['name']) && $_where[] = ['name', '=', $name];
		isset($param['head_img']) && $_where[] = ['head_img', '=', $head_img];
		isset($param['honor']) && $_where[] = ['honor', '=', $honor];
		isset($param['major']) && $_where[] = ['major', '=', $major];
		isset($param['major_name']) && $_where[] = ['major_name', '=', $major_name];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['qq']) && $_where[] = ['qq', '=', $qq];
		isset($param['phone']) && $_where[] = ['phone', '=', $phone];
		isset($param['is_recommend']) && $_where[] = ['is_recommend', '=', $is_recommend];

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
	 * 客服表
	 * @api_name 获取客服详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Customers.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Customer */
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
	 * 客服表
	 * @api_name 添加客服
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Customers.add
	 * 
	 * name				客服名称
	 * head_img			头像
	 * honor			头衔
	 * major			专业
	 * major_name		专业
	 * status			状态 1正常 0禁用
	 * qq				QQ号
	 * phone			电话
	 * is_recommend		是否推荐
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Customer */
		$m = $this->_model;
		$param = $this->param;
		
		$name = isset($param['name']) ? $param['name'] : '';
		$head_img = isset($param['head_img']) ? $param['head_img'] : '';
		$honor = isset($param['honor']) ? $param['honor'] : '';
		$major = isset($param['major']) ? $param['major'] : 0;
		$major_name = isset($param['major_name']) ? $param['major_name'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$qq = isset($param['qq']) ? $param['qq'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$is_recommend = isset($param['is_recommend']) ? $param['is_recommend'] : 0;
		
		$_data = [];
		$_data['name'] = $name;
		$_data['head_img'] = $head_img;
		$_data['honor'] = $honor;
		$_data['major'] = $major;
		$_data['major_name'] = $major_name;
		$_data['status'] = $status;
		$_data['qq'] = $qq;
		$_data['phone'] = $phone;
		$_data['is_recommend'] = $is_recommend;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 客服表
	 * @api_name 更改客服
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Customers.edit
	 *
	 * id				
	 * name				客服名称
	 * head_img			头像
	 * honor			头衔
	 * major			专业
	 * major_name		专业
	 * status			状态 1正常 0禁用
	 * qq				QQ号
	 * phone			电话
	 * is_recommend		是否推荐
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Customer */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$name = isset($param['name']) ? $param['name'] : '';
		$head_img = isset($param['head_img']) ? $param['head_img'] : '';
		$honor = isset($param['honor']) ? $param['honor'] : '';
		$major = isset($param['major']) ? $param['major'] : 0;
		$major_name = isset($param['major_name']) ? $param['major_name'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$qq = isset($param['qq']) ? $param['qq'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$is_recommend = isset($param['is_recommend']) ? $param['is_recommend'] : 0;
		
		$_data = [];
		isset($param['name']) && $_data['name'] = $name;
		isset($param['head_img']) && $_data['head_img'] = $head_img;
		isset($param['honor']) && $_data['honor'] = $honor;
		isset($param['major']) && $_data['major'] = $major;
		isset($param['major_name']) && $_data['major_name'] = $major_name;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['qq']) && $_data['qq'] = $qq;
		isset($param['phone']) && $_data['phone'] = $phone;
		isset($param['is_recommend']) && $_data['is_recommend'] = $is_recommend;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 客服表
	 * @api_name 删除客服
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Customers.delete
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
	 * 客服表
	 * @api_name 更改客服状态
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Customers.setStatus
	 *
	 * id				
	 * status			状态 1正常 0禁用
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Customer */
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
