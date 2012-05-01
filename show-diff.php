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

  $user_name = wiki_get_current_user();
  $permissionlv = $page->isPermitted($user_name, 'write');
  if ($permissionlv == 'other') {
    $gpdisabled = 'onclick="this.checked=!this.checked"';
    $opdisabled = 'onclick="this.checked=!this.checked"';
  } else if ($permissionlv == 'group') {
    $gpdisabled = 'onclick="this.checked=!this.checked"';
    $opdisabled = '';
  } else if ($permissionlv == 'owner') {
    $gpdisabled = '';
    $opdisabled = '';
  } else {
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
    $gpdisabled = 'disabled';
    $opdisabled = 'disabled';
  }

  $title = $lang['History Page'];
  $theme_path = wiki_theme_path(DEFAULT_THEME);
  include wiki_theme(DEFAULT_THEME, 'show-diff');
} catch (fNotFoundException $e) {
  // TODO fatal error: page not found
}
