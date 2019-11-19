<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\common\validate\vbase;

use think\Validate;

class ShareRecord extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'uid1' => 'require',
		'mobile1' => 'require',
		'nickname1' => 'require',
		'realname1' => 'require',
		'uid2' => 'require',
		'mobile2' => 'require',
		'nickname2' => 'require',
		'realname2' => 'require',
		'status' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'uid1.require' => '“邀请人uid”必须填写',
		'mobile1.require' => '“邀请人手机”必须填写',
		'nickname1.require' => '“邀请人昵称”必须填写',
		'realname1.require' => '“邀请人姓名”必须填写',
		'uid2.require' => '“被邀请人uid”必须填写',
		'mobile2.require' => '“被邀请人手机”必须填写',
		'nickname2.require' => '“被邀请人昵称”必须填写',
		'realname2.require' => '“被邀请人姓名”必须填写',
		'status.require' => '“邀请状态（0-未知 1-被邀请人注册 2-被邀请人支付）”必须填写',

    ];

	protected $scene = [
		'add'  => ["uid1", "mobile1", "nickname1", "realname1", "uid2", "mobile2", "nickname2", "realname2", "status"],
		'edit' => ["uid1", "mobile1", "nickname1", "realname1", "uid2", "mobile2", "nickname2", "realname2", "status"],
	];
}
