<?php
include_once(__DIR__ . '/inc/init.php');

fAuthorization::requireLoggedIn();
$user_id = wiki_get_current_user_id();
if (!wiki_is_root($user_id)) {
  exit("You don't have the permission!");
}

$groups = fRecordSet::build('Group');

$title = $lang['Groups'];
$theme_path = wiki_theme_path(DEFAULT_THEME);
include wiki_theme(DEFAULT_THEME, 'groups');
