<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {
  try {
    $slug = wiki_slugify(fRequest::get('slug'));
    $page_title = trim(fRequest::get('title'));
    $page_path = '/' . wiki_slugify(trim(fRequest::get('path')));
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
        $page->setGroupId(Group::root()->getId()); // FIXME should use real group
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
        $preview->setGroupId(Group::root()->getId()); // FIXME should use real group
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
