<?php

namespace app\sys\com\Queue\common\job;

use app\sys\com\EventMgr\common\v1\facade\Event;
use think\facade\Env;
use think\queue\Job;

class JobTask {
	
	/**
	 * 队列执行
	 * @param Job   $job
	 * @param array $data 里面有任务id
	 * @throws \think\Exception
	 */
	public function taskExecute(Job $job, $data) {
		try {
			$isJobDone = $this->_doTaskExcute($data);
		} catch (\Exception $e) {
			print("Err: Calc {$data['taskMode']} e=" . $e->getMessage() . "\n");
			$isJobDone = false;
		}
		
		if ($isJobDone) {
			$job->delete();
			print("Info: Calc {$data['taskMode']} ok!" . "\n");
		} else {
			if ($job->attempts() > 3) {
				$job->delete();
			}
		}
	}
	
	/**
	 * 结算（分期零点扣款）具体任务执行
	 * @param $data
	 * @return bool
	 * @throws \think\exception\PDOException
	 */
	private function _doTaskExcute($data) {
		print("Info: do task {$data['taskMode']} Start." . date('Y-m-d H:i:s') . "\n");
		
		// 调用事件系统通知对应任务事件订阅者执行具体任务
		
		try {
			// 载入lib事件订阅
			include_once ROOT_PATH . 'sys/com/Queue/common/load_event_lib.php';
			
			// switch ($addon_type) {
			// 	case 'mp':
			// 		// 载入公众号事件订阅
			// 		include_once ROOT_PATH . 'sys/com/Queue/common/load_event_mp.php';
			// 		break;
			// 	case 'miniapp':
			// 		// 载入小程序事件订阅
			// 		include_once ROOT_PATH . 'sys/com/Queue/common/load_event_miniapp.php';
			// 		break;
			// }
			
			$re = Event::t('queue_task', $data);
			
			if (isErr($re)) {
				print("Err: doing task {$data['taskMode']} Error. " . json_encode_u($re) . "\n");
				return false;
			}
			
			print("Info: doing task {$data['taskMode']}. OK!!!" . "\n");
			return true;
		} catch (\Exception $e) {
			print("Err: doing task {$data['taskMode']} Error. " . $e->getMessage() . "\n");
			return false;
		}
	}
	
}