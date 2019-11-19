<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Update\common\validate\vbase;

use think\Validate;

class Picture extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name' => 'require|unique:sys_update_picture,name',
		'thumb' => 'require',
		'picture' => 'require',
		'reduce' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '“文件名称”必须填写',
		'name.unique' => '“文件名称”已存在',
		'thumb.require' => '“缩略图”必须填写',
		'picture.require' => '“原图”必须填写',
		'reduce.require' => '“质量缩小正方图”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "thumb", "picture", "reduce"],
		'edit' => ["name", "thumb", "picture", "reduce"],
	];
}
