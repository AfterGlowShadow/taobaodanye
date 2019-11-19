<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller\logic;

use app\app\yss\Yss\common\model\Faceback;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Facebacks
 * 投诉建议表
 * @api_name 投诉建议
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\admin\controller\logic
 */
class Facebacks extends ControllerCommon {
    protected $_route_url = '/app/admin/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Faceback();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 投诉建议表
	 * @api_name 获取投诉建议列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Facebacks.getList
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

		$content = isset($param['content']) ? $param['content'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$nickname = isset($param['nickname']) ? $param['nickname'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';

        /** @var $m Faceback */
        $m = $this->_model;
        $_where = [];
		isset($param['content']) && $_where[] = ['content', '=', $content];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['uid']) && $_where[] = ['uid', '=', $uid];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['type']) && $_where[] = ['type', '=', $type];
		isset($param['nickname']) && $_where[] = ['nickname', '=', $nickname];
		isset($param['phone']) && $_where[] = ['phone', '=', $phone];

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
	 * 投诉建议表
	 * @api_name 获取投诉建议详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Facebacks.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Faceback */
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
	 * 投诉建议表
	 * @api_name 添加投诉建议
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Facebacks.add
	 * 
	 * content			建议
	 * uid				用户id
	 * status			1已读 0未读
	 * type				1投诉 2建议
	 * nickname			称呼
	 * phone			手机号
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Faceback */
		$m = $this->_model;
		$param = $this->param;
		
		$content = isset($param['content']) ? $param['content'] : '';
		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$nickname = isset($param['nickname']) ? $param['nickname'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		
		$_data = [];
		$_data['content'] = $content;
		$_data['uid'] = $uid;
		$_data['status'] = $status;
		$_data['type'] = $type;
		$_data['nickname'] = $nickname;
		$_data['phone'] = $phone;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 投诉建议表
	 * @api_name 更改投诉建议
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Facebacks.edit
	 *
	 * id				
	 * content			建议
	 * uid				用户id
	 * status			1已读 0未读
	 * type				1投诉 2建议
	 * nickname			称呼
	 * phone			手机号
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Faceback */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$content = isset($param['content']) ? $param['content'] : '';
		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$nickname = isset($param['nickname']) ? $param['nickname'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		
		$_data = [];
		isset($param['content']) && $_data['content'] = $content;
		isset($param['uid']) && $_data['uid'] = $uid;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['type']) && $_data['type'] = $type;
		isset($param['nickname']) && $_data['nickname'] = $nickname;
		isset($param['phone']) && $_data['phone'] = $phone;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 投诉建议表
	 * @api_name 删除投诉建议
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Facebacks.delete
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
	 * 投诉建议表
	 * @api_name 更改投诉建议状态
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Facebacks.setStatus
	 *
	 * id				
	 * status			1已读 0未读
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Faceback */
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
