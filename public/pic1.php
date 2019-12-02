<?php /**
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
        header("content-type: image/png");
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
// 使用示例一：生成带有二维码的海报
//2. 在生成的二维码中加上logo(生成图片文件)
function scerweima1($url = '')
{
    require_once './phpqrcode/phpqrcode.php';
    $value = $url; //二维码内容
    $errorCorrectionLevel = 'H'; //容错级别
    $matrixPointSize = 6; //生成图片大小
//生成二维码图片
    $filename =  microtime() . '.png';
    QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    $logo = '1.jpg'; //准备好的logo图片
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
    }
//输出图片
    imagepng($QR, 'qrcode.png');
    imagedestroy($QR);
    imagedestroy($logo);
    return '<img src="qrcode.png" alt="使用微信扫描支付">';
}
//调用查看结果
//echo scerweima1('https://www.baidu.com');
// 使用示例二：生成带有图像，昵称和二维码的海报
$config = array(
    'text' => array(
        array(
            'text' => '121312',
            'left' => 182,
            'top' => 105,
            'fontPath' => './simhei.ttf', //字体文件
            'fontSize' => 30, //字号
            'fontColor' => '255,0,0', //字体颜色
            'angle' => 0,
        )
    ),
    'image' => array(
        array(
            'url' => './qrcode.png', //图片资源路径
            'left' => 130,
            'top' => -140,
            'stream' => 0, //图片资源是否是字符串图像流
            'right' => 0,
            'bottom' => 0,
            'width' => 150,
            'height' => 150,
            'opacity' => 100
        ),
//        array(
//            'url' => 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eofD96opK97RXwM179G9IJytIgqXod8jH9icFf6Cia6sJ0fxeILLMLf0dVviaF3SnibxtrFaVO3c8Ria2w/0',
//            'left' => 120,
//            'top' => 70,
//            'right' => 0,
//            'stream' => 0,
//            'bottom' => 0,
//            'width' => 55,
//            'height' => 55,
//            'opacity' => 100
//        ),
    ),
    'background' => '1.jpg',
);
$filename = 'qrcode/' . time() . '.jpg';
//$config['background'] ="1.jpg";
//$config['image']="";
//$config['text']="this is  a test";
//$filename = "tian.jpg";
//createPoster($config, $filename);
//echo createPoster($config,$filename);
echo createPoster($config);


?>