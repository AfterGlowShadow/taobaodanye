<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller;

use app\app\yss\Yss\common\model\CategoryDetail;
use app\app\yss\Yss\common\model\Collection;
use app\app\yss\Yss\common\model\Yss;
use think\Db;

/**
 * Class Collections
 * @api_name Collections
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\api\controller
 */
class Collections extends \app\app\yss\Yss\api\controller\logic\Collections
{

    public function init_before()
    {
        parent::init_before();


    }

    /**
     * 添加
     * 用户收藏表
     * @api_name 添加用户收藏
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Collections.add
     *
     * uid                用户
     * product_id        收藏的企业或服务id
     * type                1企业 2服务
     * @return mixed|string
     */
    public function add()
    {
        $this->param['uid'] = $this->uid;
        return parent::add();
    }

    /**
     * 获取列表
     * 用户收藏表
     * @api_name 获取用户收藏列表
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Collections.getList
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getList()
    {
        $this->_buf['getList'] = [
            'where' => [
                ['uid', '=', $this->uid]
            ]
        ];
        $r =  parent::getList();
        $arrList = $r->getData();
        if($arrList['code'] !== 200){
            return $r;
        }
        $YssModel = new Yss();
        $categoryModel = new CategoryDetail();
        foreach ($arrList['result']['data'] as $k=>&$v){
            if($v['type'] == 1){
                $children = $YssModel->getItemById($v['product_id'],'id,user_id,company_type_name,company_name,sell_price,registered_capital,pay_taxes,establishment,publish_time,industry_name,registered_capital,industry_second_name,order_sn');
                if (!is_return_ok($children)) {
                    return return_json($children);
                }
                $newUserData = get_return_data($children);
                $newUserData['company_name'] = hiddenName( $newUserData['company_name'] ,$newUserData['industry_second_name']);

                $v['children'] = $newUserData;
            }else{
                $_wh = [];
                $_wh[] = ['pid','=',$v['product_id']];
                $inArrs = $categoryModel->getList($_wh,'price asc',1,100,'title,price');
                if (!is_return_ok($inArrs)) {
                    return return_json($inArrs);
                }
                $childrenData = get_return_data($inArrs);
                $v['children'] = $childrenData['result']['data'];
            }
        }
        return rjson($arrList);
    }

}
