<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller;

use app\app\yss\Yss\common\model\Sell;
use think\Db;

/**
 * Class Sells
 * @api_name Sells
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\api\controller
 */
class Sells extends \app\app\yss\Yss\api\controller\logic\Sells {

    public function init_before() {
        parent::init_before();


    }

    /**
     * 添加
     * 买家求购企业表
     * @api_name 添加买家求购企业
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Sells.add
     *
     * order_sn						编号
     * title						求购标题
     * city							市
     * country						县
     * industry_type				求购行业id一级
     * industry_name				求购行业名一级
     * industry_second_type			求购行业id二级
     * industry_second_name			求购行业名二级
     * investor_type				投资主体
     * investor_name				投资主体字
     * tax_types					纳税类型
     * tax_types_name				纳税类型名
     * intangible_assets			无形资产
     * intangible_assets_name		无形资产名
     * wechat_pay					微信支付 1否 2是
     * registered_capital			注册资金
     * registered_capital_name		注册资金名
     * years						成立年限
     * psychological_price			心理价位
     * demand						求购需求
     * status						1提交待查看 2已查看
     * @return mixed|string
     */
    public function add() {
        $this->param['status'] = 1;
        $this->param['uid'] = $this->uid;
        $this->param['order_sn'] = createOrderSn();
        return parent::add();
    }

    /**
     * 更改
     * 买家求购企业表
     * @api_name 更改买家求购企业
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Sells.edit
     *
     * id
     * order_sn						编号
     * title						求购标题
     * city							市
     * country						县
     * industry_type				求购行业id一级
     * industry_name				求购行业名一级
     * industry_second_type			求购行业id二级
     * industry_second_name			求购行业名二级
     * investor_type				投资主体
     * investor_name				投资主体字
     * tax_types					纳税类型
     * tax_types_name				纳税类型名
     * intangible_assets			无形资产
     * intangible_assets_name		无形资产名
     * wechat_pay					微信支付 1否 2是
     * registered_capital			注册资金
     * registered_capital_name		注册资金名
     * years						成立年限
     * psychological_price			心理价位
     * demand						求购需求
     * status						1提交待查看 2已查看
     * @return mixed|string
     */
    public function edit() {
        $this->param['status'] = 1;
        return parent::edit();
    }
}
