<?php
// +----------------------------------------------------------------------
// | Description: 公共模型,所有模型都可继承此模型，基于RESTFUL CRUD操作
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\logic;

use Think\Exception;

class CommonException extends Exception {
	public $error_result = [];

	public function __construct($re = []) {
		parent::__construct();
		$this->error_result = $re;
	}

}