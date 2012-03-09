<?php
define('DB_NAME', 'phpwiki');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');

define('HOST_URL', 'http://localhost');
define('SITE_BASE', '/wiki');
define('THEME_BASE', '/wiki/themes');
define('DEFAULT_THEME', 'default');
define('TITLE_SUFFIX', ' | phpwiki');
define('LOCK_TIME', 100);

date_default_timezone_set("Asia/Shanghai");

//root_ids ---- which have the permission to change groups & themes
$ROOT_IDS[1] = 1;

