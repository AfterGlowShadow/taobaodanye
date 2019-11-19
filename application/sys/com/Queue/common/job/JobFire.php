<?php


namespace app\sys\com\Queue\common\job;

use think\Exception;
use think\Queue;

class JobFire {
	public function createQueue($data){
		//$_task_mode = $data['taskMode']; // 执行哪个任务
		//$_addon_param = $data['addonParam']; // 应用参数
		
		$jobHandlerClassName  = 'app\sys\com\Queue\common\job\JobTask@taskExecute';
		$jobDataArr = $data;
		$jobQueueName = "taskExecute";
		
		try {
			$taskId = Queue::push($jobHandlerClassName, $jobDataArr, $jobQueueName);
			if ($taskId === false) {
				return rsErr();
			}
			
			return rsOk();
		} catch (\Exception $e) {
			log_record('JobFire Err ', $e->getMessage());
			return rsErr($e->getMessage());
		}
	}
}