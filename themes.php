<?php
include_once(__DIR__ . '/inc/init.php');

$theme_names = wiki_list_theme_names();

$title = $lang['Themes'];
$theme_path = wiki_theme_path('default');
include wiki_theme('default', 'themes');
