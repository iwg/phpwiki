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
  $other_bits = $page->getOtherBits();
  $other_permission = wiki_allow_read($other_bits);
  if (!$other_permission) {
    fAuthorization::requireLoggedIn();
    $user_name = wiki_get_current_user();
  } else {
    $user_name = '';
  }
  if (!$page->isPermitted($user_name, 'read')) {
    wiki_no_permission();
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
