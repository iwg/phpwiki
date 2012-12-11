<?php
include_once(__DIR__ . '/inc/init.php');

$user_id = wiki_get_current_user_id();
if (!wiki_is_root($user_id)) {
  wiki_no_permission();
}

$title = $lang['Contributors'];
$theme_path = wiki_theme_path(DEFAULT_THEME);
include wiki_theme(DEFAULT_THEME, 'contributors');
