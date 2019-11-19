<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\common\model;


class ShareRecord extends \app\sys\com\User\common\model\table\ShareRecord {
	
	public static $_STATUS = [
		'none' => 0,
		'reg' => 1,
		'pay' => 2,
	];
	
	/**
	 * 更改分享状态 成功
	 * @param $data
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function editShareStatus($data) {
		$uid1 = $data['uid1'];
		$uid2 = $data['uid2'];
		$status = $data['status'];
		
		if ($uid1 == $uid2) {
			return rsErr('不能分享给自己', 10011);
		}
		
		$userModel = new User();
		
		// 查找分享人
		$reUser1 = $userModel->findUser_Uid($uid1);
		if (isErr($reUser1)) {
			return $reUser1;
		}
		
		$reUser1Data = get_return_data($reUser1);
		if (empty($reUser1Data)) {
			return return_status_err_c(11011);
		}
		
		// 查找被分享人
		$reUser2 = $userModel->findUser_Uid($uid2);
		if (isErr($reUser2)) {
			return $reUser2;
		}
		
		$reUser2Data = get_return_data($reUser2);
		if (empty($reUser2Data)) {
			return return_status_err_c(11011);
		}
		
		// 查询记录
		$re = $this
			->where('uid1', $uid1)
			->where('uid2', $uid2)
			->find();
		$reData = $this->cToArray($re);
		if ($reData === false) {
			return return_status_err_c(10009); // 数据失败
		} else if (empty($reData)) {
			return rsErr('找不到分享记录', 11010); // 找不到分享记录
		}
		
		$id = $reData['id'];
		
		// 写状态
		$_data = [];
		$_data['status'] = $status;
		
		$re = $this->editById($id, $_data);
		if ($re === false) {
			return $this->return_error();
		}
		
		return rsOk();
	}
	
	/**
	 * 添加分享
	 * @param $data
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function addShare($data) {
		$uid1 = $data['uid1'];
		$uid2 = $data['uid2'];
		
		if ($uid1 == $uid2) {
			return rsErr('不能分享给自己', 10011);
		}
		
		$userModel = new User();
		
		// 查找分享人
		$reUser1 = $userModel->findUser_Uid($uid1);
		if (isErr($reUser1)) {
			return $reUser1;
		}
		
		$reUser1Data = get_return_data($reUser1);
		if (empty($reUser1Data)) {
			return return_status_err_c(11011);
		}
		
		// 查找被分享人
		$reUser2 = $userModel->findUser_Uid($uid2);
		if (!is_return_ok($reUser2)) {
			return $reUser2;
		}
		
		$reUser2Data = get_return_data($reUser2);
		if (empty($reUser2Data)) {
			return return_status_err_c(11011);
		}
		
		// 验证是否分享过
		$re = $this
			->where('uid1', $uid1)
			->where('uid2', $uid2)
			->find();
		$reData = $this->cToArray($re);
		if ($reData === false) {
			return return_status_err_c(10009);
		} else if (!empty($reData)) {
			log_record(" --- addShare shared ---");
			return return_status_ok(); // 已分享过 不用再次分享同一人
		}
		
		$data['uid1'] = $uid1;
		$data['mobile1'] = isset($reUser1Data['mobile']) ? $reUser1Data['mobile'] : '';
		$data['nickname1'] = isset($reUser1Data['nickname']) ? $reUser1Data['nickname'] : '';
		$data['realname1'] = isset($reUser1Data['realname']) ? $reUser1Data['realname'] : '';
		
		$data['uid2'] = $uid2;
		$data['mobile2'] = isset($reUser2Data['mobile']) ? $reUser1Data['mobile'] : '';
		$data['nickname2'] = isset($reUser2Data['nickname']) ? $reUser1Data['nickname'] : '';
		$data['realname2'] = isset($reUser2Data['realname']) ? $reUser1Data['realname'] : '';
		
		$data['status'] = self::$_STATUS['reg'];
		
		$re = $this->add($data);
		if (isErr($re)) {
			return rsErrCode(10009);
		}
		
		return $re;
	}

}
