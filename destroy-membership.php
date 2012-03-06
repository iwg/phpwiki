<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {

  fAuthorization::requireLoggedIn();
  $user_id = wiki_get_current_user_id();
  if (!wiki_is_root($user_id)) {
    wiki_no_permission();
  }

  try {
    $membership = new Membership(fRequest::get('id'));
    $membership->delete();
    fMessaging::create('success', 'groups', $lang['membership destroyed successfully']);
  } catch (fException $e) {
    fMessaging::create('failure', 'groups', $e->getMessage());
  }
}

fURL::redirect(wiki_groups_path());
