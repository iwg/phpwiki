<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {

  fAuthorization::requireLoggedIn();
  $user_id = wiki_get_current_user_id();
  if (!wiki_is_root($user_id)) {
    exit();
  }

  try {
    $group = new Group();
    $group->setName(fRequest::get('name'));
    $group->setCreatedAt(now());
    $group->store();
    fMessaging::create('success', 'groups', $lang['group created successfully']);
  } catch (fException $e) {
    fMessaging::create('failure', 'groups', $e->getMessage());
  }
}

fURL::redirect(wiki_groups_path());
