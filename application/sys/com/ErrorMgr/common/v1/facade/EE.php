<?php

namespace app\sys\com\ErrorMgr\common\v1\facade;

use think\Facade;

/**
 * @see \app\sys\com\ErrorMgr\common\v1\logic\ErrorCode
 * @mixin \app\sys\com\ErrorMgr\common\v1\logic\ErrorCode
 * @method \app\sys\com\ErrorMgr\common\v1\logic\ErrorCode load_config($object) static
 * @method \app\sys\com\ErrorMgr\common\v1\logic\ErrorCode load_config_mp($object) static
 * @method \app\sys\com\ErrorMgr\common\v1\logic\ErrorCode load_config_ma($object) static
 * @method \app\sys\com\ErrorMgr\common\v1\logic\ErrorCode code($code = 1000) static
 * @method \app\sys\com\ErrorMgr\common\v1\logic\ErrorCode msg($msg = '出错了 :(', $code = 1000) static
 * @method \app\sys\com\ErrorMgr\common\v1\logic\ErrorCode ok() static
 * @method \app\sys\com\ErrorMgr\common\v1\logic\ErrorCode data($data = []) static
 * @method \app\sys\com\ErrorMgr\common\v1\logic\ErrorCode me() static
 * @method array value() static
 * @method array v() static
 * @method array json() static
 */
class EE extends Facade {
	protected static function getFacadeClass()
	{
		return 'app\sys\com\ErrorMgr\common\v1\logic\ErrorCode';
	}
}