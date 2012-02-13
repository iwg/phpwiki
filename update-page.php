<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {
  try {
    $page = new Page(fRequest::get('id'));
    $page_id = $page->getId();
    $page_title = trim(fRequest::get('title'));
    $page_path = $page->getPath();
    $body = fRequest::get('body');
    $markup = fRequest::get('markup');
    $page_theme = fRequest::get('theme');
    $owner_bits = array_sum(fRequest::get('owner_bits', 'integer[]'));
    $group_bits = array_sum(fRequest::get('group_bits', 'integer[]'));
    $other_bits = array_sum(fRequest::get('other_bits', 'integer[]'));
    $summary = trim(fRequest::get('summary'));
    $is_minor_edit = fRequest::get('is_minor_edit', 'boolean');
    
    if (empty($page_title)) {
      throw new fValidationException('Title cannot be blank.');
    }
    if (!wiki_is_valid_markup_name($markup)) {
      throw new fValidationException('Invalid markup name.');
    }
    if ($owner_bits < 0 or $owner_bits > 7) {
      throw new fValidationException('Invalid owner permission bits.');
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
        $revision->setMarkupName($markup);
        $revision->setThemeId($theme->getId());
        $revision->setIsMinorEdit($is_minor_edit);
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
      // TODO
      throw new fValidationException('Cannot show preview now.');
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
