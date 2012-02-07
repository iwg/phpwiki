<?php
include(__DIR__ . '/config.php');
include(__DIR__ . '/core.php');

$db = new fDatabase('mysql', DB_NAME, DB_USER, DB_PASS, DB_HOST);
