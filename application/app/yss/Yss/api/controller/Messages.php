<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller;

use app\app\yss\Yss\common\model\Message;
use app\sys\com\Vars\common\model\Vars;
use think\Db;

/**
 * Class Messages
 * @api_name Messages
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\api\controller
 */
class Messages extends \app\app\yss\Yss\api\controller\logic\Messages {

    public function init_before() {
        parent::init_before();


    }
    /**
     * 获取列表
     * 交易动态表
     * @api_name 获取交易动态列表
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Messages.getList
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getList() {
        $res = parent::getList();
        $resData = $res->getData();
        if($resData['code'] == 200){
            $var = 'TradingIndex';
            $varsModel = new Vars();
            $re = $varsModel->getItemByVar($var);
            $resData['result']['TradingIndex'] = $re['result'];
            return return_json($resData);
        }else {
            return $resData;
        }
    }


}
