<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-15
 * Time: 17:16
 */

return [
	// 权限白名单
	'auth_white' => [
	    '/app/api/Tb.v1.Goodss.getItemByIdM',
        '/app/api/Tb.v1.Goodss.getListM',
        '/app/api/Tb.v1.Goodss.GetSGood',
        '/app/api/Tb.v1.Goodss.AttrisArray'
//		'/app/api/Trip.v1.Trips.getList',
//		'/app/api/Trip.v1.Trips.getItemById',
//		'/app/api/Sns.v1.Snss.getListNew',
//		'/app/api/Sns.v1.Snss.getList',
//		// '/app/api/Sns.v1.Snss.getListRecommend',
//		'/sys/api/Pay.v1.Payments.ali_notify_callback',
//		'/sys/api/Pay.v1.Payments.wx_notify_callback',
//
//        '/app/api/Yss.v1.CategoryDetails.getTree',
//        '/app/api/Yss.v1.Messages.getList',
//        '/app/api/Yss.v1.Ysss.getList',
//        '/app/api/Yss.v1.Facebacks.add',
//        '/app/api/Yss.v1.Industrys.getItemById',
//        '/app/api/Yss.v1.Industrys.getList',
//        '/app/api/Yss.v1.Ysss.add',
//        '/app/api/Yss.v1.Boutiques.getList',
//        '/sys/api/Slide.v1.Slides.getList',
	],


	// 访问token过期时间（天） 30天
	'user_token_expires_in' => 30 * 24 * 60 * 60,

	'captcha' => [
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


	// 登陆方式启用
	'login_use'                => [
		// 启用用户名（0-不启用 1-启用）
		'username' => 1,

		// 启用手机号（0-不启用 1-启用）
		'mobile'   => 1,

		// 默认登录方式
		//  user_passwd-用户名密码登录也是普通登录方式 用户名或手机号
		//  mobile_passwd-手机号密码登录
		//  mobile_code-手机号短信验证码登录
		//  mix_passwd-手机号或用户名登录
		'def_type' => 'mix_passwd',

		// 是否限制登录个数（只能单点登录 多点会被踢下来 token会变）
		'login_limit' => 0,
	],

	// 注册方式启用
	'reg_use'                  => [
		// 启用用户名（0-不启用 1-启用）
		'username' => 0,

		// 启用手机号（0-不启用 1-启用）
		'mobile'   => 1,

		// 启用短信验证码（0-不启用 1-启用）
		'sms_code' => 0,

		// 启用分享（0-不启用 1-启用）
		'share'    => 0,

		// 额外唯一校验
		'unique'   => [
			// 身份证号唯一校验（0-不启用 1-启用）
			'identity_number' => '"身份证号"已存在',
		],
	],

	'login_third' => [
		// QQ
		'qq' => [
			'app_id'        => '101534060',
			'app_secret'    => '864907b6930a1ad171fbf54cfe682c88',
			'scope'         => 'get_user_info',
		],
		'weixin' => [
			'app_id'     => 'wxbc4113c******',
			'app_secret' => '4749970d284217d0a**********',
			'scope'      => 'snsapi_base',//snsapi_userinfo如果需要静默授权，这里改成snsapi_base，扫码登录系统会自动改为snsapi_login
		],
		'weibo' => [
			'app_id'     => '2046828330',
			'app_secret' => 'be1ddf700b27e9c1e0c6b40c5df0c848',
			'scope'      => 'all',
		],
	],

	// 是否启用分享（0-不启用 1-启用）
	// 'enabled_user_share' => 0,

	// 短信验证码
	'sms_code'                 => [
		// 短信类型（0-未知 1-阿里大鱼 2-114）
//		'sms_type' => 2,

		// 114短信模板
//		'sms_114'  => [
//			'url'      => 'http://114.115.203.99:8088/Index.aspx',
//			'userid'   => '3013',
//			'account'  => 'yzm1234',
//			'password' => '2019888',
//			'content'  => '【旅游】',
//		],
        'sms_type' => 1,

        'ali_sms' => [
            //淘宝开放平台中，对应阿里大鱼短信应用的App Key
            'accessKeyId'     => 'LTAI4FeufQFix6okxtq7s6aa',
            //淘宝开放平台中，对应阿里大鱼短信应用的App Secret
            'accessKeySecret' => '2yWOZX4oSxEsMh7uw0kAr6YLRGujop',
            //短信签名，传入的短信签名必须是在阿里大鱼“管理中心-短信签名管理”中的可用签名
            'signName'        => '正信百创网',
            'templates'       => ['Aliyun'=>'SMS_177165391']
        ],
	],

	// 支付
	'pay'                      => [
		'expires_time' => 30 * 60, // 支付过期时间

		//'refund_no_admin_audit' => 0, // 退款是否不用后台审核（默认为0 需要后台审核）

		// 支付宝
		'alipay'       => [
			'app_id'         => '2016091900548569',
			'notify_url'     => 'http://fb.hbweipai.com/sys/api/Pay.Payments.ali_notify_callback',
			'return_url'     => 'http://fb.hbweipai.com/sys/api/Pay.Payments.ali_notify_callback',
			'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyxYxXFDM3CB7w2zzvJDLiwk2HQzFRimd86yGye62KVKUKqhZc7NdlYgGieWMMNlK1HT1C4N9H2o9mGBAqNNrQe8qLTX84VRYNoeLGCqjUQONSPO7BcdwtnglqNXM5348sObqYxbHQOMBRhl00AKYtS1WIGSI4qJn85SflDG5YYHasQmO24uM4ib85xFJuWqA5XBsPch0rG2hAKQ4+6lC7zRIdPXpVQA374u/R94vP23d3hrBBMIRLLqEkj8hO1On4kiHPn/msSP/IzdNZ8AlAHe9Hnct4DJGTnQuq0WptrL3l6vQkrJTRuD8cyW7lOJErx+JfT5ful9V4BDL/QsphQIDAQAB',
			// 加密方式： **RSA2**
			'private_key'    => 'MIIEpAIBAAKCAQEA0U2l7gHJvgS8u55t5j7NRJM2aw++yAk13QO2RvPC2i5nZK1bNNHfBegJNKkg9Sycegv2AdS0U9U6DrxnyOSZVT7F1MA3N+hesaZAodXEJM+ROw3OiaegwEsVd0p5oXiK6624atHEjoTvLqVpXYQBBs396rgxDClYsi4BEvHAybc1RpvDWbnWUnZ2tVo/F1/mJMRAj84UcIEeQDG9CwxplTpAhnW1WOc3u3swE5MjvUq2Ev1ewlw9JOEFQ/GtiZBlqPypugZvtDerMKqxw2+K8u6fgkTxMfEUvx+/OnldFICc0692mdESyofcpj5f5d19+zIqGEY7fwePEbXbp4c96QIDAQABAoIBAQCe2lvxRBIl0dqcWyX19fw8664Fm7GkiLkEwWh6eU+N4GJAmwH6GL838F/sQ+Drs6wfRSy1PwaOCetCe+QZKMbnV/k1+5ztJcOY+SFcsq1nctI7C8OR3lO3HkVwgGnID4EAVpz9FbAkqugNcyWBAEr3KyhoGNvA6zCSKzBNfIZhkPfGf8AIKfRLkD+OA+8jUOrUM4OSZqdGvFbgebRP8aOPo0w011gRtefuJ/6Oplndjck94vWxkpEFTIVdSK0lfzz0qZyt0PeGqOika+d6g5D2AKz+1t5B+1zV80lgMJrZZ4gmptl6MCbxf/K7+b2rC3uFQB3/WLbPikXKhH8OQyMxAoGBAOt+EqnSRA5gRkzpOanjgj+9tSTG1dTfeZ66uU83rI3dsAfxJ7Fl4XkqxLnx6uiONn1JpZXGCF3CGBFDrDYwOw1W6yVWnWtquP1iTDC3WDTS0gyicQqXZMiMRIgjbjKh/R9VZOzbI2Vkt0HM7cubzCpjJCiglXXA371GCntrY6ILAoGBAOOHut2+qhHdyJgnJTA6GnlFHpdWsztcD49ZPxcK8w7pDsLi5lBSZF/n263eGzpR2jFwSEO+VrNEvZNLXMdhVvq2NhKl1g84gh7dBjox2kxrvXI0hgjwQ6GmFNeBzEG4jyJs8QEabTFfcEbf67b+u9X9E8YjbzEKjGvtQXfQQGxbAoGADiAKyIrnMCGQNe7LWahe2KntYp5WlyUsa1vx35GMVRoWA/PwGJDu3FC3ahvbpkVZeVxghUJSoCUTQn3Xp4xvDlbHVf8DBD1riS9LOKTWspxuovlfZG4+SlU3ix7s7jaPM0DxA9AFKIDJCTZckRjwPx6hPZqcPGrsQLMhz9NaL48CgYEAnHdeXdccBSVLKLbisAOE6RhLLS+GGa/5U07AQAxbkUlbyVFXqKzAMeO0AiDXAIgBUDYyu8NMxALli0EsEEA0HDzpenFofxcRBEBiY+qcgCknIj5UXhk7qRIZCwpLeHZ+l+Hq6iNOK8HB6DtcUX9jlIhw7LS5ZjQm1KFXgBlJ9DkCgYB9yG6ZDQAhr9LvcP97KM9y9sPnTS0UUFTrDWsg52dGA9P8VlJar5wbn/rmH8Pj3Qp46yJXsGpT3ItoJgQmxnjyRIP0bSJtl1GMsbcpb7UQdCqrcBEqZ9tgGYRSPKgr2Ozqr2v9+xUMV5Qf5dX7vJydNPI35ecGbrNQUSfp8JplXQ==',
			'log'            => [ // optional
			                      'file'     => './logs/alipay.log',
			                      'level'    => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
			                      'type'     => 'single', // optional, 可选 daily.
			                      'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
			],
			'http'           => [ // optional
			                      'timeout'         => 5.0,
			                      'connect_timeout' => 5.0,
			                      // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
			],
			 'mode'           => 'dev', // optional,设置此参数，将进入沙箱模式dev
		],

		// 微信
		'wxpay' => [
			'appid'       => 'wxe76fa26787c19834', // APP APPID
			'app_id'      => 'wxe76fa26787c19834', // 公众号 APPID
			'miniapp_id'  => 'wxe76fa26787c19834', // 小程序 APPID
			'mch_id'      => '1560296211',
			'key'         => 'oCgfnaiYzvwOVIls3sALg5DbLhvOcROi',
			'notify_url'  => 'http://ex.hbweipai.com/sys/api/Pay.Payments.wx_notify_callback',
			'cert_client' => '../cert/apiclient_cert.pem', // optional，退款等情况时用到
			'cert_key'    => '../cert/apiclient_key.pem',// optional，退款等情况时用到
			'log'         => [ // optional
			                   'file'     => './logs/wechat.log',
			                   'level'    => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
			                   'type'     => 'single', // optional, 可选 daily.
			                   'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
			],
			'http'        => [ // optional
			                   'timeout'         => 5.0,
			                   'connect_timeout' => 5.0,
			                   // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
			],
			// 'mode'        => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
		],
	],


];