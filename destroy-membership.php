<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {
  try {
    $membership = new Membership(fRequest::get('id'));
    $membership->delete();
  } catch (fException $e) {
    fMessaging::create('failure', 'groups', $e->getMessage());
  }
}

fURL::redirect(wiki_groups_path());
