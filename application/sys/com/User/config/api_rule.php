<?php

use app\sys\com\Rbac\common\model\Rule;

return [
	'api' => [
		// 管理员
		[
			'name' => '管理员管理',
			'title' => '管理员管理',
			'icon' => '',
			'intro' => '',
			'url' => '',
			'type' => Rule::$_TYPE['after'],
			'is_auth' => 0,
			'is_menu' => 1,
			'is_api' => 1,
			'sort' => 'auto',
			'remark' => '',
			'list' => [
				[
					'name' => '管理员管理',
					'title' => '管理员管理',
					'icon' => '',
					'intro' => '',
					'url' => '/sys/admin/Rbac.v1.Users.getList',
					'is_menu' => 1,
				],
				[
					'name' => '管理员管理',
					'title' => '管理员管理',
					'icon' => '',
					'intro' => '',
					'url' => '/sys/admin/Rbac.v1.Users.getList',
					'is_menu' => 1,
				],
			]
		]
	]
];
