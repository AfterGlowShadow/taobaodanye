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
		'/app/api/Trip.v1.Trips.getList',
		'/app/api/Trip.v1.Trips.getItemById',
		'/app/api/Sns.v1.Snss.getListNew',
		'/app/api/Sns.v1.Snss.getList',
		// '/app/api/Sns.v1.Snss.getListRecommend',
		'/sys/api/Pay.v1.Payments.ali_notify_callback',
		'/sys/api/Pay.v1.Payments.wx_notify_callback',

        '/app/api/Yss.v1.CategoryDetails.getTree',
        '/app/api/Yss.v1.Messages.getList',
        '/app/api/Yss.v1.Ysss.getList',
        '/app/api/Yss.v1.Facebacks.add',
        '/app/api/Yss.v1.Industrys.getItemById',
        '/app/api/Yss.v1.Industrys.getList',
        '/app/api/Yss.v1.Ysss.add',
        '/app/api/Yss.v1.Boutiques.getList',
        '/sys/api/Slide.v1.Slides.getList',
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
			'app_id'         => '2019102368608222',
			'notify_url'     => 'http://ex.hbweipai.com/sys/api/Pay.Payments.ali_notify_callback',
			'return_url'     => 'http://ex.hbweipai.com/sys/api/Pay.Payments.ali_return_callback',
			'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqvjBkg2HPveOvqAdtuoV4FNUzqQYDRDcRwL95ruEdfTkSpnfe3FgnaoogYqdjhPl1Wz6PVcLGiXYN6RXbbQ/6t0lVAxwxRX9nPvLjOgDyngYG/QBZlUs0qn7RTpN7y1Sgegp2Uki88mjy7GW+HVnCtyN5keMgcuHI8pUEL7bsIbGsW4b9+CK/ZbTODjZqxQgEnTaCh5Xj/W5ZPxThm50jtvOtRkYK0CmY1K8dsfLa4YT4k/dn39uPoW04tQIQnwXIeybKSSynTBTaM1nS/kuEUJEvPOjY+QnggqWrz3B5TrCAjiUjDVdDN5CwnlqXKgf4Y5BNZKIJlrlNmtLM8mxrwIDAQAB',
			// 加密方式： **RSA2**
			'private_key'    => 'MIIEogIBAAKCAQEAj3D8lNC3GFepoQX4GSdnxiDBxNfT3AOfotjBFVD6zg7q4RskRRTHGJjdJPWqUKSLAqZlgcdEiJ7d+Wa3Yr5DED57JYR2FdxjAaDWTFy+RAH7hx5re6cdrApQKp6BXshN6Z9CEcL/R65P03V+t5W2bUXTCb9plVahmMDIyGdb7Q9ABVLzuixYkUdLtaBo2eZYAu96BKFoTgWttNoOY90NvjXRvfdnSdovcA/pBP/vohXbPFS4jaTmbD6MarNZ5NIKHlaRttxHnN66HPmBZBXtgLoMeJwO723ikF8z52LyExLIhT+KNcEWRx98HsJreas3bA/DwyA64AcJMcCPtcxXzQIDAQABAoIBABJiCYzM3to4yd2AFVar7SnAIvUmL9mfgULugnhH44yq7sEgqFpOGmH1nUnSThx9qe8SAipKrmbP7WS8HD6EYbXgPAoH2tZcYzffM/efXyb6FhEv/dhgB3Z37+Q2YiASjaGmLmJ2Wh8GoOZZxX6jqjiA3VX/ePmRm64m7tR4IpjTzKz//mYli/vYau+9QVZbyZ7fMFhRh7NT7VQdTt8hg67wCN+ta7/9RSsOHc+Pu8XJ0N3IhfVchm61vf5Rmc00KOpdv5+3xDiR9AhaKjBUI3GzZ7aw4c5gqdD9Jf+CBcDWSnqYC1mzLGg3UCOafzb5B3/WYBVdBocNOPhV2xOnDEUCgYEA4y95L35X8cTR7cVLNHZAIowRAzA4C9NRRjmKp0JytMdehzSWcr4oXNdFcf1jtR9EhF/Q6behFPEamYQFQ1smUd5Fm2i2kwUGc5R5uTmXQFPoZfu8pcm0U6UxVIl3/lcUJDFvChqSIPTlMBJWvqGLHF6q8QxRCuPTFY/u+pA4OHcCgYEAoaJpKXPx11F1zOFsH4W4zVsL9sS/rfTJqLzaVI4QcA3coYEcFpwPyYECCKRCi/e4atZ/nA9kx+c3bzn2mIpIE9tHnNz+im3mN4cfHSi/XI+UAeyfwPOppFN7ca4zdKNGMupeaojF3FDdWnACX3jeWKf1+Gz0EkPWj5SQtYA4xtsCgYAQ7jTFyVCcf+J1KcLVAgr9iBqsdid3GiRwa1Fd7aHGvyTYRp7/phQz9wcB27RWhyIAC3PyNvEWMnGdBy2tO1m7uCjP0BnrEvDMJEB+AUC4Voh3MS9523JI2YK3nhcHKU4i9FwmEJzbP+TklDlKs5c+Yf+zPwu7GAdfD/7rRVwrOQKBgH4enRHkT4NkI5fvGQ/rpoxOC6LMWIhi5etNGMs7YqYcmthGRuV5dnQTvsOBcA+JBpQOtNnPxSKaTs3yG3FhDOa5hkJmyhK3uBgBzgxRnCecPK/Xs7u6JNd88Gh+tdXABOl7qJpWCJVlX6LOnXtjc5MX07y5PyT1W/kCwnttBmBbAoGACppEzarktJcCFVkaiwgYr+YJ/z6TAI7h/0ZTdd7VRJFt8x7Y94ZYG6uBsbR7HP4sK1AvDn0dPpFokUHEcPC22TIhQm/byuAXJJeyBhirwjyaNlovzzzAvOFB6qF6CAIraDLqcFwrKv+qizYkl6UtFgVz8K798cOyvHXfA0F7ihA=',
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
			// 'mode'           => 'dev', // optional,设置此参数，将进入沙箱模式
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