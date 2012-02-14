<?php
include_once(__DIR__ . '/inc/init.php');

try {
  $preview = new Preview(fRequest::get('id'));
  $slug = $preview->getPath();
  $page = $preview->buildPage();
  $revision = $preview->buildRevision();
  $theme = $revision->getTheme();
  $title = $revision->getTitle();
  $theme_path = wiki_theme_path($theme->getName());
  include wiki_theme($theme->getName(), "show-revision");
} catch (Exception $e) {
  // TODO fatal error
}
