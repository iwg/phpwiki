<?php
include_once(__DIR__ . '/inc/init.php');

$slug = wiki_get_slug();

try {
  $page = new Page(array('path' => $slug));
} catch (fNotFoundException $e) {
  fMessaging::create('failure', 'new page', $lang['page not found']);
  fURL::redirect(wiki_new_page_path($slug));
}

// TODO show page
