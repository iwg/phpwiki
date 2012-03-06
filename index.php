<?php
include_once(__DIR__ . '/inc/init.php');

$slug = wiki_get_slug();

try {
  $page = new Page(array('path' => $slug));
} catch (fNotFoundException $e) {
  fMessaging::create('failure', 'new page', $lang['page not found']);
  fURL::redirect(wiki_new_page_path($slug));
}

try {
  $page_id = $page->getId();
  $page_owner = $page->getOwnerName();
  $page_group_id = $page->getGroupId();
  $group_bits = $page->getGroupBits();
  $other_bits = $page->getOtherBits();
  $group_permission = wiki_get_read_permission($group_bits);
  $other_permission = wiki_get_read_permission($other_bits);
  if (!$other_permission) {
    fAuthorization::requireLoggedIn();
    $user_id = wiki_get_current_user_id();
    $user_name = wiki_get_current_user();
    if ($page_owner!=$user_name)
      if (!$group_permission || !wiki_is_in_group($db, $user_name, $page_group_id)) {
        wiki_no_permission();
      }
  }
} catch (fException $e) {
  // TODO fatal error
}

if ($page->isHyperlink()) {
  try {
    $hyperlink = new Hyperlink(array('page_id' => $page->getId()));
    fURL::redirect($hyperlink->getUrl());
  } catch (fNotFoundException $e) {
    // TODO fatal error
    exit;
  }
}

try {
  $revision = $page->getLatestRevision();
  $theme = $revision->getTheme();
  $title = $revision->getTitle();
  $theme_path = wiki_theme_path($theme->getName());
  include wiki_theme($theme->getName(), 'show-revision');
} catch (Exception $e) {
  // TODO fatal error
  exit;
}
