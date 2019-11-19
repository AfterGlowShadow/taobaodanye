<?php


namespace app\sys\com\Code\common\service;

use anerg\Alidayu\SmsGateWay;
use Toplan\PhpSms\Sms;

class SmsAliyun
{

    /**
     * 发送验证码
     * @param $mobile
     * @param $code
     * @return array
     * @throws \Toplan\PhpSms\PhpSmsException
     */
    public function send_code($mobile, $code, $param)
    {
        // $_config = app_config('sms_code.ali_sms');

        Sms::config([
            'Aliyun' => [
                //淘宝开放平台中，对应阿里大鱼短信应用的App Key
                'accessKeyId' => $param['accessKeyId'],
                //淘宝开放平台中，对应阿里大鱼短信应用的App Secret
                'accessKeySecret' => $param['accessKeySecret'],
                //短信签名，传入的短信签名必须是在阿里大鱼“管理中心-短信签名管理”中的可用签名
                'signName' => $param['signName'],
            ],
        ]);

        $tempData = [
            'code' => $code
//            'minutes' => '5',
        ];

        try {
            Sms::scheme([
                'Aliyun' => '100',
            ]);

            $re = Sms::make()
                ->to($mobile)
                ->template($param['templates'])
                ->data($tempData)
                ->send();
            return rsData($re);
        } catch (\Exception $e) {
            return rsErr($e->getMessage());
        }
    }

}