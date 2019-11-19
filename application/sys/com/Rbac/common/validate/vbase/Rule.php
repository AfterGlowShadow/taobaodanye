<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\validate\vbase;

use think\Validate;

class Rule extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'pid' => 'require',
		'name' => 'require|unique:sys_rbac_rule,name',
		'title' => 'require',
		'icon' => 'require',
		'intro' => 'require',
		'url' => 'require',
		'type' => 'require',
		'is_auth' => 'require',
		'is_menu' => 'require',
		'is_api' => 'require',
		'is_show' => 'require',
		'is_maker' => 'require',
		'tag' => 'require',
		'status' => 'require',
		'sort' => 'require',
		'remark' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'pid.require' => '“父级id”必须填写',
		'name.require' => '“用户名”必须填写',
		'name.unique' => '“用户名”已存在',
		'title.require' => '“标题（用于菜单显示）”必须填写',
		'icon.require' => '“图标（用于菜单显示）”必须填写',
		'intro.require' => '“简介”必须填写',
		'url.require' => '“链接”必须填写',
		'type.require' => '“类型（0-未知 1-通用 2-后台 3-前端）”必须填写',
		'is_auth.require' => '“是否校验权限（0-不校验 1-校验）”必须填写',
		'is_menu.require' => '“是否菜单（0-否 1-是）”必须填写',
		'is_api.require' => '“是否输出接口文档（0-否 1-是）”必须填写',
		'is_show.require' => '“是否显示在权限列表或菜单中（0-否 1-是）”必须填写',
		'is_maker.require' => '“是否为生成器生成（0-否 1-是）”必须填写',
		'tag.require' => '“标签（生成器用来识别）”必须填写',
		'status.require' => '“状态,1启用 0禁用”必须填写',
		'sort.require' => '“排序”必须填写',
		'remark.require' => '“备注”必须填写',

    ];

	protected $scene = [
		'add'  => ["pid", "name", "title", "icon", "intro", "url", "type", "is_auth", "is_menu", "is_api", "is_show", "is_maker", "tag", "status", "remark"],
		'edit' => ["pid", "name", "title", "icon", "intro", "url", "type", "is_auth", "is_menu", "is_api", "is_show", "is_maker", "tag", "status", "remark"],
	];
}
