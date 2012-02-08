<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {
  try {
    $group = new group(fRequest::get('id'));
    if ($group->is_system_group()) {
      throw new fValidationException($lang['system group cannot be destroyed']);
    }
    $group->delete();
    fMessaging::create('success', 'groups', $lang['group destroyed successfully']);
  } catch (fException $e) {
    fMessaging::create('failure', 'groups', $e->getMessage());
  }
}

fURL::redirect(wiki_groups_path());
