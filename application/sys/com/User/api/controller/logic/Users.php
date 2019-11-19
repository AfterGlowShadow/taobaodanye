<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\api\controller\logic;

use app\sys\com\User\common\model\User;
use app\sys\com\base\common\v1\controller\api\LoginCommon;
use Exception;

/**
 * Class Users
 * 用户表
 * @api_name 用户
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\User\api\controller\logic
 */
class Users extends LoginCommon {
    protected $_route_url = '/sys/api/User.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new User();

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
	 * 用户表
	 * @api_name 获取用户列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.getList
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
		$nickname = isset($param['nickname']) ? $param['nickname'] : '';
		$realname = isset($param['realname']) ? $param['realname'] : '';
		$avatar = isset($param['avatar']) ? $param['avatar'] : '';
		$gender = isset($param['gender']) ? $param['gender'] : 0;
		$identity_number = isset($param['identity_number']) ? $param['identity_number'] : '';
		$province = isset($param['province']) ? $param['province'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$district = isset($param['district']) ? $param['district'] : '';
		$address = isset($param['address']) ? $param['address'] : '';
		$passwd = isset($param['passwd']) ? $param['passwd'] : '';
		$email = isset($param['email']) ? $param['email'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$birthday = isset($param['birthday']) ? $param['birthday'] : 0;
		$Invite_code = isset($param['Invite_code']) ? $param['Invite_code'] : '';
		$other_param = isset($param['other_param']) ? $param['other_param'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$last_login_time = isset($param['last_login_time']) ? $param['last_login_time'] : 0;
		$last_login_ip = isset($param['last_login_ip']) ? $param['last_login_ip'] : '';
		$token = isset($param['token']) ? $param['token'] : '';
		$token_expire_in = isset($param['token_expire_in']) ? $param['token_expire_in'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$frozen_time = isset($param['frozen_time']) ? $param['frozen_time'] : 0;
		$frozen_start_time = isset($param['frozen_start_time']) ? $param['frozen_start_time'] : 0;
		$frozen_end_time = isset($param['frozen_end_time']) ? $param['frozen_end_time'] : 0;

        /** @var $m User */
        $m = $this->_model;
        $_where = [];
		isset($param['name']) && $_where[] = ['name', '=', $name];
		isset($param['nickname']) && $_where[] = ['nickname', '=', $nickname];
		isset($param['realname']) && $_where[] = ['realname', '=', $realname];
		isset($param['avatar']) && $_where[] = ['avatar', '=', $avatar];
		isset($param['gender']) && $_where[] = ['gender', '=', $gender];
		isset($param['identity_number']) && $_where[] = ['identity_number', '=', $identity_number];
		isset($param['province']) && $_where[] = ['province', '=', $province];
		isset($param['city']) && $_where[] = ['city', '=', $city];
		isset($param['district']) && $_where[] = ['district', '=', $district];
		isset($param['address']) && $_where[] = ['address', '=', $address];
		isset($param['passwd']) && $_where[] = ['passwd', '=', $passwd];
		isset($param['email']) && $_where[] = ['email', '=', $email];
		isset($param['mobile']) && $_where[] = ['mobile', '=', $mobile];
		isset($param['birthday']) && $_where[] = ['birthday', '=', $birthday];
		isset($param['Invite_code']) && $_where[] = ['Invite_code', '=', $Invite_code];
		isset($param['other_param']) && $_where[] = ['other_param', '=', $other_param];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['last_login_time']) && $_where[] = ['last_login_time', '=', $last_login_time];
		isset($param['last_login_ip']) && $_where[] = ['last_login_ip', '=', $last_login_ip];
		isset($param['token']) && $_where[] = ['token', '=', $token];
		isset($param['token_expire_in']) && $_where[] = ['token_expire_in', '=', $token_expire_in];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['frozen_time']) && $_where[] = ['frozen_time', '=', $frozen_time];
		isset($param['frozen_start_time']) && $_where[] = ['frozen_start_time', '=', $frozen_start_time];
		isset($param['frozen_end_time']) && $_where[] = ['frozen_end_time', '=', $frozen_end_time];

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
	 * 用户表
	 * @api_name 获取用户详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.getItemById
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
	 * 用户表
	 * @api_name 添加用户
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.add
	 * 
	 * name						用户名
	 * nickname					昵称
	 * realname					姓名
	 * avatar					头像
	 * gender					性别（0-其他 1-男 2-女）
	 * identity_number			身份证号
	 * province					省
	 * city						市
	 * district					县区
	 * address					详细地址
	 * passwd					密码
	 * email					Email
	 * mobile					手机
	 * birthday					生日
	 * Invite_code				邀请码
	 * other_param				附加参数
	 * status					状态（0-禁用 1-启用）
	 * last_login_time			最后一次登陆时间
	 * last_login_ip			最后一次登陆ip
	 * token					token
	 * token_expire_in			token过期时间
	 * frozen_time				封停时间
	 * frozen_start_time		封停开始时间
	 * frozen_end_time			封停结束时间
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m User */
		$m = $this->_model;
		$param = $this->param;
		
		$name = isset($param['name']) ? $param['name'] : '';
		$nickname = isset($param['nickname']) ? $param['nickname'] : '';
		$realname = isset($param['realname']) ? $param['realname'] : '';
		$avatar = isset($param['avatar']) ? $param['avatar'] : '';
		$gender = isset($param['gender']) ? $param['gender'] : 0;
		$identity_number = isset($param['identity_number']) ? $param['identity_number'] : '';
		$province = isset($param['province']) ? $param['province'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$district = isset($param['district']) ? $param['district'] : '';
		$address = isset($param['address']) ? $param['address'] : '';
		$passwd = isset($param['passwd']) ? $param['passwd'] : '';
		$email = isset($param['email']) ? $param['email'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$birthday = isset($param['birthday']) ? $param['birthday'] : 0;
		$Invite_code = isset($param['Invite_code']) ? $param['Invite_code'] : '';
		$other_param = isset($param['other_param']) ? $param['other_param'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$last_login_time = isset($param['last_login_time']) ? $param['last_login_time'] : 0;
		$last_login_ip = isset($param['last_login_ip']) ? $param['last_login_ip'] : '';
		$token = isset($param['token']) ? $param['token'] : '';
		$token_expire_in = isset($param['token_expire_in']) ? $param['token_expire_in'] : 0;
		$frozen_time = isset($param['frozen_time']) ? $param['frozen_time'] : 0;
		$frozen_start_time = isset($param['frozen_start_time']) ? $param['frozen_start_time'] : 0;
		$frozen_end_time = isset($param['frozen_end_time']) ? $param['frozen_end_time'] : 0;
		
		$_data = [];
		$_data['name'] = $name;
		$_data['nickname'] = $nickname;
		$_data['realname'] = $realname;
		$_data['avatar'] = $avatar;
		$_data['gender'] = $gender;
		$_data['identity_number'] = $identity_number;
		$_data['province'] = $province;
		$_data['city'] = $city;
		$_data['district'] = $district;
		$_data['address'] = $address;
		$_data['passwd'] = $passwd;
		$_data['email'] = $email;
		$_data['mobile'] = $mobile;
		$_data['birthday'] = $birthday;
		$_data['Invite_code'] = $Invite_code;
		$_data['other_param'] = $other_param;
		$_data['status'] = $status;
		$_data['last_login_time'] = $last_login_time;
		$_data['last_login_ip'] = $last_login_ip;
		$_data['token'] = $token;
		$_data['token_expire_in'] = $token_expire_in;
		$_data['frozen_time'] = $frozen_time;
		$_data['frozen_start_time'] = $frozen_start_time;
		$_data['frozen_end_time'] = $frozen_end_time;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 用户表
	 * @api_name 更改用户
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.edit
	 *
	 * id						
	 * name						用户名
	 * nickname					昵称
	 * realname					姓名
	 * avatar					头像
	 * gender					性别（0-其他 1-男 2-女）
	 * identity_number			身份证号
	 * province					省
	 * city						市
	 * district					县区
	 * address					详细地址
	 * passwd					密码
	 * email					Email
	 * mobile					手机
	 * birthday					生日
	 * Invite_code				邀请码
	 * other_param				附加参数
	 * status					状态（0-禁用 1-启用）
	 * last_login_time			最后一次登陆时间
	 * last_login_ip			最后一次登陆ip
	 * token					token
	 * token_expire_in			token过期时间
	 * frozen_time				封停时间
	 * frozen_start_time		封停开始时间
	 * frozen_end_time			封停结束时间
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m User */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$name = isset($param['name']) ? $param['name'] : '';
		$nickname = isset($param['nickname']) ? $param['nickname'] : '';
		$realname = isset($param['realname']) ? $param['realname'] : '';
		$avatar = isset($param['avatar']) ? $param['avatar'] : '';
		$gender = isset($param['gender']) ? $param['gender'] : 0;
		$identity_number = isset($param['identity_number']) ? $param['identity_number'] : '';
		$province = isset($param['province']) ? $param['province'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$district = isset($param['district']) ? $param['district'] : '';
		$address = isset($param['address']) ? $param['address'] : '';
		$passwd = isset($param['passwd']) ? $param['passwd'] : '';
		$email = isset($param['email']) ? $param['email'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$birthday = isset($param['birthday']) ? $param['birthday'] : 0;
		$Invite_code = isset($param['Invite_code']) ? $param['Invite_code'] : '';
		$other_param = isset($param['other_param']) ? $param['other_param'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$last_login_time = isset($param['last_login_time']) ? $param['last_login_time'] : 0;
		$last_login_ip = isset($param['last_login_ip']) ? $param['last_login_ip'] : '';
		$token = isset($param['token']) ? $param['token'] : '';
		$token_expire_in = isset($param['token_expire_in']) ? $param['token_expire_in'] : 0;
		$frozen_time = isset($param['frozen_time']) ? $param['frozen_time'] : 0;
		$frozen_start_time = isset($param['frozen_start_time']) ? $param['frozen_start_time'] : 0;
		$frozen_end_time = isset($param['frozen_end_time']) ? $param['frozen_end_time'] : 0;
		
		$_data = [];
		isset($param['name']) && $_data['name'] = $name;
		isset($param['nickname']) && $_data['nickname'] = $nickname;
		isset($param['realname']) && $_data['realname'] = $realname;
		isset($param['avatar']) && $_data['avatar'] = $avatar;
		isset($param['gender']) && $_data['gender'] = $gender;
		isset($param['identity_number']) && $_data['identity_number'] = $identity_number;
		isset($param['province']) && $_data['province'] = $province;
		isset($param['city']) && $_data['city'] = $city;
		isset($param['district']) && $_data['district'] = $district;
		isset($param['address']) && $_data['address'] = $address;
		isset($param['passwd']) && $_data['passwd'] = $passwd;
		isset($param['email']) && $_data['email'] = $email;
		isset($param['mobile']) && $_data['mobile'] = $mobile;
		isset($param['birthday']) && $_data['birthday'] = $birthday;
		isset($param['Invite_code']) && $_data['Invite_code'] = $Invite_code;
		isset($param['other_param']) && $_data['other_param'] = $other_param;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['last_login_time']) && $_data['last_login_time'] = $last_login_time;
		isset($param['last_login_ip']) && $_data['last_login_ip'] = $last_login_ip;
		isset($param['token']) && $_data['token'] = $token;
		isset($param['token_expire_in']) && $_data['token_expire_in'] = $token_expire_in;
		isset($param['frozen_time']) && $_data['frozen_time'] = $frozen_time;
		isset($param['frozen_start_time']) && $_data['frozen_start_time'] = $frozen_start_time;
		isset($param['frozen_end_time']) && $_data['frozen_end_time'] = $frozen_end_time;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 用户表
	 * @api_name 删除用户
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.delete
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
	 * 用户表
	 * @api_name 更改用户状态
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.setStatus
	 *
	 * id						
	 * status					状态（0-禁用 1-启用）
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
