<?php
include_once(__DIR__ . '/inc/init.php');

if (fRequest::isPost()) {
  try {
    $slug = wiki_slugify(fRequest::get('slug'));
    $page_title = trim(fRequest::get('title'));
    $page_path = wiki_slugify(trim(fRequest::get('path')));
    $body = fRequest::get('body');
    $markup = fRequest::get('markup');
    $page_theme = fRequest::get('theme');
    $owner_bits = array_sum(fRequest::get('owner_bits', 'integer[]'));
    $group_bits = array_sum(fRequest::get('group_bits', 'integer[]'));
    $other_bits = array_sum(fRequest::get('other_bits', 'integer[]'));
    $summary = trim(fRequest::get('summary'));
    
    if (empty($page_title)) {
      throw new fValidationException('Title cannot be blank.');
    }
    if (!wiki_is_valid_markup_name($markup)) {
      throw new fValidationException('Invalid markup name.');
    }
    $theme = new Theme(array('name' => $page_theme));
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
    if ($submit == 'Save page') {
      //
      throw new fValidationException('Cannot save page now.');
    } else if ($submit == 'Show preview') {
      // TODO
      throw new fValidationException('Cannot show preview now.');
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
