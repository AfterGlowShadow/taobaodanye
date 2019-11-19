<?php

/**
 * 公共组件库com
 * com/组件名/小程序/版本/控制器/方法
 * com/goods/api/v1/group/list
 *
 * https://wx.uujia.net/com/test/miniapp/v1/test/index
 */
/*Route::rule('/com<_mid?>/:component/:_type/:ver/:col/:act', '\\app\\sys\\RouteCall@run')*/
// 	->middleware('Param');

// https://wx.uujia.net/com/miniapp/test.v1.test.index


Route::rule('/sys[:_com]/:_type/:component[:ver].:col.:act', '\\app\\sys\\RouteCall@run')
	->pattern(
		[
			'_com' => '_\w+',
			'_type' => '(api|admin)',
			'ver' => '.v\d+',
		])
	->middleware('Param');


return [

];