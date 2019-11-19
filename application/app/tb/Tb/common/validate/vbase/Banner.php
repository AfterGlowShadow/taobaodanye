<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\common\validate\vbase;

use think\Validate;

class Banner extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'url' => 'require',
		'goodsid' => 'require',
		'img' => 'require',
		'remark' => 'require',
		'title' => 'require',
		'status' => 'require',
		'intro' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'url.require' => '“轮播图地址(外网)”必须填写',
		'goodsid.require' => '“商品id”必须填写',
		'img.require' => '“图片地址”必须填写',
		'remark.require' => '“备注”必须填写',
		'title.require' => '“标题”必须填写',
		'status.require' => '“状态（0-未知 1-启用 2-禁用）”必须填写',
		'intro.require' => '“简介”必须填写',

    ];

	protected $scene = [
		'add'  => ["url", "goodsid", "img", "remark", "title", "status", "intro"],
		'edit' => ["url", "goodsid", "img", "remark", "title", "status", "intro"],
	];
}
