<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {
  try {
    $theme = new Theme();
    $theme->setName(fRequest::get('name'));
    $theme->setCreatedAt(now());
    $theme->store();
    fMessaging::create('success', 'themes', $lang['theme enabled successfully']);
  } catch (fException $e) {
    fMessaging::create('failure', 'themes', $e->getMessage());
  }
}

fURL::redirect(wiki_themes_path());
