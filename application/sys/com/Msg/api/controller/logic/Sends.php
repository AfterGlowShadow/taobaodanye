<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Msg\api\controller\logic;

use app\sys\com\Msg\common\model\Send;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Sends
 * 站内消息发送表
 * @api_name 站内消息发送
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Msg\api\controller\logic
 */
class Sends extends ControllerCommon {
    protected $_route_url = '/sys/api/Msg.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Send();

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
	 * 站内消息发送表
	 * @api_name 获取站内消息发送列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Sends.getList
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

		$send_id = isset($param['send_id']) ? $param['send_id'] : 0;
		$receiver_id = isset($param['receiver_id']) ? $param['receiver_id'] : 0;
		$send_param = isset($param['send_param']) ? $param['send_param'] : '';
		$send_time = isset($param['send_time']) ? $param['send_time'] : 0;
		$read_flag = isset($param['read_flag']) ? $param['read_flag'] : 0;
		$msg_text_id = isset($param['msg_text_id']) ? $param['msg_text_id'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$addon_name = isset($param['addon_name']) ? $param['addon_name'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Send */
        $m = $this->_model;
        $_where = [];
		isset($param['send_id']) && $_where[] = ['send_id', '=', $send_id];
		isset($param['receiver_id']) && $_where[] = ['receiver_id', '=', $receiver_id];
		isset($param['send_param']) && $_where[] = ['send_param', '=', $send_param];
		isset($param['send_time']) && $_where[] = ['send_time', '=', $send_time];
		isset($param['read_flag']) && $_where[] = ['read_flag', '=', $read_flag];
		isset($param['msg_text_id']) && $_where[] = ['msg_text_id', '=', $msg_text_id];
		isset($param['status']) && $_where[] = ['status', '=', $status];
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
	 * 站内消息发送表
	 * @api_name 获取站内消息发送详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Sends.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Send */
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
	 * 站内消息发送表
	 * @api_name 添加站内消息发送
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Sends.add
	 * 
	 * send_id			发送者id
	 * receiver_id		接收者id
	 * send_param		附件参数 推送相关参数
	 * send_time		发送时间（保留定时发送）
	 * read_flag		已读标志（0-未读 1-已读）
	 * msg_text_id		消息内容id
	 * status			状态（0-等待发送 1-发送中 2-成功 3-失败）
	 * addon_name		应用名称
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Send */
		$m = $this->_model;
		$param = $this->param;
		
		$send_id = isset($param['send_id']) ? $param['send_id'] : 0;
		$receiver_id = isset($param['receiver_id']) ? $param['receiver_id'] : 0;
		$send_param = isset($param['send_param']) ? $param['send_param'] : '';
		$send_time = isset($param['send_time']) ? $param['send_time'] : 0;
		$read_flag = isset($param['read_flag']) ? $param['read_flag'] : 0;
		$msg_text_id = isset($param['msg_text_id']) ? $param['msg_text_id'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$addon_name = isset($param['addon_name']) ? $param['addon_name'] : '';
		
		$_data = [];
		$_data['send_id'] = $send_id;
		$_data['receiver_id'] = $receiver_id;
		$_data['send_param'] = $send_param;
		$_data['send_time'] = $send_time;
		$_data['read_flag'] = $read_flag;
		$_data['msg_text_id'] = $msg_text_id;
		$_data['status'] = $status;
		$_data['addon_name'] = $addon_name;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 站内消息发送表
	 * @api_name 更改站内消息发送
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Sends.edit
	 *
	 * id				
	 * send_id			发送者id
	 * receiver_id		接收者id
	 * send_param		附件参数 推送相关参数
	 * send_time		发送时间（保留定时发送）
	 * read_flag		已读标志（0-未读 1-已读）
	 * msg_text_id		消息内容id
	 * status			状态（0-等待发送 1-发送中 2-成功 3-失败）
	 * addon_name		应用名称
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Send */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$send_id = isset($param['send_id']) ? $param['send_id'] : 0;
		$receiver_id = isset($param['receiver_id']) ? $param['receiver_id'] : 0;
		$send_param = isset($param['send_param']) ? $param['send_param'] : '';
		$send_time = isset($param['send_time']) ? $param['send_time'] : 0;
		$read_flag = isset($param['read_flag']) ? $param['read_flag'] : 0;
		$msg_text_id = isset($param['msg_text_id']) ? $param['msg_text_id'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$addon_name = isset($param['addon_name']) ? $param['addon_name'] : '';
		
		$_data = [];
		isset($param['send_id']) && $_data['send_id'] = $send_id;
		isset($param['receiver_id']) && $_data['receiver_id'] = $receiver_id;
		isset($param['send_param']) && $_data['send_param'] = $send_param;
		isset($param['send_time']) && $_data['send_time'] = $send_time;
		isset($param['read_flag']) && $_data['read_flag'] = $read_flag;
		isset($param['msg_text_id']) && $_data['msg_text_id'] = $msg_text_id;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['addon_name']) && $_data['addon_name'] = $addon_name;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 站内消息发送表
	 * @api_name 删除站内消息发送
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Sends.delete
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
	 * 站内消息发送表
	 * @api_name 更改站内消息发送状态
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Msg.v1.Sends.setStatus
	 *
	 * id				
	 * status			状态（0-等待发送 1-发送中 2-成功 3-失败）
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Send */
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
