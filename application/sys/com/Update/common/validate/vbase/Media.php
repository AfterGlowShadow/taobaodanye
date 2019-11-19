<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Update\common\validate\vbase;

use think\Validate;

class Media extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name' => 'require|unique:sys_update_media,name',
		'media' => 'require',

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
		'media.require' => '“媒体视频”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "media"],
		'edit' => ["name", "media"],
	];
}
