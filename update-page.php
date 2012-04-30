<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {
  try {

    $user_id = wiki_get_current_user_id();
    $page_id = fRequest::get('id');
    $locked_by = wiki_check_lock($db, $page_id, $user_id);
    if (($locked_by) && ($locked_by != $user_id)) {
      fURL::redirect(wiki_edit_page_path($page_id));
    }

    $page = new Page(fRequest::get('id'));
    $user_name = wiki_get_current_user();
    $permissionlv = $page->isPermitted($user_name, 'write');
    if (!$permissionlv) {
      wiki_no_permission();
    }

    $page_id = $page->getId();
    $page_title = trim(fRequest::get('title'));
    $page_path = $page->getPath();
    $body = fRequest::get('body');
    $page_theme = fRequest::get('theme');
    $group_bits = array_sum(fRequest::get('group_bits', 'integer[]'));
    $other_bits = array_sum(fRequest::get('other_bits', 'integer[]'));
    $summary = trim(fRequest::get('summary'));
    $is_minor_edit = fRequest::get('is_minor_edit', 'boolean');
    
    if ($permissionlv == 'other') {
      $group_bits = $page->getGroupBits();
      $other_bits = $page->getOtherBits();
    } else if ($permissionlv == 'group') {
      $group_bits = $page->getGroupBits();
    }

    if (empty($page_title)) {
      throw new fValidationException('Title cannot be blank.');
    }
    if ($group_bits < 0 or $group_bits > 7) {
      throw new fValidationException('Invalid group permission bits.');
    }
    if ($other_bits < 0 or $other_bits > 7) {
      throw new fValidationException('Invalid other permission bits.');
    }
    $theme = new Theme(array('name' => $page_theme));
    
    $submit = fRequest::get('submit');
    if ($submit == 'Save page') {
      try {
        $db->query('BEGIN');
        
        $revision = new Revision();
        $revision->setPageId($page->getId());
        $revision->setTitle($page_title);
        $revision->setBody($body);
        $revision->setThemeId($theme->getId());
        $revision->setIsMinorEdit($is_minor_edit);
        $revision->setEditorName(wiki_get_current_user());
        $revision->setCommitMessage($summary);
        $revision->setCreatedAt(now());
        $revision->store();
        $page->setPermission($group_bits . $other_bits);
        $page->store();
        
        $db->query('COMMIT');
        
        wiki_unlock($db, $page->getId());

        fURL::redirect(SITE_BASE . $page->getPath());
      } catch (fException $e) {
        $db->query('ROLLBACK');
        throw $e;
      }
    } else if ($submit == 'Show preview') {
      try {
        
        wiki_unlock($db, $page_id);
        wiki_set_lock($db, $page_id, $user_id);
        
        $db->query('BEGIN');
        
        wiki_clear_previous_previews($db, $page_path, wiki_get_current_user());
        
        $preview = new Preview();
        $preview->setPath($page_path);
        $preview->setOwnerName(wiki_get_current_user());
        $preview->setGroupId($page->getGroupId());
        $preview->setPermission($group_bits . $other_bits);
        $preview->setTitle($page_title);
        $preview->setBody($body);
        $preview->setThemeId($theme->getId());
        $preview->setCreatedAt(now());
        $preview->store();
        
        $db->query('COMMIT');
        
        $preview_message = $lang['preview created successfully'] . ' <a target="_blank" href="' . wiki_show_preview_path($preview->getId()) . '">Click here</a>';
        
        fMessaging::create('success', 'edit page', $preview_message);
        $title = $lang['Edit Page'];
        $theme_path = wiki_theme_path(DEFAULT_THEME);
        include wiki_theme(DEFAULT_THEME, 'edit-page');
      } catch (fException $e) {
        $db->query('ROLLBACK');
        throw $e;
      }
    } else if ($submit == 'test') {
    } else if ($submit == 'Show history') {
      try {
        
        wiki_unlock($db, $page_id);
        wiki_set_lock($db, $page_id, $user_id);
        
        $db->query('BEGIN');
        
        wiki_clear_previous_previews($db, $page_path, wiki_get_current_user());
        
        $preview = new Preview();
        $preview->setPath($page_path);
        $preview->setOwnerName(wiki_get_current_user());
        $preview->setGroupId($page->getGroupId());
        $preview->setPermission($group_bits . $other_bits);
        $preview->setTitle($page_title);
        $preview->setBody($body);
        $preview->setThemeId($theme->getId());
        $preview->setCreatedAt(now());
        $preview->store();
        
        $db->query('COMMIT');
        
        $preview_message = $lang['preview created successfully'] . ' <a target="_blank" href="' . wiki_show_preview_path($preview->getId()) . '">Click here</a>';
        
        fMessaging::create('success', 'edit page', $preview_message);
        $title = $lang['History Page'];
        $theme_path = wiki_theme_path(DEFAULT_THEME);
        include wiki_theme(DEFAULT_THEME, 'view-history');
      } catch (fException $e) {
        $db->query('ROLLBACK');
        throw $e;
      }
    } else {
      throw new fValidationException('Invalid submit action.');
    }
  } catch (fException $e) {
    fMessaging::create('failure', 'edit page', $e->getMessage());
    $title = $lang['Edit Page'];
    $theme_path = wiki_theme_path(DEFAULT_THEME);
    include wiki_theme(DEFAULT_THEME, 'edit-page');
  }
} else {
  fURL::redirect(wiki_edit_page_path(fRequest::get('id')));
}
