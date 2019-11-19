<?php

namespace app\sys\com\EventMgr\common\v1\facade;

use think\Facade;

/**
 * @see \app\sys\com\EventMgr\common\v1\logic\EventCommon
 * @mixin \app\sys\com\EventMgr\common\v1\logic\EventCommon
 * @method \app\sys\com\EventMgr\common\v1\logic\EventCommon on($event, $callback, $top = false) static
 * @method array t($event, $params = [], $ignore_err = false, $ignore_result = false) static
 */
class Event extends Facade {
	protected static function getFacadeClass()
	{
		return 'app\sys\com\EventMgr\common\v1\logic\EventCommon';
	}
}