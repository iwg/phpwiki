<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {

  fAuthorization::requireLoggedIn();
  $user_id = wiki_get_current_user_id();
  if (!wiki_is_root($user_id)) {
    wiki_no_permission();
  }

  try {
    $group = new Group(fRequest::get('group_id'));
    $membership = new Membership();
    $membership->setGroupId($group->getId());
    $membership->setUserName(fRequest::get('user_name'));
    $membership->setCreatedAt(now());
    $membership->store();
    fMessaging::create('success', 'groups', $lang['membership created successfully']);
  } catch (fException $e) {
    fMessaging::create('failure', 'groups', $e->getMessage());
  }
}

fURL::redirect(wiki_groups_path());
