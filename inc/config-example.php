<?php
function __autoload($class_name)
{
  $libraries = array('phpwiki', 'flourish');
  
  foreach ($libraries as $library) {
    $lib_root = __DIR__ . "/$library/";
    $file = $lib_root . $class_name . '.php';
    if (file_exists($file)) {
      include $file;
      return;
    }
  }
  
	throw new Exception('The class ' . $class_name . ' could not be loaded');
}

define('DB_NAME', 'phpwiki');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');
