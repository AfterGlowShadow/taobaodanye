<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-15
 * Time: 17:16
 */

return [
	// 访问token过期时间（天） 30天
	'user_token_expires_in' => 30 * 24 * 60 * 60,
	
	'captcha'  => [
		// 验证码字符集合
		'codeSet'  => '1234567890',
		// 验证码字体大小(px)
		'fontSize' => 15,
		// 是否画混淆曲线
		'useCurve' => true,
		// 验证码图片高度
		'imageH'   => 30,
		// 验证码图片宽度
		'imageW'   => 100,
		// 验证码位数
		'length'   => 4,
		// 验证成功后是否重置
		'reset'    => true
	],
	
	// 后台管理员会话有效期（秒）
	'admin_session_expires_in' => 24 * 60 * 60,
	
	
	
];