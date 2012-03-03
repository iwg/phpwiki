<?php
include_once(__DIR__ . '/inc/init.php');

fAuthorization::requireLoggedIn();

$user_id = wiki_get_current_user_id();
$page_id = fRequest::get('id');
$locked_by = wiki_check_lock($db, $page_id, $user_id);
if (!$locked_by) {
  wiki_set_lock($db, $page_id, $user_id);
  $disabled = '';
} else if ($locked_by == $user_id) {
  $disabled = '';
} else {
  $disabled = 'disabled';
}

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
  
  $title = $lang['Edit Page'];
  $theme_path = wiki_theme_path(DEFAULT_THEME);
  include wiki_theme(DEFAULT_THEME, 'edit-page');
} catch (fNotFoundException $e) {
  // TODO fatal error: page not found
}
