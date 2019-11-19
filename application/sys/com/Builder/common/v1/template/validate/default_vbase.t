<?php
// +----------------------------------------------------------------------
// | Description: {{$FileDescription}}
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace {{$Namespace}};

use think\Validate;

class {{$ClassName}} extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
{{$ruleList}}
	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
{{$messageList}}
    ];

	protected $scene = [
		'add'  => [{{$sceneAddList}}],
		'edit' => [{{$sceneEditList}}],
	];
}
