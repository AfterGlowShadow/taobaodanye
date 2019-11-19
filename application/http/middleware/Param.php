<?php

namespace app\http\middleware;

class Param {
	public function handle($request, \Closure $next) {
		// if (empty($request->param('_com'))) {
		// 	$request->_com = 'com';
		// }
		
		if (empty($request->param('ver'))) {
			$request->ver = 'v1';
		} else {
			$request->ver = preg_replace('/.(v\d+)/i', '$1', $request->param('ver'));
		}
		
		if (!empty($request->param('component'))) {
			$request->setModule($request->param('component'));
		}
		
		if (!empty($request->param('col'))) {
			$request->setController($request->param('col'));
		}
		
		if (!empty($request->param('act'))) {
			$request->setAction($request->param('act'));
		}
		
		return $next($request);
	}
}