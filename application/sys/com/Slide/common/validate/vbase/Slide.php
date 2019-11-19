<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Slide\common\validate\vbase;

use think\Validate;

class Slide extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'title' => 'require',
		'intro' => 'require',
		'img' => 'require',
		'url' => 'require',
		'type' => 'require',
		'status' => 'require',
		'remark' => 'require',
		'addon_name' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'title.require' => '“标题”必须填写',
		'intro.require' => '“简介”必须填写',
		'img.require' => '“图片”必须填写',
		'url.require' => '“链接”必须填写',
		'type.require' => '“类型（0-未知 1-首页）”必须填写',
		'status.require' => '“状态（0-未知 1-启用 2-禁用）”必须填写',
		'remark.require' => '“备注”必须填写',
		'addon_name.require' => '“应用名称”必须填写',

    ];

	protected $scene = [
		'add'  => ["title", "intro", "img", "url", "type", "status", "remark", "addon_name"],
		'edit' => ["title", "intro", "img", "url", "type", "status", "remark", "addon_name"],
	];
}
