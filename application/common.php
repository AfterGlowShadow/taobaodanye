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

// 应用公共文件
use think\facade\Log;
use think\Db;
use think\helper\Str;

include_once "sys/com/base/common.php";

/**
 * @param $name 公司名
 * @param $businessType 类别
 * @return string
 */
function hiddenName($name, $businessType)
{
    $province = ['北京', '天津', '河北', '石家庄', '唐山', '秦皇岛', '邯郸', '邢台', '保定', '张家口', '承德', '沧州', '廊坊', '衡水'];
    $type = ['有限公司', '有限责任公司'];
    $licenseName = '有限公司';
    $city = '';
    if (strstr($name, $type[1]) !== false) {
        $licenseName = '有限责任公司';
    }
    foreach ($province as $v) {
        if (strstr($name, $v) !== false) {
            $city = $v;
        }
    }
    return $city . '**' . $businessType . $licenseName;
}
/**
 * 生成随机数
 * @param $num 位数
 * @return int
 */
function createCode($num = 4)
{
    $res = [];
    for ($i = 0; $i < $num; $i++) {
        $res[] = rand(0, 9);
    }
    return implode('', $res);
}