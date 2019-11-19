<?php

if (defined('LOAD_EVENT_MINIAPP')) {
	return true;
}

define('LOAD_EVENT_MINIAPP', 1);

function init_event_miniapp($path) {
	$_f = $path . 'init.php';
	if (file_exists($_f)) {
		include_once $_f;
	}
}

init_event_miniapp(MINIAPP_PATH);

return true;