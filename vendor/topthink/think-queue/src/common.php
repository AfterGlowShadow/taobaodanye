<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

\think\Console::addDefaultCommands([
    // 'queue:work' => "think\\queue\\command\\Work",
    // 'queue:restart' => "think\\queue\\command\\Restart",
    // 'queue:listen' => "think\\queue\\command\\Listen",
    // 'queue:subscribe' => "think\\queue\\command\\Subscribe",
	"think\\queue\\command\\Work",
    "think\\queue\\command\\Restart",
    "think\\queue\\command\\Listen",
    "think\\queue\\command\\Subscribe",
]);

if (!function_exists('queue')) {

    /**
     * 添加到队列
     * @param        $job
     * @param string $data
     * @param int    $delay
     * @param null   $queue
     */
    function queue($job, $data = '', $delay = 0, $queue = null)
    {
        if ($delay > 0) {
            \think\Queue::later($delay, $job, $data, $queue);
        } else {
            \think\Queue::push($job, $data, $queue);
        }
    }
}
