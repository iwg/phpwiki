<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {
  try {
    $page_path = '/' . wiki_slugify(trim(fRequest::get('path')));
    $dest = trim(fRequest::get('dest'));
    $owner_bits = array_sum(fRequest::get('owner_bits', 'integer[]'));
    $group_bits = array_sum(fRequest::get('group_bits', 'integer[]'));
    $other_bits = array_sum(fRequest::get('other_bits', 'integer[]'));
    $overwrite = fRequest::get('overwrite', 'boolean');
    
    if (empty($dest)) {
      throw new fValidationException('Destination cannot be blank.');
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
    
    $submit = fRequest::get('submit');
    if ($submit == 'Save link') {
      try {
        $db->query('BEGIN');
        
        if ($overwrite) {
          wiki_remove_page_by_path($db, $page_path);
        }
        
        $page = new Page();
        $page->setPath($page_path);
        $page->setOwnerName(wiki_get_current_user());
        $page->setGroupId(Group::root()->getId()); // FIXME should use real group
        $page->setPermission($owner_bits . $group_bits . $other_bits);
        $page->setType(Page::HYPERLINK);
        $page->setCreatedAt(now());
        $page->store();
        
        $hyperlink = new Hyperlink();
        $hyperlink->setPageId($page->getId());
        $hyperlink->setUrl($dest);
        $hyperlink->setCreatedAt(now());
        $hyperlink->store();
        
        $db->query('COMMIT');
        
        fMessaging::create('success', 'new link', $lang['link created successfully'] . ' <a target="_blank" href="' . SITE_BASE . $page->getPath() . '">Click here</a>');
        fURL::redirect(wiki_new_link_path());
      } catch (fException $e) {
        $db->query('ROLLBACK');
        throw $e;
      }
    } else {
      throw new fValidationException('Invalid submit action.');
    }
  } catch (fException $e) {
    fMessaging::create('failure', 'new link', $e->getMessage());
    $title = $lang['New Link'];
    $theme_path = wiki_theme_path(DEFAULT_THEME);
    include wiki_theme(DEFAULT_THEME, 'new-link');
  }
} else {
  fURL::redirect(wiki_new_link_path());
}
