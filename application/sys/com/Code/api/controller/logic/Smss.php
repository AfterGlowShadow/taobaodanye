<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Code\api\controller\logic;

use app\sys\com\Code\common\model\Sms;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Smss
 * 短信验证码表
 * @api_name 短信验证码
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Code\api\controller\logic
 */
class Smss extends ControllerCommon {
    protected $_route_url = '/sys/api/Code.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Sms();

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
	 * 短信验证码表
	 * @api_name 获取短信验证码列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Code.v1.Smss.getList
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

		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$code = isset($param['code']) ? $param['code'] : '';
		$code_type = isset($param['code_type']) ? $param['code_type'] : 0;
		$code_expire_in = isset($param['code_expire_in']) ? $param['code_expire_in'] : 0;
		$content = isset($param['content']) ? $param['content'] : '';
		$send_status = isset($param['send_status']) ? $param['send_status'] : 0;
		$send_errmsg = isset($param['send_errmsg']) ? $param['send_errmsg'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$sms_type = isset($param['sms_type']) ? $param['sms_type'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$response_message = isset($param['response_message']) ? $param['response_message'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Sms */
        $m = $this->_model;
        $_where = [];
		isset($param['mobile']) && $_where[] = ['mobile', '=', $mobile];
		isset($param['code']) && $_where[] = ['code', '=', $code];
		isset($param['code_type']) && $_where[] = ['code_type', '=', $code_type];
		isset($param['code_expire_in']) && $_where[] = ['code_expire_in', '=', $code_expire_in];
		isset($param['content']) && $_where[] = ['content', '=', $content];
		isset($param['send_status']) && $_where[] = ['send_status', '=', $send_status];
		isset($param['send_errmsg']) && $_where[] = ['send_errmsg', '=', $send_errmsg];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['type']) && $_where[] = ['type', '=', $type];
		isset($param['sms_type']) && $_where[] = ['sms_type', '=', $sms_type];
		isset($param['remark']) && $_where[] = ['remark', '=', $remark];
		isset($param['response_message']) && $_where[] = ['response_message', '=', $response_message];
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
	 * 短信验证码表
	 * @api_name 获取短信验证码详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Code.v1.Smss.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Sms */
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
	 * 短信验证码表
	 * @api_name 添加短信验证码
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Code.v1.Smss.add
	 * 
	 * mobile				手机
	 * code					短信验证码
	 * code_type			验证码类型（0-未知 1-注册 2-忘记密码 3-登录）
	 * code_expire_in		验证码过期时间戳
	 * content				发送内容
	 * send_status			发送状态（0-未知 1-等待发送 2-发送中 3-成功 4-失败）
	 * send_errmsg			发送失败信息
	 * status				状态（0-未知 1-启用 2-禁用）
	 * type					类型（0-未知 1-短信验证码）
	 * sms_type				短信类型（0-未知 1-阿里大鱼 2-114）
	 * remark				备注
	 * response_message		返回消息
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Sms */
		$m = $this->_model;
		$param = $this->param;
		
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$code = isset($param['code']) ? $param['code'] : '';
		$code_type = isset($param['code_type']) ? $param['code_type'] : 0;
		$code_expire_in = isset($param['code_expire_in']) ? $param['code_expire_in'] : 0;
		$content = isset($param['content']) ? $param['content'] : '';
		$send_status = isset($param['send_status']) ? $param['send_status'] : 0;
		$send_errmsg = isset($param['send_errmsg']) ? $param['send_errmsg'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$sms_type = isset($param['sms_type']) ? $param['sms_type'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$response_message = isset($param['response_message']) ? $param['response_message'] : '';
		
		$_data = [];
		$_data['mobile'] = $mobile;
		$_data['code'] = $code;
		$_data['code_type'] = $code_type;
		$_data['code_expire_in'] = $code_expire_in;
		$_data['content'] = $content;
		$_data['send_status'] = $send_status;
		$_data['send_errmsg'] = $send_errmsg;
		$_data['status'] = $status;
		$_data['type'] = $type;
		$_data['sms_type'] = $sms_type;
		$_data['remark'] = $remark;
		$_data['response_message'] = $response_message;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 短信验证码表
	 * @api_name 更改短信验证码
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Code.v1.Smss.edit
	 *
	 * id					
	 * mobile				手机
	 * code					短信验证码
	 * code_type			验证码类型（0-未知 1-注册 2-忘记密码 3-登录）
	 * code_expire_in		验证码过期时间戳
	 * content				发送内容
	 * send_status			发送状态（0-未知 1-等待发送 2-发送中 3-成功 4-失败）
	 * send_errmsg			发送失败信息
	 * status				状态（0-未知 1-启用 2-禁用）
	 * type					类型（0-未知 1-短信验证码）
	 * sms_type				短信类型（0-未知 1-阿里大鱼 2-114）
	 * remark				备注
	 * response_message		返回消息
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Sms */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$code = isset($param['code']) ? $param['code'] : '';
		$code_type = isset($param['code_type']) ? $param['code_type'] : 0;
		$code_expire_in = isset($param['code_expire_in']) ? $param['code_expire_in'] : 0;
		$content = isset($param['content']) ? $param['content'] : '';
		$send_status = isset($param['send_status']) ? $param['send_status'] : 0;
		$send_errmsg = isset($param['send_errmsg']) ? $param['send_errmsg'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$sms_type = isset($param['sms_type']) ? $param['sms_type'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$response_message = isset($param['response_message']) ? $param['response_message'] : '';
		
		$_data = [];
		isset($param['mobile']) && $_data['mobile'] = $mobile;
		isset($param['code']) && $_data['code'] = $code;
		isset($param['code_type']) && $_data['code_type'] = $code_type;
		isset($param['code_expire_in']) && $_data['code_expire_in'] = $code_expire_in;
		isset($param['content']) && $_data['content'] = $content;
		isset($param['send_status']) && $_data['send_status'] = $send_status;
		isset($param['send_errmsg']) && $_data['send_errmsg'] = $send_errmsg;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['type']) && $_data['type'] = $type;
		isset($param['sms_type']) && $_data['sms_type'] = $sms_type;
		isset($param['remark']) && $_data['remark'] = $remark;
		isset($param['response_message']) && $_data['response_message'] = $response_message;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 短信验证码表
	 * @api_name 删除短信验证码
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Code.v1.Smss.delete
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
	 * 短信验证码表
	 * @api_name 更改短信验证码状态
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Code.v1.Smss.setStatus
	 *
	 * id					
	 * status				状态（0-未知 1-启用 2-禁用）
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Sms */
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
