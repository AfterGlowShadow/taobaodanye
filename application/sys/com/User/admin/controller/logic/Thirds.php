<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\admin\controller\logic;

use app\sys\com\User\common\model\Third;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Thirds
 * 第三方登录记录表
 * @api_name 第三方登录记录
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 0
 * @package app\sys\com\User\admin\controller\logic
 */
class Thirds extends ControllerCommon {
    protected $_route_url = '/sys/admin/User.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Third();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 第三方登录记录表
	 * @api_name 获取第三方登录记录列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Thirds.getList
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

		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$openid = isset($param['openid']) ? $param['openid'] : '';
		$unionid = isset($param['unionid']) ? $param['unionid'] : '';
		$channel = isset($param['channel']) ? $param['channel'] : '';
		$nick = isset($param['nick']) ? $param['nick'] : '';
		$gender = isset($param['gender']) ? $param['gender'] : 0;
		$avatar = isset($param['avatar']) ? $param['avatar'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$session_token = isset($param['session_token']) ? $param['session_token'] : '';
		$expire_time = isset($param['expire_time']) ? $param['expire_time'] : 0;

        /** @var $m Third */
        $m = $this->_model;
        $_where = [];
		isset($param['uid']) && $_where[] = ['uid', '=', $uid];
		isset($param['openid']) && $_where[] = ['openid', '=', $openid];
		isset($param['unionid']) && $_where[] = ['unionid', '=', $unionid];
		isset($param['channel']) && $_where[] = ['channel', '=', $channel];
		isset($param['nick']) && $_where[] = ['nick', '=', $nick];
		isset($param['gender']) && $_where[] = ['gender', '=', $gender];
		isset($param['avatar']) && $_where[] = ['avatar', '=', $avatar];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['session_token']) && $_where[] = ['session_token', '=', $session_token];
		isset($param['expire_time']) && $_where[] = ['expire_time', '=', $expire_time];

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
	 * 第三方登录记录表
	 * @api_name 获取第三方登录记录详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Thirds.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Third */
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
	 * 第三方登录记录表
	 * @api_name 添加第三方登录记录
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Thirds.add
	 * 
	 * uid					绑定用户uid
	 * openid				openid
	 * unionid				unionid
	 * channel				channel
	 * nick					昵称
	 * gender				性别（0-保密 1-男 2-女）
	 * avatar				头像
	 * status				状态（0-未知 1-绑定用户 2-未绑定 3-禁用）
	 * session_token		会话token（在未绑定用户之前 前端以会话token定位 目的是不公开openid）
	 * expire_time			token过期时间
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Third */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$openid = isset($param['openid']) ? $param['openid'] : '';
		$unionid = isset($param['unionid']) ? $param['unionid'] : '';
		$channel = isset($param['channel']) ? $param['channel'] : '';
		$nick = isset($param['nick']) ? $param['nick'] : '';
		$gender = isset($param['gender']) ? $param['gender'] : 0;
		$avatar = isset($param['avatar']) ? $param['avatar'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$session_token = isset($param['session_token']) ? $param['session_token'] : '';
		$expire_time = isset($param['expire_time']) ? $param['expire_time'] : 0;
		
		$_data = [];
		$_data['uid'] = $uid;
		$_data['openid'] = $openid;
		$_data['unionid'] = $unionid;
		$_data['channel'] = $channel;
		$_data['nick'] = $nick;
		$_data['gender'] = $gender;
		$_data['avatar'] = $avatar;
		$_data['status'] = $status;
		$_data['session_token'] = $session_token;
		$_data['expire_time'] = $expire_time;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 第三方登录记录表
	 * @api_name 更改第三方登录记录
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Thirds.edit
	 *
	 * id					
	 * uid					绑定用户uid
	 * openid				openid
	 * unionid				unionid
	 * channel				channel
	 * nick					昵称
	 * gender				性别（0-保密 1-男 2-女）
	 * avatar				头像
	 * status				状态（0-未知 1-绑定用户 2-未绑定 3-禁用）
	 * session_token		会话token（在未绑定用户之前 前端以会话token定位 目的是不公开openid）
	 * expire_time			token过期时间
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Third */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$openid = isset($param['openid']) ? $param['openid'] : '';
		$unionid = isset($param['unionid']) ? $param['unionid'] : '';
		$channel = isset($param['channel']) ? $param['channel'] : '';
		$nick = isset($param['nick']) ? $param['nick'] : '';
		$gender = isset($param['gender']) ? $param['gender'] : 0;
		$avatar = isset($param['avatar']) ? $param['avatar'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$session_token = isset($param['session_token']) ? $param['session_token'] : '';
		$expire_time = isset($param['expire_time']) ? $param['expire_time'] : 0;
		
		$_data = [];
		isset($param['uid']) && $_data['uid'] = $uid;
		isset($param['openid']) && $_data['openid'] = $openid;
		isset($param['unionid']) && $_data['unionid'] = $unionid;
		isset($param['channel']) && $_data['channel'] = $channel;
		isset($param['nick']) && $_data['nick'] = $nick;
		isset($param['gender']) && $_data['gender'] = $gender;
		isset($param['avatar']) && $_data['avatar'] = $avatar;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['session_token']) && $_data['session_token'] = $session_token;
		isset($param['expire_time']) && $_data['expire_time'] = $expire_time;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 第三方登录记录表
	 * @api_name 删除第三方登录记录
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Thirds.delete
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
	 * 第三方登录记录表
	 * @api_name 更改第三方登录记录状态
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Thirds.setStatus
	 *
	 * id					
	 * status				状态（0-未知 1-绑定用户 2-未绑定 3-禁用）
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Third */
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
