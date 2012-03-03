<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {

  fAuthorization::requireLoggedIn();
  $user_id = wiki_get_current_user_id();
  if (!wiki_is_root($user_id)) {
    exit();
  }

  try {
    $theme = new Theme(array('name' => fRequest::get('name')));
    $theme->delete();
    fMessaging::create('success', 'themes', $lang['theme disabled successfully']);
  } catch (fException $e) {
    fMessaging::create('failure', 'themes', $e->getMessage());
  }
}

fURL::redirect(wiki_themes_path());
