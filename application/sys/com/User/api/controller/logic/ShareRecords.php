<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\api\controller\logic;

use app\sys\com\User\common\model\ShareRecord;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class ShareRecords
 * @api_name 用户分享记录
@is_api 1
@is_show 0
@is_auth 1
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 0
 * @package app\sys\com\User\api\controller\logic
 */
class ShareRecords extends ControllerCommon {
    protected $_route_url = '/sys/api/User.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new ShareRecord();

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
	 * @api_name 获取用户分享记录
@is_api 1
@is_show 0
@is_auth 1列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.ShareRecords.getList
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

		$uid1 = isset($param['uid1']) ? $param['uid1'] : 0;
		$mobile1 = isset($param['mobile1']) ? $param['mobile1'] : '';
		$nickname1 = isset($param['nickname1']) ? $param['nickname1'] : '';
		$realname1 = isset($param['realname1']) ? $param['realname1'] : '';
		$uid2 = isset($param['uid2']) ? $param['uid2'] : 0;
		$mobile2 = isset($param['mobile2']) ? $param['mobile2'] : '';
		$nickname2 = isset($param['nickname2']) ? $param['nickname2'] : '';
		$realname2 = isset($param['realname2']) ? $param['realname2'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m ShareRecord */
        $m = $this->_model;
        $_where = [];
		isset($param['uid1']) && $_where[] = ['uid1', '=', $uid1];
		isset($param['mobile1']) && $_where[] = ['mobile1', '=', $mobile1];
		isset($param['nickname1']) && $_where[] = ['nickname1', '=', $nickname1];
		isset($param['realname1']) && $_where[] = ['realname1', '=', $realname1];
		isset($param['uid2']) && $_where[] = ['uid2', '=', $uid2];
		isset($param['mobile2']) && $_where[] = ['mobile2', '=', $mobile2];
		isset($param['nickname2']) && $_where[] = ['nickname2', '=', $nickname2];
		isset($param['realname2']) && $_where[] = ['realname2', '=', $realname2];
		isset($param['status']) && $_where[] = ['status', '=', $status];
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
	 * @api_name 获取用户分享记录
@is_api 1
@is_show 0
@is_auth 1详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.ShareRecords.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m ShareRecord */
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
	 * @api_name 添加用户分享记录
@is_api 1
@is_show 0
@is_auth 1
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.ShareRecords.add
	 * 
	 * uid1				邀请人uid
	 * mobile1			邀请人手机
	 * nickname1		邀请人昵称
	 * realname1		邀请人姓名
	 * uid2				被邀请人uid
	 * mobile2			被邀请人手机
	 * nickname2		被邀请人昵称
	 * realname2		被邀请人姓名
	 * status			邀请状态（0-未知 1-被邀请人注册 2-被邀请人支付）
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m ShareRecord */
		$m = $this->_model;
		$param = $this->param;
		
		$uid1 = isset($param['uid1']) ? $param['uid1'] : 0;
		$mobile1 = isset($param['mobile1']) ? $param['mobile1'] : '';
		$nickname1 = isset($param['nickname1']) ? $param['nickname1'] : '';
		$realname1 = isset($param['realname1']) ? $param['realname1'] : '';
		$uid2 = isset($param['uid2']) ? $param['uid2'] : 0;
		$mobile2 = isset($param['mobile2']) ? $param['mobile2'] : '';
		$nickname2 = isset($param['nickname2']) ? $param['nickname2'] : '';
		$realname2 = isset($param['realname2']) ? $param['realname2'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		
		$_data = [];
		$_data['uid1'] = $uid1;
		$_data['mobile1'] = $mobile1;
		$_data['nickname1'] = $nickname1;
		$_data['realname1'] = $realname1;
		$_data['uid2'] = $uid2;
		$_data['mobile2'] = $mobile2;
		$_data['nickname2'] = $nickname2;
		$_data['realname2'] = $realname2;
		$_data['status'] = $status;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * @api_name 更改用户分享记录
@is_api 1
@is_show 0
@is_auth 1
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.ShareRecords.edit
	 *
	 * id				
	 * uid1				邀请人uid
	 * mobile1			邀请人手机
	 * nickname1		邀请人昵称
	 * realname1		邀请人姓名
	 * uid2				被邀请人uid
	 * mobile2			被邀请人手机
	 * nickname2		被邀请人昵称
	 * realname2		被邀请人姓名
	 * status			邀请状态（0-未知 1-被邀请人注册 2-被邀请人支付）
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m ShareRecord */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$uid1 = isset($param['uid1']) ? $param['uid1'] : 0;
		$mobile1 = isset($param['mobile1']) ? $param['mobile1'] : '';
		$nickname1 = isset($param['nickname1']) ? $param['nickname1'] : '';
		$realname1 = isset($param['realname1']) ? $param['realname1'] : '';
		$uid2 = isset($param['uid2']) ? $param['uid2'] : 0;
		$mobile2 = isset($param['mobile2']) ? $param['mobile2'] : '';
		$nickname2 = isset($param['nickname2']) ? $param['nickname2'] : '';
		$realname2 = isset($param['realname2']) ? $param['realname2'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		
		$_data = [];
		isset($param['uid1']) && $_data['uid1'] = $uid1;
		isset($param['mobile1']) && $_data['mobile1'] = $mobile1;
		isset($param['nickname1']) && $_data['nickname1'] = $nickname1;
		isset($param['realname1']) && $_data['realname1'] = $realname1;
		isset($param['uid2']) && $_data['uid2'] = $uid2;
		isset($param['mobile2']) && $_data['mobile2'] = $mobile2;
		isset($param['nickname2']) && $_data['nickname2'] = $nickname2;
		isset($param['realname2']) && $_data['realname2'] = $realname2;
		isset($param['status']) && $_data['status'] = $status;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * @api_name 删除用户分享记录
@is_api 1
@is_show 0
@is_auth 1
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.ShareRecords.delete
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
	 * @api_name 更改用户分享记录
@is_api 1
@is_show 0
@is_auth 1状态
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.ShareRecords.setStatus
	 *
	 * id				
	 * status			邀请状态（0-未知 1-被邀请人注册 2-被邀请人支付）
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m ShareRecord */
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
