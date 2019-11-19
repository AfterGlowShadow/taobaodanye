<?php
namespace app\index\controller;

use app\api\model\SysConfigUserCoin;
use app\api\model\User;
use app\builder\logic\FileCommon;
use app\builder\logic\TableCommon;
use app\common\controller\Commons;
use app\common\job\JobFire;
use think\Controller;
use Think\Db;
use think\helper\Str;

class Test extends Commons {
    public function index()
    {

    }

    public function hello($name = 'ThinkPHP5')
    {
	    //$this->redirect('../registered', ['TP_token' => '1321321']);
	    //header('Location: /../registered.html?TP_token=' . '1231321');
	    //$this->redirect('index/Index', ['TP_token' => '1231321']);
	    //header('Location: /?TP_token=' . '1231321');
        return 'hello,' . $name;
    }
    
    public function testT() {
	    $jobFire = new JobFire();
	    
	    $_d = [];
	    $_d['taskTime'] = time();
	    $_d['data'] = [
		    'race_id' => 5,
	    ];
	    $re = $jobFire->actionWithRaceStartGo($_d);
	    echo json_encode_u($re);
    }
    
    public function makeModel() {
	    // $re = get_db_primary_key('photo_talk');
	    // return json_encode_u($re);
	    // $tableCommon = new TableCommon();
	    // $param = [];
	    // $param['path'] = 'application\api\model\table';
	    //
	    // $param['onCallBack'] = function ($reText, $text, $var, $param) {
	    // 	echo "<pre style='tab-size:4'>{$reText}</pre>";
	    // };
	    //
	    // $text = file_get_contents(app()->getAppPath() . 'builder\template\model\default.t');
	    // $var = $tableCommon->_var;
	    // $re = $tableCommon->allTable2VarValue($text, $var, $param);
		
	    $module = !empty(input('module')) ? input('module') : 'common';
	    p("开始生成模块 {$module}\n", 0);
	    
	    /** @var FileCommon $fileCommon */
	    $fileCommon = FileCommon::getInstance();
	    $fileCommon->modelMaker($module);
	    echo 'finish';
    }
	
	public function makeC() {
    	/** @var FileCommon $fileCommon */
		$fileCommon = FileCommon::getInstance();
		
		$module = !empty(input('module')) ? input('module') : 'api';
		p("开始生成控制器 {$module}\n", 0);
		$fileCommon->controllerMaker($module);
		echo 'finish';
	}
	
	public function makeV() {
		/** @var FileCommon $fileCommon */
		$fileCommon = FileCommon::getInstance();
		
		$module = !empty(input('module')) ? input('module') : 'common';
		p("开始生成验证器 {$module}\n", 0);
		$fileCommon->validateMaker($module);
		echo 'finish';
	}
	
	public function makeAll() {
		/** @var FileCommon $fileCommon */
		$fileCommon = FileCommon::getInstance();
		
		// model
		p("开始生成模块 common\n", 0);
		$fileCommon->modelMaker('common');
		p("\n", 0);
		
		// controller admin
		p("开始生成控制器 admin\n", 0);
		$fileCommon->controllerMaker('admin');
		p("\n", 0);
		// controller api
		p("开始生成控制器 api\n", 0);
		$fileCommon->controllerMaker('api');
		p("\n", 0);
		
		// validate
		p("开始生成验证器 common\n", 0);
		$fileCommon->validateMaker('common');
		echo 'finish';
	}

    public function testIncCoin() {
    	$uid = $this->p('uid');
	    $type = $this->p('type');
    	
	    // 增加迪龙币
	    $userModel = new User();
	    $_data = [];
	    $_data['uid'] = $uid;
	    $_data['type'] = $type;
	    $re = $userModel->incCoin($_data);
	    
	    return return_json($re);
    }
	
	/**
	 * 构建代码
	 * @param string $table
	 * @param int    $tabSize
	 */
	public function makeCode($table = '', $tabSize = 4) {
		$table_name = config('database.prefix') . $table;
		
        $_fields = Db::name($table)
	        ->getTableFields();
	
	    echo json_encode_u($_fields) . "<br />";
	    
	    $_s_fields = [];
	    $_FieldInfos = [];
	    $_field_star = [];
	
	    $_comments = get_db_column_comment($table);
	
	    foreach ($_fields as $row) {
		    $_f = $row;
		    $_pre = substr($_f,0, strpos($_f,"_") + 1);
		    $_sf = str_replace($_pre, '', $_f);
		
		    $_s_fields[] = $_sf;
		    $_field_star[] = ' * ' . $_sf;
		
		    $_FieldInfos[] = [
		    	'f' => $_f,
			    'pre' => $_pre,
			    'sf' => $_sf,
			    '_sf' => in_array($_sf, ['param']) ? '_' . $_sf : $_sf,
			    'comment' => isset($_comments[$_f]) ? $_comments[$_f] : '',
		    ];
	    }
	
	    // 计算制表符个数
	    $_max_charlength = arr_max_charlength($_field_star);
	
	    foreach ($_FieldInfos as &$item) {
		    $item['end_tab_len'] = char_end_tab_size(' * ' . $item['sf'], $_max_charlength + $tabSize * 2, $tabSize);
	    }
	
	    echo json_encode_u($_s_fields) . "<br />";
	    
	    
	    $s = '';
	    
	    // add
	    $s .= '&#9/**<br />';
	    $s .= '&#9&nbsp;* 添加<br />';
	    $s .= '&#9&nbsp;* <br />';
	
	    foreach ($_FieldInfos as $row) {
		    $_f = $row['f'];
		    $_pre = $row['pre'];
		    $_sf = $row['sf'];
		    $_comment = $row['comment'];
		    $_end_tab_len = $row['end_tab_len'];
		
		    if (in_array($_sf, ['create_time', 'update_time', 'id'])) {
			    continue;
		    }
		
		    $s .= '&#9&nbsp;* ' . $_sf . str_repeat('&#9', $_end_tab_len) . $_comment . '<br />';
	    }
	
	    $s .= '&#9&nbsp;* @return mixed|string<br />';
	    $s .= '&#9&nbsp;*/<br />';
	    
	    $s .= '&#9public function add() {<br />';
	    $s .= '&#9&#9/** @var $m ' . Str::studly($table) . ' */<br />';
	    $s .= '&#9&#9$m = $this->_model;<br />';
	    $s .= '&#9&#9$param = $this->param;<br />';
	    $s .= '&#9&#9<br />';
	    
	    foreach ($_FieldInfos as $row) {
		    $_sf = $row['sf'];
		    $__sf = $row['_sf'];
	    	
	    	if (in_array($_sf, ['create_time', 'update_time', 'id'])) {
	    		continue;
		    }
	    	
	    	$s .= '&#9&#9$' . $__sf . ' = $param[\'' . $_sf . '\'];<br />';
	    }
	
	    $s .= '&#9&#9<br />';
	    $s .= '&#9&#9$_data = [];<br />';
	
	    foreach ($_FieldInfos as $row) {
		    $_f = $row['f'];
		    $_pre = $row['pre'];
		    $_sf = $row['sf'];
		    $__sf = $row['_sf'];
		
		    if (in_array($_sf, ['create_time', 'update_time', 'id'])) {
			    continue;
		    }
		    
		    $s .= '&#9&#9$_data[\'' . $_f . '\'] = $' . $__sf . ';<br />';
	    }
	
	    $s .= '&#9&#9$re = $m->add($_data);<br />';
	    $s .= '&#9&#9if (!is_return_ok($re)) {<br />';
	    $s .= '&#9&#9&#9return return_json($re);<br />';
	    $s .= '&#9&#9}<br />';
	    $s .= '&#9&#9return return_json($re);<br />';
	    $s .= '&#9}<br />';
		
		/********************************
		 * edit
		 ********************************/
	    $s .= '&#9<br />';
	    $s .= '&#9/**<br />';
	    $s .= '&#9&nbsp;* 更改<br />';
	    $s .= '&#9&nbsp;* <br />';
	
	    foreach ($_FieldInfos as $row) {
		    $_f = $row['f'];
		    $_pre = $row['pre'];
		    $_sf = $row['sf'];
		    $_comment = $row['comment'];
		    $_end_tab_len = $row['end_tab_len'];
		
		    if (in_array($_sf, ['create_time', 'update_time'])) {
			    continue;
		    }
		
		    $s .= '&#9&nbsp;* ' . $_sf . str_repeat('&#9', $_end_tab_len) . $_comment . '<br />';
	    }
	
	    $s .= '&#9&nbsp;* @return mixed|string<br />';
	    $s .= '&#9&nbsp;*/<br />';
	    
	    $s .= '&#9public function edit() {<br />';
	    $s .= '&#9&#9/** @var $m ' . Str::studly($table) . ' */<br />';
	    $s .= '&#9&#9$m = $this->_model;<br />';
	    $s .= '&#9&#9$param = $this->param;<br />';
	    $s .= '&#9&#9<br />';
	
	    foreach ($_FieldInfos as $row) {
		    $_f = $row['f'];
		    $_pre = $row['pre'];
		    $_sf = $row['sf'];
		    $__sf = $row['_sf'];
		
		    if (in_array($_sf, ['create_time', 'update_time'])) {
			    continue;
		    }
		
		    if (in_array($_sf, ['id'])) {
			    $s .= '&#9&#9$' . $__sf . ' = $param[\'' . $_sf . '\'];<br />';
		    } else {
			    $s .= '&#9&#9$' . $__sf . ' = isset($param[\'' . $_sf . '\']) ? $param[\'' . $_sf . '\'] : \'\';<br />';
		    }
	    }
	
	    $s .= '&#9&#9<br />';
	    $s .= '&#9&#9$_data = [];<br />';
	
	    foreach ($_FieldInfos as $row) {
		    $_f = $row['f'];
		    $_pre = $row['pre'];
		    $_sf = $row['sf'];
		    $__sf = $row['_sf'];
		
		    if (in_array($_sf, ['create_time', 'update_time', 'id'])) {
			    continue;
		    }
		
		    $s .= '&#9&#9isset($param[\'' . $_sf . '\']) && ' . '$_data[\'' . $_f . '\'] = $' . $__sf . ';<br />';
	    }
	
	    $s .= '&#9&#9$re = $m->editById($id, $_data);<br />';
	    $s .= '&#9&#9if (!is_return_ok($re)) {<br />';
	    $s .= '&#9&#9&#9return return_json($re);<br />';
	    $s .= '&#9&#9}<br />';
	    $s .= '&#9&#9return rjOk();<br />';
	    $s .= '&#9}<br />';
		
		/**
		 * 验证
		 */
		$s .= '&#9<br />';
		$s .= 'class ' . Str::studly($table) . ' extends Validate {<br />';
		$s .= '&#9protected $rule = [<br />';
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'id'])) {
				continue;
			}
			
			if (in_array($_sf, ['name'])) {
				$s .= '&#9&#9\'' . $_f . '\' => \'' . 'require|unique:' . $table . ',' . $_f . '\',<br />';
			} elseif (in_array($_sf, ['email'])) {
				$s .= '&#9&#9\'' . $_f . '\' => \'' . 'require|email|unique:' . $table . ',' . $_f . '\',<br />';
			} else {
				$s .= '&#9&#9\'' . $_f . '\' => \'' . 'require' . '\',<br />';
			}
		}
		
		$s .= '&#9];<br />';
		$s .= '&#9<br />';
		$s .= '&#9protected $message = [<br />';
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			$_comment = $row['comment'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'id'])) {
				continue;
			}
			
			if (in_array($_sf, ['name'])) {
				$s .= '&#9&#9\'' . $_f . '.require\' => \'“' . $_comment . '”必须填写\',<br />';
				$s .= '&#9&#9\'' . $_f . '.unique\' => \'“' . $_comment . '”已存在\',<br />';
			} elseif (in_array($_sf, ['email'])) {
				$s .= '&#9&#9\'' . $_f . '.require\' => \'“' . $_comment . '”必须填写\',<br />';
				$s .= '&#9&#9\'' . $_f . '.email\' => \'“' . $_comment . '”邮箱格式不正确\',<br />';
				$s .= '&#9&#9\'' . $_f . '.unique\' => \'“' . $_comment . '”已存在\',<br />';
			} else {
				$s .= '&#9&#9\'' . $_f . '.require\' => \'“' . $_comment . '”必须填写\',<br />';
			}
		}
		
		$s .= '&#9];<br />';
		$s .= '&#9<br />';
		$s .= '&#9protected $scene = [<br />';
		
		$_arr_fields = [];
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'id', 'remarks', 'sort'])) {
				continue;
			}
			
			$_arr_fields[] = $_f;
		}
		
		$s .= '&#9&#9\'add\' => ' . str_replace('"', '\'', json_encode_u($_arr_fields)) . ',<br />';
		$s .= '&#9&#9\'edit\' => ' . str_replace('"', '\'', json_encode_u($_arr_fields)) . ',<br />';
		$s .= '&#9];<br />';
		
		$s .= '}<br />';
	    
	    p($s);
    }
	
	public function testBuildHtml() {
	
	}

}
