<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\common\validate;

use think\Validate;

class User extends Validate {
	public $_use_username = 0;
	public $_use_mobile = 0;
	public $_use_sms_code = 0;
	public $_use_share = 0;
	
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
		'name' => 'require|unique:sys_user,name',
		'nickname' => 'require',
		'realname' => 'require',
		'identity_number' => 'require',
		'passwd' => 'require',
		'mobile' => 'require',
		'Invite_code' => 'require',
		'status' => 'require',
		'last_login_time' => 'require',
		'last_login_ip' => 'require',
		'token' => 'require',
		'token_expire_in' => 'require',
		'email' => '',
	];
	
	/**
	 * 定义错误信息
	 * 格式：'字段名.规则名'	=>	'错误信息'
	 *
	 * @var array
	 */
	protected $message = [
		'name.require' => '“用户名”必须填写',
		'name.unique' => '“用户名”已存在',
		'nickname.require' => '“昵称”必须填写',
		'realname.require' => '“姓名”必须填写',
		'identity_number.require' => '“身份证号”必须填写',
		'passwd.require' => '“密码”必须填写',
		'mobile.require' => '“手机”必须填写',
		'Invite_code.require' => '“邀请码”必须填写',
		'status.require' => '“状态”必须填写',
		'last_login_time.require' => '“最后一次登陆时间”必须填写',
		'last_login_ip.require' => '“最后一次登陆ip”必须填写',
		'token.require' => '“token”必须填写',
		'token_expire_in.require' => '“token过期时间”必须填写',
		'email.require' => '“邮箱”必须填写',
	];

	protected $scene = [
		'add'  => ["name", "passwd"],
		'edit' => ["name"],
		
		'change_pw' => ["passwd"],
		'reset_pw' => ["passwd"],
		
		'edit_ip' => ['last_login_ip'],
		
		'set_status' => ["status"],
		
		'edit_user' => ["email"],
	];
	
	public function __construct(array $rules = [], array $message = [], array $field = []) {
		parent::__construct($rules, $message, $field);
		
		// $this->_use_username = config('sys_config.reg_use.username');
		// $this->_use_mobile = config('sys_config.reg_use.mobile');
		// $this->_use_sms_code = config('sys_config.reg_use.sms_code');
		// $this->_use_share = config('sys_config.reg_use.share');
		//
		// if ($this->_use_username) {
		//
		// }
	}
}
