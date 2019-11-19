<?php

/**
 * 文件路径： \application\index\job\MultiTask.php
 * 这是一个消费者类，用于处理 multiTaskJobQueue 队列中的任务
 */
namespace app\sys\com\builder\admin\v1\job;


use FileSdk\FileUtils;
use think\queue\Job;

class MultiTask {
	
	public function taskA(Job $job, $data) {
		
		$isJobDone = $this->_doTaskA($data);
		
		if ($isJobDone) {
			$job->delete();
			print("Info: TaskA of Job MultiTask has been done and deleted" . "\n");
		} else {
			if ($job->attempts() > 3) {
				$job->delete();
			}
		}
	}
	
	public function taskB(Job $job, $data) {
		
		$isJobDone = $this->_doTaskB($data);
		
		if ($isJobDone) {
			$job->delete();
			print("Info: TaskB of Job MultiTask has been done and deleted" . "\n");
		} else {
			if ($job->attempts() > 2) {
				$job->release();
			}
		}
	}
	
	private function _doTaskA($data) {
		print("Info: doing TaskA of Job MultiTask " . "\n");
		$fileUtils = new FileUtils();
		var_dump($fileUtils->get_dir_info(COM_PATH));
		var_dump($fileUtils->list_dir_info(COM_PATH, true));
		var_dump($fileUtils->dir_info(COM_PATH));
		return true;
	}
	
	private function _doTaskB($data) {
		print("Info: doing TaskB of Job MultiTask " . "\n");
		return true;
	}
}