<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\common\validate\vbase;

use think\Validate;

class User extends Validate {
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
		'avatar' => 'require',
		'gender' => 'require',
		'identity_number' => 'require',
		'province' => 'require',
		'city' => 'require',
		'district' => 'require',
		'address' => 'require',
		'passwd' => 'require',
		'email' => 'require|email|unique:sys_user,email',
		'mobile' => 'require',
		'birthday' => 'require',
		'Invite_code' => 'require',
		'other_param' => 'require',
		'status' => 'require',
		'last_login_time' => 'require',
		'last_login_ip' => 'require',
		'token' => 'require',
		'token_expire_in' => 'require',
		'frozen_time' => 'require',
		'frozen_start_time' => 'require',
		'frozen_end_time' => 'require',

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
		'avatar.require' => '“头像”必须填写',
		'gender.require' => '“性别（0-其他 1-男 2-女）”必须填写',
		'identity_number.require' => '“身份证号”必须填写',
		'province.require' => '“省”必须填写',
		'city.require' => '“市”必须填写',
		'district.require' => '“县区”必须填写',
		'address.require' => '“详细地址”必须填写',
		'passwd.require' => '“密码”必须填写',
		'email.require' => '“Email”必须填写',
		'email.email' => '“Email”邮箱格式不正确',
		'email.unique' => '“Email”已存在',
		'mobile.require' => '“手机”必须填写',
		'birthday.require' => '“生日”必须填写',
		'Invite_code.require' => '“邀请码”必须填写',
		'other_param.require' => '“附加参数”必须填写',
		'status.require' => '“状态（0-禁用 1-启用）”必须填写',
		'last_login_time.require' => '“最后一次登陆时间”必须填写',
		'last_login_ip.require' => '“最后一次登陆ip”必须填写',
		'token.require' => '“token”必须填写',
		'token_expire_in.require' => '“token过期时间”必须填写',
		'frozen_time.require' => '“封停时间”必须填写',
		'frozen_start_time.require' => '“封停开始时间”必须填写',
		'frozen_end_time.require' => '“封停结束时间”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "nickname", "realname", "avatar", "gender", "identity_number", "province", "city", "district", "address", "passwd", "email", "mobile", "birthday", "Invite_code", "other_param", "status", "last_login_time", "last_login_ip", "token", "token_expire_in", "frozen_time", "frozen_start_time", "frozen_end_time"],
		'edit' => ["name", "nickname", "realname", "avatar", "gender", "identity_number", "province", "city", "district", "address", "passwd", "email", "mobile", "birthday", "Invite_code", "other_param", "status", "last_login_time", "last_login_ip", "token", "token_expire_in", "frozen_time", "frozen_start_time", "frozen_end_time"],
	];
}
