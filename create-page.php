<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {

  fAuthorization::requireLoggedIn();

  try {
    $slug = wiki_slugify(fRequest::get('slug'));
    $page_title = trim(fRequest::get('title'));
    $page_path = '/' . wiki_slugify(trim(fRequest::get('path')));

    $fatherpage_path = wiki_get_father_page($page_path);
    if ($fatherpage_path!='') {
      $fatherpage = new Page(array('path' => $fatherpage_path));
      $page_id = $fatherpage->getId();
      $page_owner = $fatherpage->getOwnerName();
      $page_group_id = $fatherpage->getGroupId();
      $group_bits = $fatherpage->getGroupBits();
      $other_bits = $fatherpage->getOtherBits();
      $group_permission = wiki_get_create_permission($group_bits);
      $other_permission = wiki_get_create_permission($other_bits);
      $user_id = wiki_get_current_user_id();
      $user_name = wiki_get_current_user();
      if ($page_owner!=$user_name)
        if (!$group_permission || !wiki_is_in_group($db, $user_name,  $page_group_id)) 
          if (!$other_permission) {
            throw new fValidationException('You are not permitted to create pages here!');
          }    
    }

    $body = fRequest::get('body');
    $page_theme = fRequest::get('theme');
    $group_bits = array_sum(fRequest::get('group_bits', 'integer[]'));
    $other_bits = array_sum(fRequest::get('other_bits', 'integer[]'));
    $summary = trim(fRequest::get('summary'));
    
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
        
        $page = new Page();
        $page->setPath($page_path);
        $page->setOwnerName(wiki_get_current_user());
        $page->setGroupId(wiki_get_current_user_group($db));
        $page->setPermission($group_bits . $other_bits);
        $page->setType(Page::NORMAL);
        $page->setCreatedAt(now());
        $page->store();
        
        $revision = new Revision();
        $revision->setPageId($page->getId());
        $revision->setTitle($page_title);
        $revision->setBody($body);
        $revision->setThemeId($theme->getId());
        $revision->setIsMinorEdit(false);
        $revision->setEditorName(wiki_get_current_user());
        $revision->setCommitMessage($summary);
        $revision->setCreatedAt(now());
        $revision->store();
        
        $db->query('COMMIT');
        
        fURL::redirect(SITE_BASE . $page->getPath());
      } catch (fException $e) {
        $db->query('ROLLBACK');
        throw $e;
      }
    } else if ($submit == 'Show preview') {
      try {
        $db->query('BEGIN');
        
        wiki_clear_previous_previews($db, $page_path, wiki_get_current_user());
        
        $preview = new Preview();
        $preview->setPath($page_path);
        $preview->setOwnerName(wiki_get_current_user());
        $preview->setGroupId(wiki_get_current_user_group($db));
        $preview->setPermission($group_bits . $other_bits);
        $preview->setTitle($page_title);
        $preview->setBody($body);
        $preview->setThemeId($theme->getId());
        $preview->setCreatedAt(now());
        $preview->store();
        
        $db->query('COMMIT');
        
        $preview_message = $lang['preview created successfully'] . ' <a target="_blank" href="' . wiki_show_preview_path($preview->getId()) . '">Click here</a>';
        
        fMessaging::create('success', 'new page', $preview_message);
        $title = $lang['New Page'];
        $theme_path = wiki_theme_path(DEFAULT_THEME);
        include wiki_theme(DEFAULT_THEME, 'new-page');
      } catch (fException $e) {
        $db->query('ROLLBACK');
        throw $e;
      }
    } else {
      throw new fValidationException('Invalid submit action.');
    }
  } catch (fException $e) {
    fMessaging::create('failure', 'new page', $e->getMessage());
    $title = $lang['New Page'];
    $theme_path = wiki_theme_path(DEFAULT_THEME);
    include wiki_theme(DEFAULT_THEME, 'new-page');
  }
} else {
  fURL::redirect(wiki_new_page_path());
}
