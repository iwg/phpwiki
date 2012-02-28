<?php
include_once(__DIR__ . '/inc/init.php');

$groups = fRecordSet::build('Group');

$title = $lang['Groups'];
$theme_path = wiki_theme_path(DEFAULT_THEME);
include wiki_theme(DEFAULT_THEME, 'groups');
