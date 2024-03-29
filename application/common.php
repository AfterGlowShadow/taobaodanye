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
//生成二维码
function scerweima($url = '',$logo="")
{
    require_once './phpqrcode/phpqrcode.php';
    $value = $url; //二维码内容
    $errorCorrectionLevel = 'H'; //容错级别
    $matrixPointSize = 6; //生成图片大小
//生成二维码图片
    $filename =  "../public/Upload/Qrcode/".microtime() . '.png';
    QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
//    $logo = '1.jpg'; //准备好的logo图片
    $QR = $filename; //已经生成的原始二维码图
    if (file_exists($logo)) {
        $QR = imagecreatefromstring(file_get_contents($QR)); //目标图象连接资源。
        $logo = imagecreatefromstring(file_get_contents($logo)); //源图象连接资源。
        $QR_width = imagesx($QR); //二维码图片宽度
        $QR_height = imagesy($QR); //二维码图片高度
        $logo_width = imagesx($logo); //logo图片宽度
        $logo_height = imagesy($logo); //logo图片高度
        $logo_qr_width = $QR_width / 4; //组合之后logo的宽度(占二维码的1/5)
        $scale = $logo_width / $logo_qr_width; //logo的宽度缩放比(本身宽度/组合后的宽度)
        $logo_qr_height = $logo_height / $scale; //组合之后logo的高度
        $from_width = ($QR_width - $logo_qr_width) / 2; //组合之后logo左上角所在坐标点
//重新组合图片并调整大小
        /*
        imagecopyresampled() 将一幅图像(源图象)中的一块正方形区域拷贝到另一个图像中
        */
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        imagepng($QR, '../public/qrcode.png');
        imagedestroy($QR);
        imagedestroy($logo);
    }
//输出图片
    return $filename;
}
/**
 *
 * 生成宣传海报
 *
 * @param array 参数,包括图片和文字
 *
 * @param string $filename 生成海报文件名,不传此参数则不生成文件,直接输出图片
 *
 * @return [type] [description]
 */
function createPoster($config = array(), $filename = "")
{

    if (empty($filename)){
//        header("content-type: image/png");
    }
//如果要看报什么错，可以先注释调这个header
    $imageDefault = array(
        'left' => 0,
        'top' => 0,
        'right' => 0,
        'bottom' => 0,
        'width' => 100,
        'height' => 100,
        'opacity' => 100
    );
    $textDefault = array(
        'text' => '',
        'left' => 0,
        'top' => 0,
        'fontSize' => 100, //字号
        'fontColor' => '255,255,255', //字体颜色
        'angle' => 0,
    );
    $background = $config['background'];//海报最底层得背景
//背景方法
    $backgroundInfo = getimagesize($background);
    $backgroundFun = 'imagecreatefrom' . image_type_to_extension($backgroundInfo[2], false);
    $background = $backgroundFun($background);
    $backgroundWidth = imagesx($background); //背景宽度
    $backgroundHeight = imagesy($background); //背景高度
//    $imageRes = imageCreatetruecolor($backgroundWidth, $backgroundHeight);
    $imageRes = imageCreatetruecolor($backgroundWidth, $backgroundHeight);
    $color = imagecolorallocate($imageRes, 0, 0, 0);
    imagefill($imageRes, 0, 0, $color);
// imageColorTransparent($imageRes, $color); //颜色透明
    imagecopyresampled($imageRes, $background, 0, 0, 0, 0, imagesx($background), imagesy($background), imagesx($background), imagesy($background));
//处理了图片
    if (!empty($config['image'])) {
        foreach ($config['image'] as $key => $val) {
            $val = array_merge($imageDefault, $val);
            $info = getimagesize($val['url']);
            $function = 'imagecreatefrom' . image_type_to_extension($info[2], false);
            if ($val['stream']) { //如果传的是字符串图像流
                $info = getimagesizefromstring($val['url']);
                $function = 'imagecreatefromstring';
            }
            $res = $function($val['url']);
            $resWidth = $info[0];
            $resHeight = $info[1];
//建立画板 ，缩放图片至指定尺寸
            $canvas = imagecreatetruecolor($val['width'], $val['height']);
            imagefill($canvas, 0, 0, $color);
//关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
            imagecopyresampled($canvas, $res, 0, 0, 0, 0, $val['width'], $val['height'], $resWidth, $resHeight);
            $val['left'] = $val['left'] < 0 ? $backgroundWidth - abs($val['left']) - $val['width'] : $val['left'];
            $val['top'] = $val['top'] < 0 ? $backgroundHeight - abs($val['top']) - $val['height'] : $val['top'];
//放置图像
            imagecopymerge($imageRes, $canvas, $val['left'], $val['top'], $val['right'], $val['bottom'], $val['width'], $val['height'], $val['opacity']);//左，上，右，下，宽度，高度，透明度
        }
    }
//处理文字
    if (!empty($config['text'])) {
        foreach ($config['text'] as $key => $val) {
            $val = array_merge($textDefault, $val);
            list($R, $G, $B) = explode(',', $val['fontColor']);
            $fontColor = imagecolorallocate($imageRes, $R, $G, $B);
            $val['left'] = $val['left'] < 0 ? $backgroundWidth - abs($val['left']) : $val['left'];
            $val['top'] = $val['top'] < 0 ? $backgroundHeight - abs($val['top']) : $val['top'];
//            print_r($val);
//            exit;
            imagettftext($imageRes, $val['fontSize'], $val['angle'], $val['left'], $val['top'], $fontColor, realpath($val['fontPath']), $val['text']);
        }
    }
//生成图片
    if (!empty($filename)) {
        $res = imagejpeg($imageRes, $filename, 90); //保存到本地
        imagedestroy($imageRes);
        if (!$res) return false;
        return $filename;
    } else {
        imagejpeg($imageRes); //在浏览器上显示
        imagedestroy($imageRes);
    }
}
