<?php
include_once(__DIR__ . '/inc/init.php');

$slug = wiki_slugify(fRequest::get('slug'));

try {
  $page = new Page(array('path' => $slug));
  fURL::redirect(SITE_BASE . $slug);
} catch (fNotFoundException $e) {
  $title = $lang['New Page'];
  $theme_path = wiki_theme_path(DEFAULT_THEME);
  include wiki_theme(DEFAULT_THEME, 'new-page');
}
