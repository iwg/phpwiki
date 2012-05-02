<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {

  fAuthorization::requireLoggedIn();
  $user_id = wiki_get_current_user_id();
  if (!wiki_is_root($user_id)) {
    wiki_no_permission();
  }

  try {
    $group = new group(fRequest::get('id'));
    if ($group->isSystemGroup()) {
      throw new fValidationException($lang['system group cannot be destroyed']);
    }
    $group->delete();
    fMessaging::create('success', 'groups', $lang['group destroyed successfully']);
  } catch (fException $e) {
    fMessaging::create('failure', 'groups', $e->getMessage());
  }
}

fURL::redirect(wiki_groups_path());
