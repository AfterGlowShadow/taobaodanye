<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class Boutique extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'title' => 'require',
		'title_desc' => 'require',
		'price' => 'require',
		'icon' => 'require',
		'is_hot' => 'require',
		'url' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'title.require' => '“标题”必须填写',
		'title_desc.require' => '“描述”必须填写',
		'price.require' => '“价格”必须填写',
		'icon.require' => '“图标”必须填写',
		'is_hot.require' => '“是否热销”必须填写',
		'url.require' => '“链接”必须填写',

    ];

	protected $scene = [
		'add'  => ["title", "title_desc", "price", "icon", "is_hot", "url"],
		'edit' => ["title", "title_desc", "price", "icon", "is_hot", "url"],
	];
}
