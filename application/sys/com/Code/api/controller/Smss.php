<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Code\api\controller;

use app\sys\com\Code\common\model\Sms;
use think\Db;

/**
 * Class Smss
 * 轮播图表
 * @api_name 轮播图
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Code\api\controller
 */
class Smss extends \app\sys\com\Code\api\controller\logic\Smss {

    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 发送短信验证码
	 * 短信验证码表
	 *
	 * @api_name        发送短信验证码
	 * @api_type        3
	 * @api_is_menu     0
	 * @api_is_maker    1
	 * @api_is_show     1
	 * @api_is_def_name 0
	 * @api_url         /sys/api/code.v1.smss.sendSmsCode
	 *
	 * mobile
	 * code_type
	 * @throws \Toplan\PhpSms\PhpSmsException
	 */
	public function sendSmsCode() {
		/** @var $m Sms */
		$m = $this->_model;
		$param = $this->param;
		
		$re = $m->getSmsCode($param);
		
		return return_json($re);
	}
	
	/**
	 * 验证短信验证码
	 * 短信验证码表
	 * @api_name 验证短信验证码
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/code.v1.smss.checkSmsCode
	 *
	 * mobile
	 * code
	 * code_type
	 *
	 * @throws \think\Exception
	 */
	public function checkSmsCode() {
		/** @var $m Sms */
		$m = $this->_model;
		$param = $this->param;
		
		$re = $m->checkSmsCode($param);
		
		return return_json($re);
	}

}
