<?php

if (defined('LOAD_EVENT_LIB')) {
	return true;
}

define('LOAD_EVENT_LIB', 1);

function init_event_lib($path) {
	$_f = $path . 'init.php';
	if (file_exists($_f)) {
		include_once $_f;
	}
}

init_event_lib(LIB_PATH);

return true;