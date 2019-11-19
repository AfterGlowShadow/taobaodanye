<?php

namespace app\sys\com\Crypt\common\v1\facade;

use think\Facade;

/**
 * @see \app\sys\com\Crypt\common\v1\logic\Crypt
 * @mixin \app\sys\com\Crypt\common\v1\logic\Crypt
 * @method array createToken($data = []) static
 * @method array checkToken($jwt = '') static
 */
class Crypt extends Facade {
	protected static function getFacadeClass()
	{
		return 'app\sys\com\Crypt\common\v1\logic\Crypt';
	}
}