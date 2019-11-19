<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

if (defined('IN_BASE_COMMON')) {
    return true;
}

define('IN_BASE_COMMON', 1);

// 应用公共文件
use think\facade\Env;
use think\facade\Log;
use think\Db;
use think\helper\Str;

// function empty_default($data, $def = '') {
// 	return !empty($data) ? $data : $def;
// }
//
// function emDef($data, $def = '') {
// 	return !empty($data) ? $data : $def;
// }
//
// function isset_default($data, $def = '') {
// 	return isset($data) ? $data : $def;
// }
//
// function itDef($data, $def = '') {
// 	return isset($data) ? $data : $def;
// }

/**
 * @param $result
 * @return bool
 */
function is_return_ok($result)
{
    return is_return_status_ok($result);
}

function isOk($result)
{
    return is_return_status_ok($result);
}

function isErr($result)
{
    return !is_return_status_ok($result);
}

function get_return_msg($re)
{
    return get_return_status_msg($re);
}

function gMsg($re)
{
    return get_return_status_msg($re);
}

function get_return_code($re)
{
    return get_return_status_code($re);
}

function gCode($re)
{
    return get_return_status_code($re);
}

function get_return_data($re)
{
    return get_return_status_data($re);
}

function gData($re)
{
    return get_return_status_data($re);
}

function get_return_getlist_total($re)
{
    return get_return_status_getlist_total($re);
}

function glTotal($re)
{
    return get_return_status_getlist_total($re);
}

function get_return_getlist_data($re)
{
    return get_return_status_getlist_data($re);
}

function glData($re)
{
    return get_return_status_getlist_data($re);
}

function get_return_errormsg($re)
{
    return get_return_code($re) . get_return_msg($re);
}

function gErrMsg($re)
{
    return get_return_code($re) . get_return_msg($re);
}

/**
 * @return mixed|string
 */
function return_json_ok($msg = 'ok')
{
    log_record('@@@ return = ' . json_encode_u(return_status_ok()));
    return return_json(return_status_ok('ok', 0, $msg));
}

function rjOk()
{
    log_record('@@@ return = ' . json_encode_u(return_status_ok()));
    return return_json(return_status_ok());
}

/**
 * @param $data
 * @return mixed|string
 */
function return_json_ok_data($data)
{
    log_record('@@@ return = ' . json_encode_u(return_status_ok_data($data)));
    return return_json(return_status_ok_data($data));
}

function rjData($data)
{
    log_record('@@@ return = ' . json_encode_u(return_status_ok_data($data)));
    return return_json(return_status_ok_data($data));
}

/**
 * @param     $msg
 * @param int $code
 * @return mixed|string
 */
function return_json_err($msg, $code = 1000)
{
    log_record('@@@ return = ' . json_encode_u(return_status_err($msg, $code)));
    return return_json(return_status_err($msg, $code));
}

function rjErr($msg, $code = 1000)
{
    log_record('@@@ return = ' . json_encode_u(return_status_err($msg, $code)));
    return return_json(return_status_err($msg, $code));
}

/**
 * @param int $code
 * @return \think\response\Json
 */
function return_json_err_c($code = 1000)
{
    log_record('@@@ return = ' . json_encode_u(return_status_err_c($code)));
    return return_json(return_status_err_c($code));
}

function rjErrCode($code = 1000)
{
    log_record('@@@ return = ' . json_encode_u(return_status_err_c($code)));
    return return_json(return_status_err_c($code));
}

/**
 * @param $re
 * @return mixed|string
 */
function return_json($re)
{
    log_record('@@@ return = ' . json_encode_u($re));
    return json($re);
}

function rjson($re)
{
    log_record('@@@ return = ' . json_encode_u($re));
    return json($re);
}

function result_array_err_c($code = 1000)
{
    $re = return_status_err_c($code);
    return result_array_error($re);
}

function result_array_error($re)
{
    // return resultArray(['error' => get_return_errormsg($re)]);
    return rjErr(get_return_errormsg($re));
}

function result_array_data($re)
{
    $data = get_return_data($re);
    // return resultArray(['data' => $data]);
    return rjData($data);
}

function result_array_ok()
{
    return result_array_data([]);
}

function result_array($re)
{
    if (!is_return_ok($re)) {
        return result_array_error($re);
    }

    return result_array_data($re);
}

function result_array_err_c_static($code = 1000)
{
    $re = return_status_err_c($code);
    return result_array_error_static($re);
}

function result_array_error_static($re)
{
    // return resultArray_static(['error' => get_return_errormsg($re)]);
    return return_status_err(get_return_errormsg($re));
}

function result_array_data_static($re)
{
    $data = get_return_data($re);
    // return resultArray_static(['data' => $data]);
    return return_status_ok_data($data);
}

function result_array_ok_static()
{
    return result_array_data_static([]);
}

function result_array_static($re)
{
    if (!is_return_ok($re)) {
        return result_array_error_static($re);
    }

    return result_array_data_static($re);
}

/**
 * 返回成功
 * @param string $status
 * @param int $code
 * @param string $msg
 * @return array
 */
function return_status_ok($status = 'ok', $code = 200, $msg = 'ok')
{
    return ['status' => $status, 'code' => $code, 'msg' => $msg];
}

function rsOk()
{
    return ['status' => 'ok', 'code' => 200, 'msg' => 'ok'];
}

/**
 * 返回成功 带数据
 * @return array
 */
function return_status_ok_data($data)
{
    return ['status' => 'ok', 'code' => 200, 'msg' => 'ok', 'result' => $data];
}

function rsData($data)
{
    return ['status' => 'ok', 'code' => 200, 'msg' => 'ok', 'result' => $data];
}

/**
 * 返回错误
 *
 * @param string $msg
 * @param int $code
 * @param array $data
 * @return array
 */
function return_status_err($msg = '', $code = 1000, $data = null)
{
    if (empty($msg)) {
        $_msg = ec($code);
        $msg = empty($_msg) ? '' : $_msg;
    }

    $result = ['status' => 'error', 'code' => $code, 'msg' => $msg];
    if ($data !== null) {
        $result['result'] = $data;
    }

    return $result;
}

function rsErr($msg = '', $code = 1000, $data = null)
{
    return return_status_err($msg, $code, $data);
}

function return_status_err_c($code = 1000, $data = null)
{
    return return_status_err('', $code, $data);
}

function rsErrCode($code = 1000, $data = null)
{
    return return_status_err('', $code, $data);
}

/**
 * 返回值是否ok
 * @param $result
 * @return bool
 */
function is_return_status_ok($result)
{
    if (empty($result)) {
        return false;
    }

    if (!array_key_exists('status', $result) || empty($result['status'])) {
        return false;
    }

    if ($result['status'] != 'ok') {
        return false;
    }

    return true;
}

/**
 * 获取返回值错误消息
 * @param $result
 * @return string
 */
function get_return_status_msg($result)
{
    if (empty($result)) {
        return '';
    }

    if (!array_key_exists('msg', $result) || empty($result['msg'])) {
        return '';
    }

    return $result['msg'];
}

/**
 * 获取返回值错误代码
 * @param $result
 * @return int
 */
function get_return_status_code($result)
{
    if (empty($result)) {
        return 1000;
    }

    if (!array_key_exists('code', $result) || empty($result['code'])) {
        return 1000;
    }

    return $result['code'];
}

/**
 * 获取返回值附加数据
 * @param $result
 * @return array|int
 */
function get_return_status_data($result)
{
    if (empty($result)) {
        return [];
    }

    if (!array_key_exists('result', $result) || empty($result['result'])) {
        return [];
    }

    return $result['result'];
}

/**
 * 获取返回值附加数据 getlist专属
 * @param $result
 * @return array|int
 */
function get_return_status_getlist_data($result)
{
    $reData = get_return_status_data($result);

    return $reData['data'];
}

/**
 * 获取返回值附加数据 getlist专属
 * @param $result
 * @return array|int
 */
function get_return_status_getlist_total($result)
{
    $reData = get_return_status_data($result);

    return $reData['total'];
}

/**
 * 获取返回值附加数据 additem专属
 * @param $result
 * @return array|int
 */
function get_return_status_additem_id($result)
{
    $reData = get_return_status_data($result);

    return $reData['id'];
}

/**
 * 获取返回值附加数据 check_expires_in专属
 * @param $result
 * @return array|int
 */
function get_return_status_check_expires_in($result)
{
    $reData = get_return_status_data($result);

    return $reData['check'];
}

/**
 * 读取配置 错误代码对应消息
 * @param $code
 * @return mixed
 */
function read_config_error_code($code)
{
    // $c = config('error_code.error_code');
    $c = error_config('error_code.');

    $r = '未知错误';
    if (isset($c[$code])) {
        $r = $c[$code];
    } else {
        $c = config('error_code.error_code');
        $r = $c[$code];
    }

    return !empty($r) ? $r : '未知错误';
}

// function read_config_withdraw($name) {
// 	$c = config('sys_config.withdraw');
// 	return $c[$name];
// }
//
// function read_config_lucky_bonus($name) {
// 	$c = config('sys_config.lucky_bonus');
// 	return $c[$name];
// }
//
// function read_config_coin_activated_days($name) {
// 	$c = config('sys_config.coin_activated_days');
// 	return $c[$name];
// }
//
// function read_config_play_count($name) {
// 	$c = config('sys_config.play_count');
// 	return $c[$name];
// }
//
// function read_config_play_money($name) {
// 	$c = config('sys_config.play_money');
// 	return $c[$name];
// }

/**
 * 读取配置 错误代码对应消息
 * @param $code
 * @return mixed
 */
function ec($code)
{
    return read_config_error_code($code);
}

function defi($obj, $key, $def)
{
    return isset($obj[$key]) ? $obj[$key] : $def;
}

function defe($obj, $key, $def)
{
    return !empty($obj[$key]) ? $obj[$key] : $def;
}

function require_param_die($param, $miss = [])
{
    foreach ($miss as $item) {
        if (!array_key_exists($item, $param)) {
            exit(json_encode_u(rsErrCode(10001)));
        }
    }
}

function empty_param_die($param, $miss = [], $msg = [])
{
    foreach ($miss as $k => $v) {
        if (!array_key_exists($v, $param) || empty($param[$v])) {
            if (!empty($msg[$v])) {
                exit(json_encode_u(rsErr($msg[$v], 10001)));
            }
            exit(json_encode_u(rsErrCode(10001)));
        }
    }
}

/**
 * 调试方法
 * @param array $data
 * @param int $die
 */
function p($data, $die = 1)
{
    echo "<pre style='tab-size: 4'>";
    print_r($data);
    echo "</pre>";
    if ($die) die;
}

/**
 * 用户密码加密方法
 * @param  string $str 加密的字符串
 * @param  string $auth_key 加密符
 * @return string           加密后长度为32的字符串
 */
function user_md5($str, $auth_key = '')
{
    return '' === $str ? '' : md5(sha1($str) . $auth_key);
}

function json_encode_u($s)
{
    return json_encode($s, JSON_UNESCAPED_UNICODE);
}

/**
 * 日志记录
 * @param        $s
 * @param string $file __FILE__
 * @param string $method __METHOD__
 */
function log_record($s, $file = '', $method = '')
{
    $f = substr($file, strripos($file, "/") + 1);
    Log::record("---{$f} {$method} {$s}");
}

/**
 * 生成随机字符串
 * @param int $len
 * @return string
 */
function makeRandChars($len = 6)
{
    $chars_arr = [
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j',
        'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',
        'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D',
        'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
        'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
        'Y', 'Z'];
    $chars_length = count($chars_arr) - 1;
    $code = '';
    for ($i = 0; $i < $len; $i++) {
        $code .= $chars_arr[rand(0, $chars_length)];
    }

    return $code;
}

/**
 * 生成邀请码
 * @param int $len
 * @return string
 */
function makeInviteCode($len = 6)
{
    return makeRandChars($len);
}

/**
 * 生成唯一标识
 * @param $uid
 * @return string
 */
function makeAccessToken($uid = 0)
{
    $rand = rand(100000, 999999);
    $unipid = uniqid();
    $access_token = $uid . $rand . $unipid . time();
    return md5($access_token);
}

function makeLongToken($uid = 0)
{
    $rand = rand(100000, 999999);
    $unipid = uniqid(mt_rand(), true);
    $access_token = $uid . $rand . $unipid . time();
    return sha1($access_token);
}

/**
 * 生成订单编号
 * @param $uid
 * @return mixed
 */
function createOrderId($uid = 0)
{
    //return date('Ymd') . substr('00000000' . $uid, -8) . rand(1000, 9999);
    //生成24位唯一订单号码，格式：YYYY-MMDD-HHII-SS-NNNN,NNNN-CC，
    //其中：YYYY=年份，MM=月份，DD=日期，HH=24格式小时，II=分，SS=秒，NNNNNNNN=随机数，CC=检查码
    //while (true) {
    //订购日期
    //$order_date = date('Y-m-d');
    //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
    $order_id_main = date('YmdHis') . rand(10000000, 99999999);
    //订单号码主体长度
    $order_id_len = strlen($order_id_main);
    $order_id_sum = 0;
    for ($i = 0; $i < $order_id_len; $i++) {
        $order_id_sum += (int)(substr($order_id_main, $i, 1));
    }
    //}
    //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
    $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
    return $order_id;
}

/**
 * 生成外部订单编号
 * @param $uid
 * @return mixed
 */
function createOrderId_pay($uid = 0)
{
    //return date('Ymd') . substr('00000000' . $uid, -8) . rand(1000, 9999) . rand(1000, 9999);
    //生成24+2位唯一订单号码，格式：YYYY-MMDD-HHII-SS-NNNN,NNNN-XX-CC，
    //其中：YYYY=年份，MM=月份，DD=日期，HH=24格式小时，II=分，SS=秒，NNNNNNNN=随机数, XX=随机数，CC=检查码
    //while (true) {
    //订购日期
    //$order_date = date('Y-m-d');
    //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
    $order_id_main = date('YmdHis') . rand(10000000, 99999999) . rand(10, 99);
    //订单号码主体长度
    $order_id_len = strlen($order_id_main);
    $order_id_sum = 0;
    for ($i = 0; $i < $order_id_len; $i++) {
        $order_id_sum += (int)(substr($order_id_main, $i, 1));
    }
    //}
    //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
    $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
    return $order_id;
}

/**
 * 生成随机英文数字
 * @param $uid
 * @return mixed
 */
function createOrderSn($uid = 24)
{
    $order_id_main = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';  //36
    $order_id_sum = '';
    for ($i = 0; $i < $uid; $i++) {
        $order_id_sum .= (int)(substr(str_shuffle($order_id_main), $i, 1));
    }
    return $order_id_sum;
}


/**
 * post请求
 * @param string $url
 * @param array $param
 * @return mixed
 * @throws Exception
 */
function post($url, $param = [])
{
    if (!is_array($param)) {
        throw new Exception("参数必须为array");
    }

    $httph = curl_init($url);

    $_param = json_encode_u($param);

//	curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
//	curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 1);
    curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($httph, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
    curl_setopt($httph, CURLOPT_POST, 1);//设置为POST方式
    curl_setopt($httph, CURLOPT_POSTFIELDS, $_param);
    curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($httph, CURLOPT_HEADER, 1);

    $rst = curl_exec($httph);

    curl_close($httph);

    return $rst;
}

/**
 * @access protected
 * @param         $url
 * @param  string $message - 发送的消息
 * @return bool
 */
function send($url, $message = '')
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $headers = [
        "Content-Type: application/json;charset=UTF-8",
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //设置header

    return curl_exec($ch);
}

/**
 * 发送HTTP请求方法
 * @param  string $url 请求URL
 * @param  array $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @param array $header
 * @param bool $multi
 * @return array  $data   响应数据
 * @throws Exception
 */
function http($url, $params, $method = 'GET', $header = array(), $multi = false)
{
    $opts = array(
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER => $header
    );
    /* 根据请求类型设置特定参数 */
    switch (strtoupper($method)) {
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) throw new Exception('请求发生错误：' . $error);
    return $data;
}

/**
 * 产生随机小数的函数
 */
// function randomFloat($min, $max) {
// 	return $min + mt_rand() / mt_getrandmax() * ($max - $min);
// }

mb_internal_encoding('utf-8'); // @important

function str_pad_unicode($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT)
{
    $str_len = mb_strlen($str);
    $pad_str_len = mb_strlen($pad_str);
    if (!$str_len && ($dir == STR_PAD_RIGHT || $dir == STR_PAD_LEFT)) {
        $str_len = 1; // @debug
    }
    if (!$pad_len || !$pad_str_len || $pad_len <= $str_len) {
        return $str;
    }

    $result = null;
    $repeat = ceil($str_len - $pad_str_len + $pad_len);
    if ($dir == STR_PAD_RIGHT) {
        $result = $str . str_repeat($pad_str, $repeat);
        $result = mb_substr($result, 0, $pad_len);
    } else if ($dir == STR_PAD_LEFT) {
        $result = str_repeat($pad_str, $repeat) . $str;
        $result = mb_substr($result, -$pad_len);
    } else if ($dir == STR_PAD_BOTH) {
        $length = ($pad_len - $str_len) / 2;
        $repeat = ceil($length / $pad_str_len);
        $result = mb_substr(str_repeat($pad_str, $repeat), 0, floor($length))
            . $str
            . mb_substr(str_repeat($pad_str, $repeat), 0, ceil($length));
    }

    return $result;
}

/**
 * 获取数据库字段注释
 *
 * @param string $table_name 数据表名称(必须，不含前缀)
 * @param string $field 字段名称(默认获取全部字段,单个字段请输入字段名称)
 * @param string $table_schema 数据库名称(可选)
 * @return string
 */
function get_db_column_comment($table_name = '', $field = true, $table_schema = '')
{
    // 接收参数
    $database = config('database.');
    $table_schema = empty($table_schema) ? $database['database'] : $table_schema;
    !startwith($table_name, $database['prefix']) && $table_name = $database['prefix'] . $table_name;

    // 缓存名称
    $fieldName = $field === true ? 'allField' : $field;
    $cacheKeyName = 'db_' . $table_schema . '_' . $table_name . '_' . $fieldName;

    // 处理参数
    $param = [
        $table_name,
        $table_schema
    ];

    // 字段
    $columeName = '';
    if ($field !== true) {
        $param[] = $field;
        $columeName = "AND COLUMN_NAME = ?";
    }

    // 查询结果
    $result = Db::query("
		SELECT COLUMN_NAME as field, column_comment as comment, data_type AS datatype, COLUMN_TYPE AS columntype
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE table_name = ? AND table_schema = ? $columeName"
        , $param);
    // pp(Db :: getlastsql());
    if (empty($result) && $field !== true) {
        return $table_name . '表' . $field . '字段不存在';
    }

    // 处理结果
    foreach ($result as $k => $v) {
        $_d = [
            'comment' => '',
            'datatype' => $v['datatype'],
            'columntype' => $v['columntype'],
            'datasize' => 0,

            // decimal
            'precision' => 0, // 小数位数

            // enum
            'enumtext' => '',
            'enumtext_arr' => [],
        ];

        $_preg = [];
        preg_match_all("/(?:\()(.*)(?:\))/i", $v['columntype'], $_preg);
        if (!empty($_preg) && !empty($_preg[1][0])) {
            switch ($v['datatype']) {
                case 'enum':
                    $_d['enumtext'] = $_preg[1][0];
                    $_d['enumtext_arr'] = explode(",", $_d['enumtext']);
                    break;
                case 'decimal':
                    $_s = $_preg[1][0];
                    $_arr = explode(",", $_s);
                    $_d['datasize'] = $_arr[0];
                    $_d['precision'] = $_arr[1];
                    break;
                default:
                    $_d['datasize'] = $_preg[1][0];
                    break;
            }
        }

        if (strpos($v['comment'], '#*#') !== false) {
            $tmpArr = explode('#*#', $v['comment']);
            $_d['comment'] = json_decode(end($tmpArr), true);
        } else {
            $_d['comment'] = $v['comment'];
        }

        $data[$v['field']] = $_d;
    }

    // 字段注释格式不正确
    if (empty($data)) {
        return $table_name . '表' . $field . '字段注释格式不正确';
    }

    return count($data) == 1 ? reset($data) : $data;
}

/**
 * 获取数据库字段注释
 *
 * @param string $table_name 数据表名称(必须，不含前缀)
 * @param string $field 字段名称(默认获取全部字段,单个字段请输入字段名称)
 * @param string $table_schema 数据库名称(可选)
 * @return array|bool
 */
function get_db_column($table_name = '', $field = true, $table_schema = '')
{
    // 接收参数
    $database = config('database.');
    $table_schema = empty($table_schema) ? $database['database'] : $table_schema;
    $table_name = $database['prefix'] . $table_name;

    // 缓存名称
    $fieldName = $field === true ? 'allField' : $field;
    $cacheKeyName = 'db_' . $table_schema . '_' . $table_name . '_' . $fieldName;

    // 处理参数
    $param = [
        $table_name,
        $table_schema
    ];

    // 字段
    $columeName = '';
    if ($field !== true) {
        $param[] = $field;
        $columeName = "AND COLUMN_NAME = ?";
    }

    // 查询结果
    $result = Db::query("
		SELECT COLUMN_NAME as field, column_comment as comment, data_type as type
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE table_name = ? AND table_schema = ? $columeName"
        , $param);
    // pp(Db :: getlastsql());
    if (empty($result) && $field !== true) {
        return false; //$table_name . '表' . $field . '字段不存在';
    }

    // 处理结果
    foreach ($result as $k => $v) {
        if (strpos($v['comment'], '#*#') !== false) {
            $tmpArr = explode('#*#', $v['comment']);
            $data[$v['field']] = [
                'comment' => json_decode(end($tmpArr), true),
            ];
        } else {
            $data[$v['field']] = [
                'comment' => $v['comment'],
            ];
        }

        $data[$v['field']]['type'] = $v['type'];
    }

    // 字段注释格式不正确
    if (empty($data)) {
        return false;//$table_name . '表' . $field . '字段注释格式不正确';
    }

    return count($data) == 1 ? reset($data) : $data;
}

/**
 * 获取物理表已存在的主键字段名
 * @param string $table_name
 * @param string $table_schema
 * @return string results 查询结果
 */
function get_db_primary_key($table_name = '', $table_schema = '')
{
    // 接收参数
    $database = config('database.');
    $table_schema = empty($table_schema) ? $database['database'] : $table_schema;
    $table_name = $database['prefix'] . $table_name;

    // 处理参数
    $param = [
        'table_name' => $table_name
    ];

    // 查询结果
    $result = Db::query("show keys from {$table_name} where key_name='PRIMARY'");

    if (empty($result)) {
        return false; //$table_name . '表主键不存在';
    }

    return $result[0]['Column_name'];
}

/**
 * 获取物理表已存在的主键字段名
 * @param string $table_name
 * @param string $table_schema
 * @return string results 查询结果
 */
function get_db_table_comment($table_name = '', $table_schema = '')
{
    // 接收参数
    $database = config('database.');
    $table_schema = empty($table_schema) ? $database['database'] : $table_schema;
    $table_name = $database['prefix'] . $table_name;

    // 查询结果
    $result = Db::query("
		SELECT TABLE_COMMENT as comment
		FROM INFORMATION_SCHEMA.TABLES
		WHERE table_name = ? AND table_schema = ?");

    if (empty($result)) {
        return false; //$table_name . '表主键不存在';
    }

    return $result[0]['comment'];
}

/**
 * 计算字符串数组中最大的字符串长度
 * @param $arr_char
 * @return int
 */
function arr_max_charlength($arr_char)
{
    $length = 0;

    foreach ($arr_char as $row) {
        if (Str::length($row) > $length) {
            $length = Str::length($row);
        }
    }

    return $length;
}

/**
 * 字符串后要添加制表符 填充到指定字符需要多少个制表符
 * @param     $char
 * @param     $length
 * @param int $tabSize
 * @return int
 */
function char_end_tab_size($char, $length, $tabSize = 4)
{
    $len = Str::length($char);
    $n = (int)($len / $tabSize);
    $l_n = (int)($length / $tabSize);

    return $l_n - $n;
}

/**
 * 判断字符串开头
 * @param $str
 * @param $pattern
 * @return bool
 */
function startwith($str, $pattern)
{
    if (strpos($str, $pattern) === 0)
        return true;
    else
        return false;
}

/**
 * 判断字符串结尾
 * @param $str
 * @param $pattern
 * @return bool
 */
function endwith($str, $pattern)
{
    if (strrpos($str, $pattern) === strlen($str) - 1)
        return true;
    else
        return false;
}

function getPrefix($str, $line = true)
{
    $arr = explode('_', $str);
    if (count($arr) >= 2) {
        return $line ? $arr[0] . '_' : $arr[0];
    }

    return '';
}

/**
 * 去掉前缀
 *
 * @param string $str
 * @param string $pattern
 * @return string
 */
function getPrefixValue($str, $pattern = '_')
{
    $arr = explode($pattern, $str);
    if (count($arr) >= 2) {
        $s = substr($str, strpos($str, $pattern) + 1);
        return ($s === false) ? '' : $s;
    } else if (count($arr) == 1) {
        return $str;
    }

    return '';
}

/**
 * 去掉结尾字符
 *
 * @param string $str
 * @param string $pattern
 * @return bool|string
 */
function removeEndWithValue($str, $pattern = '/')
{
    $isHave = endwith($str, $pattern);
    $s = $str;
    if ($isHave) {
        $s = substr($str, 0, strlen($str) - strlen($pattern));
        return ($s === false) ? '' : $s;
    }

    return $s;
}

/**
 * 去除前缀（不一定准确 搜索第一个下划线）
 * @param $str
 * @param $pattern
 * @return mixed
 */
function remove_prefix($str)
{
    $_f = $str;
    $_pre = substr($_f, 0, strpos($_f, "_") + 1);
    $_sf = str_replace($_pre, '', $_f);

    return $_sf;
}

/**
 * 去掉前缀（先搜索有没有这个前缀 如果有就去掉 比上一个准确点）
 * @param $str
 * @param $pattern
 * @return mixed
 */
function find_prefix_remove($str, $pattern)
{
    $found = startwith($str, $pattern);
    if ($found) {
        return $str;
    }
    $_sf = str_replace($pattern, '', $str);
    return $_sf;
}


/**
 * table是否组件化命名 例如：ra_uu_user_log 前缀+组件化标记+组件名+模块名  user是组件 log是模块
 *
 * @param string $str
 * @param string $table_module_name
 * @return bool
 */
function is_prefix_table_module($str, $table_module_name = 'uu')
{
    // 先去前缀ra
    $_no_prefix = getPrefixValue($str);

    // 判断组件化标记是否存在
    $_is_uu_flag = startwith($_no_prefix, $table_module_name);

    return $_is_uu_flag;
}

/**
 * 解析组件化表名 解出组件和模块
 *
 * @param string $str
 * @param string $table_module_name
 * @param string $default_module_name 默认组件名 指找不到组件标记，也就是非组件化，就默认一个组件index
 * @return array
 */
function getSplitTableModuleModel($str, $table_module_name = 'uu', $default_module_name = 'index')
{
    $result = [
        'module' => $default_module_name,
        'table_name' => '',
        'Model' => '',
        'is_component' => false,
    ];

    // 先去前缀ra
    $_no_prefix = getPrefixValue($str);

    $result['table_name'] = $_no_prefix; // 默认去掉前缀 剩下的就是模块
    $result['Model'] = Str::studly($_no_prefix);

    if (is_array($table_module_name)) {
        $_r = false;
        foreach ($table_module_name as $item) {
            if (is_prefix_table_module($str, $item)) {
                $_r = true;
                break;
            }
        }

        if (!$_r) {
            return $result;
        }
    } else {
        if (!is_prefix_table_module($str, $table_module_name)) {
            return $result;
        }
    }

    // 去掉组件化标记
    $_no_uu_flag = getPrefixValue($_no_prefix);
    // 解出组件名 类似user
    if (strrpos($_no_uu_flag, '_')) {
        $_module = Str::studly(getPrefix($_no_uu_flag, false));
    } else {
        $_module = Str::studly($_no_uu_flag);
    }

    $result['module'] = !empty($_module) ? $_module : $default_module_name;
    $result['Model'] = Str::studly(getPrefixValue($_no_uu_flag));
    $result['is_component'] = true;

    return $result;
}

function parseTableComment($table_comment)
{
    $result = [
        'comments' => [],
        'vars' => [],
    ];

    if (empty($table_comment)) {
        return $result;
    }

    $comment_arr = explode(PHP_EOL, $table_comment);

    foreach ($comment_arr as $item) {
        $_comment = trim($item);
        $_pos = strpos($_comment, '@');
        if ($_pos !== false) {
            $_tmp = substr(strstr($_comment, '@'), 1);
            $_var_name = trim(strstr($_tmp, ' ', true));
            $_var_value = trim(strstr($_tmp, ' '));
            if ($_var_name !== false && $_var_value !== false) {
                $result['vars'][$_var_name] = $_var_value;
            }
        } else {
            $result['comments'][] = $_comment;
        }
    }

    return $result;
}

function parseApiComment($comment, $tag = '@api_')
{
    $result = [
        'vars' => [],
    ];

    $comment = substr($comment, 3, -2);
    $comment = str_replace("\r\n", "\n", $comment); // PHP_EOL
    $comment = explode("\n", $comment);
    $comment_arr = array_map(function ($item) {
        return trim(trim($item), " \t*");
    }, $comment);

    foreach ($comment_arr as $item) {
        if (strpos($item, $tag) !== 0) {
            continue;
        }

        $_comment = substr(strstr(trim($item), $tag), strlen($tag));

        $_var_name = trim(strstr($_comment, ' ', true));
        $_var_value = trim(strstr($_comment, ' '));
        if ($_var_name !== false && $_var_value !== false) {
            $result['vars'][$_var_name] = $_var_value;
        }
    }

    return $result;
}

function getTableModuleModel($str, $param = [])
{
    $table_module_name = isset($param['table_module_name']) ? $param['table_module_name'] : 'uu';
    $default_module_name = isset($param['default_module_name']) ? $param['default_module_name'] : 'index';
    $sys_table_module_name = isset($param['sys_table_module_name']) ? $param['sys_table_module_name'] : 'sys';
    $sys_default_module_name = isset($param['sys_default_module_name']) ? $param['sys_default_module_name'] : 'common';
    $app_table_module_name = isset($param['app_table_module_name']) ? $param['app_table_module_name'] : 'app';
    $app_default_module_name = isset($param['app_default_module_name']) ? $param['app_default_module_name'] : 'common';

    $re = getSplitTableModuleModel($str, $table_module_name, $default_module_name);
    $re['is_sys'] = false;
    $re['is_app'] = false;
    if (!$re['is_component']) {
        $reSys = getSplitTableModuleModel($str, $sys_table_module_name, $sys_default_module_name);
        $reSys['is_app'] = false;
        if ($reSys['is_component']) {
            $reSys['is_sys'] = true;
            return $reSys;
        } else {
            $reApp = getSplitTableModuleModel($str, $app_table_module_name, $app_default_module_name);
            $reApp['is_sys'] = false;
            if ($reApp['is_component']) {
                $reApp['is_app'] = true;
                return $reApp;
            }
        }
    }

    return $re;
}

function api_url($module, $type, $controller, $action, $ver = 'v1')
{
    return $module . '/' . $type . '/' . $ver . '/' . $controller . '/' . $action;
}

function api_url_admin($module, $controller, $action, $ver = 'v1')
{
    return api_url($module, 'admin', $controller, $action, $ver);
}

// function my_dir($dir) {
// 	$files = array();
// 	if (@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
// 		while (($file = readdir($handle)) !== false) {
// 			if ($file != ".." && $file != ".") { //排除根目录；
// 				if (is_dir($dir . "/" . $file)) { //如果是子文件夹，就进行递归
// 					$files[$file] = my_dir($dir . "/" . $file);
// 				} else { //不然就将文件的名字存入数组；
// 					$files[] = $file;
// 				}
//
// 			}
// 		}
// 		closedir($handle);
//
// 		return $files;
// 	}
// }

function getDirRoot($app_type = 'com')
{
    $_dir = '';

    switch ($app_type) {
        case 'com':
            $_dir = COM_PATH;
            break;
        case 'api':
            $_dir = COM_PATH;
            break;
    }

    return $_dir;
}

/**
 * 读取组件中的配置
 *
 * @param string $com_name 组件名
 * @param string $config_name 配置文件名
 * @param string $app_type 应用类型（com-默认组件 mp-公众号 miniapp-小程序）
 * @return array|mixed
 */
function readConfig($com_name, $config_name, $app_type = 'com')
{
    $_dir = '';
    $f = [];

    switch ($app_type) {
        case 'com':
            $_dir = COM_PATH . $com_name . DS . 'config' . DS . $config_name;
            if (file_exists($_dir . '.php')) {
                $f = include_once $_dir . '.php';
            }
            break;
        case 'api':
            $_dir = COM_PATH . $com_name . DS . 'config' . DS . $config_name;
            if (file_exists($_dir . '.php')) {
                $f = include_once $_dir . '.php';
            }
            break;
    }

    return $f;
}

function readConfig_C($com_name, $config_name)
{
    return readConfig($com_name, $config_name, 'com');
}

function readConfig_MA($com_name, $config_name)
{
    return readConfig($com_name, $config_name, 'api');
}

function dateToTime_YM($year, $month)
{
    return mktime(0, 0, 0, $month, 1, $year);
}

function dateToTime_YMD($year, $month, $day)
{
    return mktime(0, 0, 0, $month, $day, $year);
}

/**
 * 获取今天00:00:00的时间戳
 * @param int $t
 * @return false|int
 */
function timeTodayBegin($t = 0)
{
    $_t = time();
    if (!empty($t)) {
        $_t = $t;
    }

    $date = getdate($_t);
    return mktime(0, 0, 0, $date['mon'], $date['mday'], $date['year']);
}

function diffDays($timeStart, $timeEnd)
{
    return floor(($timeEnd - $timeStart) / 86400);
}

function diffHours($timeStart, $timeEnd)
{
    return floor(($timeEnd - $timeStart) % 86400 / 3600);
}

function diffMinutes($timeStart, $timeEnd)
{
    return floor(($timeEnd - $timeStart) % 86400 / 60);
}

function diffSeconds($timeStart, $timeEnd)
{
    return floor(($timeEnd - $timeStart) % 86400 % 60);
}

define('SESSION_OR_GLOBALS', 2); // 1-session 2-globals

function sessionOrGLOBALS($key, $value = '')
{
    if ($value === '') {
        if (SESSION_OR_GLOBALS == 1) {
            return session($key);
        } else {
            !isset($GLOBALS['session']) && $GLOBALS['session'] = [];
            return isset($GLOBALS['session'][$key]) ? $GLOBALS['session'][$key] : '';
        }
    } elseif (is_null($value)) {
        if (SESSION_OR_GLOBALS == 1) {
            session($key, $value);
        } else {
            !isset($GLOBALS['session']) && $GLOBALS['session'] = [];
            if (isset($GLOBALS['session'][$key])) {
                unset($GLOBALS['session'][$key]);
            }
        }
    } else {
        if (SESSION_OR_GLOBALS == 1) {
            session($key, $value);
        } else {
            !isset($GLOBALS['session']) && $GLOBALS['session'] = [];
            $GLOBALS['session'][$key] = $value;
        }
    }

    return true;
}

/**
 *
 * @param $leng
 * @return bool|string
 */
function create_token($leng)
{
    //微信官方建议：避免使用srand（当前时间）然后rand()的方法，而是采用操作系统提供的真正随机数机制，比如Linux下面读取/dev/urandom设备
    $fp = @fopen('/dev/urandom', 'rb');
    $result = '';
    if ($fp !== FALSE) {
        $result .= @fread($fp, $leng);
        @fclose($fp);
    } else {
        /*
         * 如果你是LINUX用户是打开失败,一般是open_basedir 存在着限制
         * 在PHP.INI 文件找到 open_basedir加上/dev/urandom/如是多个请使用：号分开
         * windosw是没有/dev/urandom设备,可以偿试一下PHP 的 COM 组件，也考虑到有些环境默认是不开启 COM 组件,使用伪随机
         */
        $randStr = '';
        if (@class_exists('COM')) {
            try {
                $CAPI_Util = new COM('CAPICOM.Utilities.1');
                $randStr .= $CAPI_Util->GetRandom(16, 0);
                if ($randStr) {
                    $randStr = md5($randStr, TRUE);
                }
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        if (strlen($randStr) < 16) {
            //getRandChar 唯一性并不太高
            // return $this->getRandChar($leng);
            return rand_string($leng, '', 'oOLl01');
        } else {
            return $randStr;
        }

    }
    $result = base64_encode($result);
    $result = strtr($result, '+/', '-_');
    return substr($result, 0, $leng);
}

function sys_config_app($name = '', $value = null)
{
    return config('sys_config.' . APP_TAG . '.' . $name, $value);
}

function app_config($name = '', $value = null)
{
    $file = APP_TAG_PATH . 'app_config.php';

    $_config = new \think\Config(APP_TAG_PATH);
    $_config->load($file);
    // $name = 'app_config.' . $name;
    //$name = $name . '.';
    if (is_null($value) && is_string($name)) {
        if ('.' == substr($name, -1)) {
            return $_config->pull(substr($name, 0, -1));
        }

        return 0 === strpos($name, '?') ? $_config->has(substr($name, 1)) : $_config->get($name);
    } else {
        return $_config->set($name, $value);
    }
}

function error_config($name = '', $value = null)
{
    $file = APP_TAG_PATH . 'error_code.php';
    // $file = Env::get('app_path') . 'app/' . APP_TAG . '/error_config.php';

    $_config = new \think\Config(APP_TAG_PATH);
    $_config->load($file);

    if (is_null($value) && is_string($name)) {
        if ('.' == substr($name, -1)) {
            $c = $_config->pull(substr($name, 0, -1));
            if (!isset($c)) {
                return config($name);
            }

            return $c;
        }

        $c = 0 === strpos($name, '?') ? $_config->has(substr($name, 1)) : $_config->get($name);

        if (!isset($c)) {
            return config($name);
        }

        return $c;
    } else {
        return $_config->set($name, $value);
    }
}

function curr_http()
{
    return isset($_SERVER["REQUEST_SCHEME"]) ? $_SERVER["REQUEST_SCHEME"] : 'http';
}

function curr_domain()
{
    return $_SERVER["HTTP_HOST"];
}

function curr_url_domain()
{
    // return curr_http() . '://' . curr_domain();
    return Request::root(true);
}

/**
 * @param $path
 * @return bool
 */
function createDir($path)
{
    if (is_dir($path)) {
        return true;
    }
    if (is_dir(dirname($path))) {
        return mkdir($path);
    }
    createDir(dirname($path));
    return @mkdir($path);
}

/**
 * 获取当前域名
 * @return string
 */
function getHostDomain()
{
    return \think\facade\Request::domain();
}

function logfile($text)
{
    $fileHeader = '[ ' . APP_TAG . ' ][' . date('Y-m-d H:n:s') . '] ';

    file_put_contents(Env::get('root_path') . 'logs/log.txt', "{$fileHeader}{$text}" . "\r\n\r\n", FILE_APPEND);
}

;

function logerr($text)
{
    $fileHeader = '[ ' . APP_TAG . ' ][ ERR ][' . date('Y-m-d H:n:s') . '] ';

    file_put_contents(Env::get('root_path') . 'logs/log.txt', "{$fileHeader}{$text}" . "\r\n\r\n", FILE_APPEND);
}

;