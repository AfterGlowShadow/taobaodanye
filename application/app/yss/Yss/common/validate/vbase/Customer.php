<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class Customer extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name' => 'require|unique:app_yss_customer,name',
		'head_img' => 'require',
		'honor' => 'require',
		'major' => 'require',
		'major_name' => 'require',
		'status' => 'require',
		'qq' => 'require',
		'phone' => 'require',
		'is_recommend' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '“客服名称”必须填写',
		'name.unique' => '“客服名称”已存在',
		'head_img.require' => '“头像”必须填写',
		'honor.require' => '“头衔”必须填写',
		'major.require' => '“专业”必须填写',
		'major_name.require' => '“专业”必须填写',
		'status.require' => '“状态 1正常 0禁用”必须填写',
		'qq.require' => '“QQ号”必须填写',
		'phone.require' => '“电话”必须填写',
		'is_recommend.require' => '“是否推荐”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "head_img", "honor", "major", "major_name", "status", "qq", "phone", "is_recommend"],
		'edit' => ["name", "head_img", "honor", "major", "major_name", "status", "qq", "phone", "is_recommend"],
	];
}
