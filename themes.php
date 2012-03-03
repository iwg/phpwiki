<?php
include_once(__DIR__ . '/inc/init.php');

fAuthorization::requireLoggedIn();
$user_id = wiki_get_current_user_id();
if (!wiki_is_root($user_id)) {
  exit("You don't have the permissioin!");
}

$theme_names = wiki_list_theme_names();

$title = $lang['Themes'];
$theme_path = wiki_theme_path(DEFAULT_THEME);
include wiki_theme(DEFAULT_THEME, 'themes');
