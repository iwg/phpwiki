<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {
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
