<?php
include(__DIR__ . '/config.php');
include(__DIR__ . '/core.php');
include(__DIR__ . '/lang.php');
include(__DIR__ . '/path.php');

$db = new fDatabase('mysql', DB_NAME, DB_USER, DB_PASS, DB_HOST);
fORMDatabase::attach($db);
