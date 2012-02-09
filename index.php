<?php
include_once(__DIR__ . '/inc/init.php');

$slug = wiki_get_slug();

try {
  $page = new Page(array('path' => $slug));
} catch (fNotFoundException $e) {
  fMessaging::create('failure', 'new page', $lang['page not found']);
  fURL::redirect(wiki_new_page_path($slug));
}

$revisions = $page->buildRevisions();
if ($revisions->count()) {
  $revision = $revisions->getRecord(0);
  try {
    $theme = new Theme($revision->getThemeId());
    $title = $revision->getTitle();
    $theme_path = wiki_theme_path($theme->getName());
    include wiki_theme($theme->getName(), 'show-revision');
  } catch (fNotFoundException $e) {
    // TODO fatal error: no theme found (which indicates database inconsistency)
  }
} else {
  // TODO fatal error: no revision found (which indicates database inconsistency)
}
