<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\api\controller;

use anerg\OAuth2\OAuth;
use app\sys\com\User\common\model\Third;
use think\Db;
use think\facade\Config;

/**
 * Class Thirds
 * 第三方登录记录表
 * @api_name 第三方登录记录
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 0
 * @package app\sys\com\User\api\controller
 */
class Thirds extends \app\sys\com\User\api\controller\logic\Thirds {

    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 登录第三方（其实是拿st换token）
	 * 第三方登录记录表
	 * @api_name 登录第三方
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Thirds.loginThird
	 *
	 * st
	 * openid
	 * channel
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function loginThird() {
		/** @var $m Third */
		$m = $this->_model;
		$param = $this->param;
		
		if (!isset($param['st']) || (!isset($param['openid']) && !isset($param['channel']))) {
			return rjErrCode(10001); // 缺少参数
		}
		
		$_data = [];
		if (isset($param['st'])) {
			$st = $param['st']; // third_session_token
			$_data['session_token'] = $st;
		} elseif (isset($param['openid']) && isset($param['channel'])) {
			$openid = $param['openid'];
			$channel = $param['channel'];
			$_data['openid'] = $openid;
			$_data['channel'] = $channel;
		}
		
		$re = $m->loginThird($_data);
		if (isErr($re)) {
			return return_json($re);
		}
		
		return return_json($re);
	}
	
	/**
	 * APP登录第三方
	 * 第三方登录记录表
	 * @api_name APP第三方登录
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Thirds.loginThirdApp
	 *
	 * openid
	 * channel
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function loginThirdApp() {
		/** @var $m Third */
		$m = $this->_model;
		$param = $this->param;
		
		$re = $m->loginThirdApp($param);
		return return_json($re);
	}
	
	/**
	 * 绑定用户
	 * 第三方登录记录表
	 * @api_name 绑定用户
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Thirds.bindingUser
	 *
	 * st
	 * uid
	 * @return mixed|string
	 */
	public function bindingUser() {
		/** @var $m Third */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $this->p['uid'];
		
		if (!isset($param['st']) || (!isset($param['openid']) && !isset($param['channel']))) {
			return rjErrCode(10001); // 缺少参数
		}
		
		$_data = [];
		$_data['uid'] = $uid;
		if (isset($param['st'])) {
			$st = $param['st']; // third_session_token
			$_data['session_token'] = $st;
		} elseif (isset($param['openid']) && isset($param['channel'])) {
			$openid = $param['openid'];
			$channel = $param['channel'];
			$_data['openid'] = $openid;
			$_data['channel'] = $channel;
		}
		
		$re = $m->bindingUser($_data);
		if (isErr($re)) {
			return return_json($re);
		}
		
		return return_json($re);
	}
	
	/**
	 * 解绑用户
	 * 第三方登录记录表
	 * @api_name 解绑用户
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Thirds.unbindingUser
	 *
	 * st
	 * @return mixed|string
	 */
	public function unbindingUser() {
		/** @var $m Third */
		$m = $this->_model;
		$param = $this->param;
		
		if (!isset($param['st']) || (!isset($param['openid']) && !isset($param['channel']))) {
			return rjErrCode(10001); // 缺少参数
		}
		
		$_data = [];
		if (isset($param['st'])) {
			$st = $param['st']; // third_session_token
			$_data['session_token'] = $st;
		} elseif (isset($param['openid']) && isset($param['channel'])) {
			$openid = $param['openid'];
			$channel = $param['channel'];
			$_data['openid'] = $openid;
			$_data['channel'] = $channel;
		}
		
		$re = $m->unbindingUser($_data);
		if (isErr($re)) {
			return return_json($re);
		}
		
		return return_json($re);
	}
	
	/**
	 * 第三方登录，执行跳转操作
	 * 第三方登录记录表
	 * @api_name H5三方登录
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Thirds.unbindingUser
	 *
	 * @param string $name 第三方渠道名称，目前可用的为：weixin,qq,weibo,alipay,facebook,twitter,line,google
	 * @return \think\response\Redirect
	 */
	public function login($name) {
		log_record('--- ### @@@1 login start');
		//获取配置
		$this->config = app_config('login_third.' . $name);
		
		//设置回跳地址
		$this->config['callback'] = $this->makeCallback($name);
		log_record('--- ### @@@' . $this->config['callback'] . ' xxx' . $name);
		//可以设置代理服务器，一般用于调试国外平台
		//$this->config['proxy'] = 'http://127.0.0.1:1080';
		
		/**
		 * 对于微博，如果登录界面要适用于手机，则需要设定->setDisplay('mobile')
		 *
		 * 对于微信，如果是公众号登录，则需要设定->setDisplay('mobile')，否则是WEB网站扫码登录
		 *
		 * 其他登录渠道的这个设置没有任何影响，为了统一，可以都写上
		 */
		return redirect(OAuth::$name($this->config)->getRedirectUrl());
		
		/**
		 * 如果需要微信代理登录，则需要：
		 *
		 * 1.将wx_proxy.php放置在微信公众号设定的回调域名某个地址，如 http://www.abc.com/proxy/wx_proxy.php
		 * 2.config中加入配置参数proxy_url，地址为 http://www.abc.com/proxy/wx_proxy.php
		 *
		 * 然后获取跳转地址方法是getProxyURL，如下所示
		 */
		//$this->config['proxy_url'] = 'http://www.abc.com/proxy/wx_proxy.php';
		//return redirect(OAuth::$name($this->config)->getProxyURL());
	}
	
	public function callback($name) {
		log_record('--- ### @@@1 callback start xxx' . $name);
		//获取配置
		$this->config = app_config('login_third.' . $name);
		
		//设置回跳地址
		$this->config['callback'] = $this->makeCallback($name);
		
		//获取格式化后的第三方用户信息
		$snsInfo = OAuth::$name($this->config)->userinfo();
		log_record("--- UserThirds callback snsInfo=" . json_encode_u($snsInfo));
		
		//获取第三方返回的原始用户信息
		//$snsInfoRaw = OAuth::$name($this->config)->userinfoRaw();
		
		//获取第三方openid
		//$openid = OAuth::$name($this->config)->openid();
		
		// 注册第三方记录
		/** @var $m Third */
		$m = $this->_model;
		$_d = [];
		$_d['ut_openid'] = $snsInfo['openid'];
		$_d['ut_unionid'] = $snsInfo['unionid'];
		$_d['ut_channel'] = $snsInfo['channel'];
		$_d['ut_nick'] = $snsInfo['nick'];
		$_d['ut_gender'] = $snsInfo['gender'];
		$_d['ut_avatar'] = $snsInfo['avatar'];
		$re = $m->regThird($_d);
		if (isErr($re)) {
			return return_json($re);
		}
		
		$reData = gData($re);
		if (empty($reData)) {
			return rjErrCode(40007); // 绑定失败
		}
		
		$isExist = $reData['isExist'];
		$isBinding = $reData['isBinding'];
		$st = $reData['third_session_token'];
		
		// todo: 跳转
		if ($isExist && $isBinding) {
			log_record('--- user Location1: TP_token=' . $st);
			//$this->redirect('index/Index', ['TP_token' => $st]);
			header('Location: /#/index?TP_token=' . $st);
			exit();
		} else {
			//$this->redirect('./registered.html', ['TP_token' => $st], 302);
			log_record('--- user Location2: TP_token=' . $st);
			// header('Location: /../zc.html?TP_token=' . $st);
			header('Location: /#/registered/index.html?TP_token=' . $st);
			exit();
		}
	}
	
	/**
	 * 生成回跳地址
	 *
	 * @return string
	 */
	private function makeCallback($name) {
		//注意需要生成完整的带http的地址
		$url = url('/login_third/callback/' . $name, '', false, true);
		$url = str_replace('index.php/', '', $url);
		log_record('===url='. $url);
		return $url;//html
	}

}
