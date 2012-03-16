<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {

  fAuthorization::requireLoggedIn();

  try {
    $page_path = '/' . wiki_slugify(trim(fRequest::get('path')));
    if (strstr($page_path, '..') || strstr($page_path, '//')) {
      throw new fValidationException('There cannot be .. or // in the path');
    }

    $parent_path = Page::parentPage($page_path);
    if ($parent_path != '/') {
      try {
        $parent = new Page(array('path' => $parent_path));
      } catch (fNotFoundException $e) {
        throw new fValidationException('Please create the parent page first');
      }
      $user_name = wiki_get_current_user();
      if (!$parent->isPermitted($user_name, 'create')) {
        throw new fValidationException('You are not permitted to create links here!');
      }
    }

    $dest = trim(fRequest::get('dest'));
    $group_bits = array_sum(fRequest::get('group_bits', 'integer[]'));
    $other_bits = array_sum(fRequest::get('other_bits', 'integer[]'));
    $overwrite = fRequest::get('overwrite', 'boolean');
    
    if (empty($dest)) {
      throw new fValidationException('Destination cannot be blank.');
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
        $page->setGroupId(wiki_get_current_user_group($db));
        $page->setPermission($group_bits . $other_bits);
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
