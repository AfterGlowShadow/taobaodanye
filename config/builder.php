<?php

return [
	'config' => [
		// 默认没有归属
		'rha_app_type' => 'lib',
		'rha_package' => 'oth',
		
		
		// 数据表名称用于识别组件的前缀 例如：uu  ra_uu_user_log识别为组件user 模块也是log
		'table_module_name' => ['uu', 'wp'],
		// 默认组件名
		'default_module_name' => 'index',
		
		
		// 系统组件数据表名称用于识别组件的前缀 例如：sys  ra_sys_user_log识别为组件user 模块也是log
		'sys_table_module_name' => ['sys'],
		// 默认组件名
		'sys_default_module_name' => 'common',
		// sysAppType
		'sys_app_type' => 'lib',
		'sys_package' => 'sys',
		
		// 系统组件数据表名称用于识别组件的前缀 例如：app  ra_app_user_log识别为组件user 模块也是log
		'app_table_module_name' => ['app'],
		// 默认组件名
		'app_default_module_name' => 'common',
		// sysAppType
		'app_app_type' => 'lib',
		'app_package' => 'app',
		
		
	]
];