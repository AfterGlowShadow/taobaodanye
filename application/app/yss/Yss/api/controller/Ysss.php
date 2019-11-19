<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller;

use app\app\yss\Yss\common\model\Yss;
use app\app\yss\Yss\common\service\SearchKeyword;
use think\Db;

/**
 * Class Ysss
 * @api_name Ysss
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\api\controller
 */
class Ysss extends \app\app\yss\Yss\api\controller\logic\Ysss
{

    public function init_before()
    {
        parent::init_before();


    }


    /**
     * 获取列表
     * 卖家出售企业表
     * @api_name 获取卖家出售企业列表
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Ysss.getList
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getList()
    {
        $_where = [];
        $_where[] = ['status', '=', 2];
        if (isset($this->param['startPrice']) && isset($this->param['endPrice']) && $this->param['endPrice'] > 0) $_where[] = ['price', 'in', [$this->param['startPrice'], $this->param['endPrice']]];
        if (isset($this->param['county']) && !empty($this->param['county'])) $_where[] = ['county', 'like', '%' . $this->param['county'] . '%'];

        $_order = [];
        if (isset($this->param['primary']) && !empty($this->param['primary'])) $_order['create_time'] = $this->param['primary']; else $_order['create_time'] = 'DESC';
        if (isset($this->param['publish']) && !empty($this->param['publish'])) $_order['publish_time'] = $this->param['publish'];
        if (isset($this->param['priceSort']) && !empty($this->param['priceSort'])) $_order['sell_price'] = $this->param['priceSort'];
        $field = "id,user_id,company_type_name,company_name,sell_price,registered_capital,pay_taxes,establishment,publish_time,industry_name,registered_capital,industry_second_name";
        $this->_buf['getList'] = [
            'where' => $_where,
            'order' => $_order,
            'field' => $field
        ];
        $list = parent::getList();
        $newUserData = $list->getData();
        if ($newUserData['code'] == 200) {
            foreach ($newUserData['result']['data'] as $k => &$v) {
                $v['company_name'] = hiddenName($v['company_name'], $v['industry_second_name'] );
            }
            return return_json($newUserData);
        } else {
            return $newUserData;
        }
    }


    /**
     * 获取列表
     * 卖家出售企业表
     * @api_name 获取卖家出售企业列表
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Ysss.getSelfList
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getSelfList()
    {
        $this->param['phone'] = $GLOBALS['uInfo']['mobile'];
        return parent::getList();
    }

    /**
     * 添加
     * 卖家出售企业表
     * @api_name 添加卖家出售企业
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Ysss.add
     *
     * user_id                    出售人id
     * user_name                出售人名称
     * product_name                商品名
     * company_type                企业类型
     * company_type_name        企业类型名称
     * company_name                企业名称
     * city                        市
     * county                    县
     * phone                    手机
     * credit_code                注册号/统一社会信用代码
     * pay_taxes                纳税类型
     * pay_taxes_type            纳税类型id
     * declare_tax                报税情况
     * declare_tax_type            报税情况id
     * recive_invoice            是否申领过发票 1否 2是
     * internetbank                有无网银 1有 2否
     * bank_account                银行账户
     * bank_account_type        银行账户 1已开基本户 2未开基本户
     * sell_price                出售金额 元
     * qq                        联系qq
     * status                    状态 1待审核 2审核通过 3买家出价购买 4 签署合同 5成功提现
     * industry_type            所属行业id
     * industry_name            所属行业名
     * establishment            成立日期
     * registered_capital        注册资本
     * contributed_capital        实缴资本
     * business_license            营业执照图片
     * legal_person                法人姓名
     * business_scope            经营范围
     * other_infomation            其他信息
     * @return mixed|string
     */
    public function add()
    {
        $this->param['status'] = 1;
        $this->param['user_id'] = $this->uid;
        $this->param['order_sn'] = createOrderSn();
        return parent::add();
    }


    /**
     * 更改
     * 卖家出售企业表
     * @api_name 更改卖家出售企业
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Ysss.edit
     *
     * id
     * user_id                    出售人id
     * user_name                出售人名称
     * product_name                商品名
     * company_type                企业类型
     * company_type_name        企业类型名称
     * company_name                企业名称
     * city                        市
     * county                    县
     * phone                    手机
     * credit_code                注册号/统一社会信用代码
     * pay_taxes                纳税类型
     * pay_taxes_type            纳税类型id
     * declare_tax                报税情况
     * declare_tax_type            报税情况id
     * recive_invoice            是否申领过发票 1否 2是
     * internetbank                有无网银 1有 2否
     * bank_account                银行账户
     * bank_account_type        银行账户 1已开基本户 2未开基本户
     * sell_price                出售金额 元
     * qq                        联系qq
     * status                    状态 1待审核 2审核通过 3买家出价购买 4 签署合同 5成功提现
     * industry_type            所属行业id
     * industry_name            所属行业名
     * establishment            成立日期
     * registered_capital        注册资本
     * contributed_capital        实缴资本
     * business_license            营业执照图片
     * legal_person                法人姓名
     * business_scope            经营范围
     * other_infomation            其他信息
     * @return mixed|string
     */
    public function edit()
    {

        $this->param['status'] = 1;
        $this->param['user_id'] = $this->uid;
        return parent::edit();
    }

    /**
     * 获取详情 通过id查询
     * 卖家出售企业表
     * @api_name 获取卖家出售企业详情
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Ysss.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById()
    {
        $list = parent::getItemById();
        $newUserData = $list->getData();
        if ($newUserData['code'] == 200) {
            $newUserData['result']['company_name'] = hiddenName( $newUserData['result']['company_name'] ,$newUserData['result']['industry_second_name']);
            $newUserData['result']['credit_code'] = substr($newUserData['result']['credit_code'],0,3).'***************';
            unset($newUserData['result']['business_scope']);
            return return_json($newUserData);
        } else {
            return $newUserData;
        }
    }

    /**
     * 获取搜索列表
     * 卖家出售企业表
     * @api_name 获取搜索列表
     * @api_type 3
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/api/Yss.v1.Ysss.getSearchList
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getSearchList()
    {
        $searchKeywordService = new SearchKeyword();
        return $searchKeywordService->getList($this->param);
    }
}
