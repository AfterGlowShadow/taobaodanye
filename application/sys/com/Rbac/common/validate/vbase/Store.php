<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\validate\vbase;

use think\Validate;

class Store extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name' => 'require|unique:sys_rbac_store,name',
		'province' => 'require',
		'city' => 'require',
		'area' => 'require',
		'address' => 'require',
		'storekeeper_name' => 'require',
		'mobile' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '“店面名称”必须填写',
		'name.unique' => '“店面名称”已存在',
		'province.require' => '“省”必须填写',
		'city.require' => '“市”必须填写',
		'area.require' => '“区”必须填写',
		'address.require' => '“详细地址”必须填写',
		'storekeeper_name.require' => '“店主”必须填写',
		'mobile.require' => '“电话”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "province", "city", "area", "address", "storekeeper_name", "mobile"],
		'edit' => ["name", "province", "city", "area", "address", "storekeeper_name", "mobile"],
	];
}
