<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Slide\common\model;


class Slide extends \app\sys\com\Slide\common\model\table\Slide {

	public static $_TYPE = [
		'none'   => 0,
		'homepage' => 1,  // 首页
	];
	
	public static $_STATUS = [
		'none' => 0,
		'enabled' => 1, // 启用
		'disabled' => 2, // 禁用
	];

}
