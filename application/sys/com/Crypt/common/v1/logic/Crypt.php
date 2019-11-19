<?php


namespace app\sys\com\Crypt\common\v1\logic;


use Firebase\JWT\JWT;

class Crypt {
	private static $Key = 'meH0tL5rbiJagiOLywmhfQ==';
	
	public function createToken($data = []) {
		return $this->_createAPIToken($data);
	}
	
	public function checkToken($jwt = '') {
		return $this->_checkAPIToken($jwt);
	}
	
	
	/**
	 * 生成jwt token
	 * @param array  $payload 用户信息
	 * @param string $alg  加密类型
	 * @return string
	 */
	private function _createAPIToken($payload, $alg = 'HS256') {
		$jwtObj = new JWT();
		
		$key = self::$Key; //key
		
		$payload['expire_time'] = isset($payload['expire_time']) ? $payload['expire_time'] : (2 * 60 * 60);
		
		$payload['iat'] = time(); //$_SERVER['REQUEST_TIME'];//签发时间(必填参数)
		$payload['exp'] = time() + $payload['expire_time'];//过期时间(必填参数)
		unset($payload['expire_time']);
		$jwt            = $jwtObj::encode($payload, $key, $alg);
		
		$result = [
			'jwt' => $jwt,
		];
		return rsData($result);
	}
	
	/**
	 * 校验接口会话
	 * @param string $ciphertext jwt token
	 * @param array  $alg        解密类型
	 * @return array|boolean
	 */
	private function _checkAPIToken($ciphertext, $alg = ['HS256']) {
		$jwtObj  = new JWT();
		$key     = self::$Key; //key
		
		try {
			$decoded = $jwtObj::decode($ciphertext, $key, $alg);
			if (!empty($decoded)) {
				$jwtRet = json_decode(json_encode($decoded), true);
				//此处是一个一维数组，包含加密前的所有信息,可以根据实际情况做验证，并返回验证通过后的用户信息
				//用户信息验证：省略
				return rsData($jwtRet);
			} else {
				return rsErr('Controller: Interfaces | _checkAPIToken | token out of time!', 10011);
			}
		} catch (\Exception $e) {
			return rsErr($e->getMessage(), 10011);
		}
	}
	
}