<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class Collection extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'uid' => 'require',
		'product_id' => 'require',
		'type' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'uid.require' => '“用户”必须填写',
		'product_id.require' => '“收藏的企业或服务id”必须填写',
		'type.require' => '“1企业 2服务”必须填写',

    ];

	protected $scene = [
		'add'  => ["uid", "product_id", "type"],
		'edit' => ["uid", "product_id", "type"],
	];
}
