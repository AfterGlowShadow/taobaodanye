<?php


return [
	'base_path' => [
		'lib' => [
			'build_root_path' => LIB_PATH,
			
			'build_dir_base_path' => LIB_DIR_NAME . '/{{$package}}/{{$appTag}}/{{$component}}/{{$module}}/{{$ver}}',
			'build_controller_base_path' => '{{$build_dir_base_path}}/controller',
			'build_logic_base_path' => '{{$build_dir_base_path}}/controller/logic',
			'build_model_base_path' => '{{$build_dir_base_path}}/model',
			'build_table_base_path' => '{{$build_dir_base_path}}/model/table',
			'build_validate_base_path' => '{{$build_dir_base_path}}/validate',
			'build_vbase_base_path' => '{{$build_dir_base_path}}/validate/vbase',
			
			'build_dir_path' => '{{$build_root_path}}{{$package}}/{{$appTag}}/{{$component}}/{{$module}}/{{$ver}}',
			'build_controller_path' => '{{$build_dir_path}}/controller',
			'build_logic_path' => '{{$build_dir_path}}/controller/logic',
			'build_model_path' => '{{$build_dir_path}}/model',
			'build_table_path' => '{{$build_dir_path}}/model/table',
			'build_validate_path' => '{{$build_dir_path}}/validate',
			'build_vbase_path' => '{{$build_dir_path}}/validate/vbase',
		],
		
	]
	
];