<?php
function __autoload($class_name)
{
	$flourish_root = __DIR__ . '/flourish/';
	
	$file = $flourish_root . $class_name . '.php';
	
	if (file_exists($file)) {
		include $file;
		return;
	}
	
	throw new Exception('The class ' . $class_name . ' could not be loaded');
}

define('DB_NAME', 'phpwiki');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');
