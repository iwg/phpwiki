<?php
error_reporting(E_ALL);

include(__DIR__ . '/load_flourish.php');
include(__DIR__ . '/load_phpwiki.php');
include(__DIR__ . '/load_plugins.php');

require(__DIR__ . '/config.php');
require(__DIR__ . '/core.php');
require(__DIR__ . '/lang.php');
require(__DIR__ . '/path.php');

$db = new fDatabase('mysql', DB_NAME, DB_USER, DB_PASS, DB_HOST);
fORMDatabase::attach($db);
