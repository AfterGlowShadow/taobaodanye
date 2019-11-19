<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Msg\api\controller\logic;

use app\sys\com\Msg\common\model\Text;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Texts
 * 站内消息内容表
 * @api_name 站内消息内容
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Msg\api\controller\logic
 */
class Texts extends ControllerCommon {
    protected $_route_url = '/sys/api/Msg.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Text();

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
	 * 站内消息内容表
	 * @api_name 获取站内消息内容列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Texts.getList
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

		$title = isset($param['title']) ? $param['title'] : '';
		$content = isset($param['content']) ? $param['content'] : '';
		$send_param = isset($param['send_param']) ? $param['send_param'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$addon_name = isset($param['addon_name']) ? $param['addon_name'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Text */
        $m = $this->_model;
        $_where = [];
		isset($param['title']) && $_where[] = ['title', '=', $title];
		isset($param['content']) && $_where[] = ['content', '=', $content];
		isset($param['send_param']) && $_where[] = ['send_param', '=', $send_param];
		isset($param['type']) && $_where[] = ['type', '=', $type];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['remark']) && $_where[] = ['remark', '=', $remark];
		isset($param['addon_name']) && $_where[] = ['addon_name', '=', $addon_name];
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
	 * 站内消息内容表
	 * @api_name 获取站内消息内容详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Texts.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Text */
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
	 * 站内消息内容表
	 * @api_name 添加站内消息内容
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Texts.add
	 * 
	 * title			标题
	 * content			内容
	 * send_param		附件参数 推送相关参数
	 * type				类型（0-未知 1-公众号推送 2-小程序推送 3-短信 4-邮箱 5-其他 大于100为自定义）
	 * status			状态（0-未知 1-待发送 2-发送中 3-已发送）
	 * remark			备注
	 * addon_name		应用名称
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Text */
		$m = $this->_model;
		$param = $this->param;
		
		$title = isset($param['title']) ? $param['title'] : '';
		$content = isset($param['content']) ? $param['content'] : '';
		$send_param = isset($param['send_param']) ? $param['send_param'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$addon_name = isset($param['addon_name']) ? $param['addon_name'] : '';
		
		$_data = [];
		$_data['title'] = $title;
		$_data['content'] = $content;
		$_data['send_param'] = $send_param;
		$_data['type'] = $type;
		$_data['status'] = $status;
		$_data['remark'] = $remark;
		$_data['addon_name'] = $addon_name;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 站内消息内容表
	 * @api_name 更改站内消息内容
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Texts.edit
	 *
	 * id				
	 * title			标题
	 * content			内容
	 * send_param		附件参数 推送相关参数
	 * type				类型（0-未知 1-公众号推送 2-小程序推送 3-短信 4-邮箱 5-其他 大于100为自定义）
	 * status			状态（0-未知 1-待发送 2-发送中 3-已发送）
	 * remark			备注
	 * addon_name		应用名称
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Text */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$title = isset($param['title']) ? $param['title'] : '';
		$content = isset($param['content']) ? $param['content'] : '';
		$send_param = isset($param['send_param']) ? $param['send_param'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$addon_name = isset($param['addon_name']) ? $param['addon_name'] : '';
		
		$_data = [];
		isset($param['title']) && $_data['title'] = $title;
		isset($param['content']) && $_data['content'] = $content;
		isset($param['send_param']) && $_data['send_param'] = $send_param;
		isset($param['type']) && $_data['type'] = $type;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['remark']) && $_data['remark'] = $remark;
		isset($param['addon_name']) && $_data['addon_name'] = $addon_name;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 站内消息内容表
	 * @api_name 删除站内消息内容
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Texts.delete
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
	 * 站内消息内容表
	 * @api_name 更改站内消息内容状态
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Texts.setStatus
	 *
	 * id				
	 * status			状态（0-未知 1-待发送 2-发送中 3-已发送）
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Text */
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
