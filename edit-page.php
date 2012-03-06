<?php
include_once(__DIR__ . '/inc/init.php');

fAuthorization::requireLoggedIn();

$user_id = wiki_get_current_user_id();
$page_id = fRequest::get('id');

try {
  $page = new Page(fRequest::get('id'));
  $page_id = $page->getId();
  $revision = $page->getLatestRevision();
  $page_title = $revision->getTitle();
  $page_path = $page->getPath();
  $body = $revision->getBody();
  $page_theme = $revision->getTheme()->getName();
  $group_bits = $page->getGroupBits();
  $other_bits = $page->getOtherBits();
  $summary = '';
  $is_minor_edit = false;

  $page_owner = $page->getOwnerName();
  $page_group_id = $page->getGroupId();
  $user_name = wiki_get_current_user();
  $group_permission = wiki_get_write_permission($group_bits);
  $other_permission = wiki_get_write_permission($other_bits);
  if ($page_owner!=$user_name)
    if (!$group_permission || !wiki_is_in_group($db, $user_name, $page_group_id)) 
      if (!$other_permission) {
        wiki_no_permission();
      }
  
  $locked_by = wiki_check_lock($db, $page_id, $user_id);
  if (!$locked_by) {
    wiki_set_lock($db, $page_id, $user_id);
    $disabled = '';
  } else if ($locked_by == $user_id) {
    $disabled = '';
  } else {
    $disabled = 'disabled';
  }

  $title = $lang['Edit Page'];
  $theme_path = wiki_theme_path(DEFAULT_THEME);
  include wiki_theme(DEFAULT_THEME, 'edit-page');
} catch (fNotFoundException $e) {
  // TODO fatal error: page not found
}
