<?php
// +----------------------------------------------------------------------
// | Description: 通用
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\controller\admin;

use app\sys\com\base\common\v1\logic\Common;

class ResCommon extends ApiCommon
{
	/** @var $_model Common */
	protected $_model;

    public function initialize()
    {
        parent::initialize();


    }
	
	/**
	 * 获取数据列表
	 * getlist
	 *
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function get_list()
	{
		$m = $this->_model;
		$param = $this->param;
		$data = $m->getDataList();
		return return_json($data);
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
			return return_json_err(['error' => $m->getError()]);
		}
		return return_json_ok_data($data);
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
			return return_json_err($m->getError(), 10006);
		}
		return return_json_ok();
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
			return return_json_err($m->getError(), 10005);
		}
		return return_json_ok();
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
			return return_json_err($m->getError(), 10009);
		}
		return return_json_ok();
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
			return return_json_err($m->getError(), 10009);
		}
		return return_json_ok();
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
			return return_json_err($m->getError(), 10009);
		}
		return return_json_ok();
	}
}
