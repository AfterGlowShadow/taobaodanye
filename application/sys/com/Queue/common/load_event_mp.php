<?php

if (defined('LOAD_EVENT_MP')) {
	return true;
}

define('LOAD_EVENT_MP', 1);

function init_event_mp($path) {
	$_f = $path . 'init.php';
	if (file_exists($_f)) {
		include_once $_f;
	}
}

init_event_mp(ADDON_PATH);

return true;