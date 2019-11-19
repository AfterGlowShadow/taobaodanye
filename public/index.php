<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/8
 * Time: 14:58
 */

// [ 应用入口文件 ]
namespace think;

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId, Authorization, Authorization-Token, Third-Session-Token");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS,PATCH');
    exit;
}

//header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Origin: http://192.168.1.147:8020');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId, Authorization, Authorization-Token, Third-Session-Token");

define('ENTR_PATH', 'public');
define('ROOT_PATH', __DIR__ . '/../');
define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', __DIR__ . '/../application/');
define('ADDON_ROUTE', '/app/');
define('EXTEND_PATH', ROOT_PATH . 'extend/');

define('PUBLIC_PATH', ROOT_PATH . 'public/');
define('LIB_PATH', __DIR__ . '/../application/');
define('LIB_SYS_PATH', LIB_PATH . 'sys/');
define('LIB_APP_PATH', LIB_PATH . 'app/');
define('LIB_OTH_PATH', LIB_PATH . 'oth/');
define('APP_TAG', 'yss');
define('APP_TAG_PATH', LIB_APP_PATH . APP_TAG . '/');
define('COM_PATH', __DIR__ . '/../application/sys/com/');

define('LIB_DIR_NAME', 'application');
//define('MP_DIR_NAME', 'addons');

define('DATEBASE_CONFIG', [
    // 数据库类型
    'type'            => 'mysql',
    // 服务器地址
    'hostname'        => '127.0.0.1',
    // 数据库名
    'database'        => 'yushushu',
    // 用户名
    'username'        => 'yushushu',
    // 密码
    'password'        => 'xC6XtqcaJdy2FkhnVpK',
    // 端口
    'hostport'        => '3306',
    // 数据库表前缀
    'prefix'          => 'wp_',
]);

// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';

// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应
Container::get('app',[APP_PATH])->run()->send();