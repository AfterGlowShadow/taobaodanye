<?php
// +----------------------------------------------------------------------
// | Description: 通用
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\controller\admin;

use app\sys\com\base\common\v1\logic\Common;
use think\Validate;

class DbBaseCommon extends ApiCommon
{
	/** @var $_model Common */
	protected $_model;
	/** @var $_validate Validate */
	protected $_validate;

    public function initialize()
    {
        parent::initialize();


    }

	/**
	 * 获取数据列表
	 * getlist
	 * @return \think\response\Json
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function get_list()
	{
		$m = $this->_model;
		$param = $this->param;

		$page_num = isset($param['page_num']) ? $param['page_num'] : 1;
		$page_limit = isset($param['page_limit']) ? $param['page_limit'] : PHP_INT_MAX;

		$re = $m->getDataList([], [], $page_num, $page_limit);
		$reData = get_return_data($re);
		return resultArray(['data' => $reData]);
	}

	/**
	 * 获取单项
	 * id
	 * @return \think\response\Json
	 * @throws \think\Exception\DbException
	 */
	public function read()
	{
		$m = $this->_model;
		$param = $this->param;
		$data = $m->getDataById($param['id']);
		if (!$data) {
			return resultArray(['error' => $m->getError()]);
		}
		return resultArray(['data' => $data]);
	}

	/**
	 * 添加add
	 * ...
	 * @return \think\response\Json
	 */
	public function save()
	{
		$m = $this->_model;
		$param = $this->param;
		$data = $m->createData($param);
		if (!$data) {
			return resultArray(['error' => $m->getError()]);
		}
		return resultArray(['data' => '添加成功']);
	}

	/**
	 * 更新编辑
	 * id
	 * @return \think\response\Json
	 * @throws \think\Exception\DbException
	 */
	public function update()
	{
		$m = $this->_model;
		$param = $this->param;
		$data = $m->updateDataById($param, $param['id']);
		if (!$data) {
			return resultArray(['error' => $m->getError()]);
		}
		return resultArray(['data' => '编辑成功']);
	}

	/**
	 * 删除
	 * id
	 * @return \think\response\Json
	 * @throws \think\exception\PDOException
	 */
	public function delete()
	{
		$m = $this->_model;
		$param = $this->param;
		$data = $m->delDataById($param['id'], false);
		if (!$data) {
			return resultArray(['error' => $m->getError()]);
		}
		return resultArray(['data' => '删除成功']);
	}

	/**
	 * 删除多项
	 * ids
	 * @return \think\response\Json
	 */
	public function deletes()
	{
		$m = $this->_model;
		$param = $this->param;
		$data = $m->delDatas($param['ids'], false);
		if (!$data) {
			return resultArray(['error' => $m->getError()]);
		}
		return resultArray(['data' => '删除成功']);
	}

	/**
	 * 启用
	 * ids
	 * status
	 * @return \think\response\Json
	 */
	public function enables()
	{
		$m = $this->_model;
		$param = $this->param;
		$data = $m->enableDatas($param['ids'], $param['status'], false);
		if (!$data) {
			return resultArray(['error' => $m->getError()]);
		}
		return resultArray(['data' => '操作成功']);
	}


}
