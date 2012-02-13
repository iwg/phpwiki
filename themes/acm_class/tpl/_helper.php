<?php
function theme_helper_get_page_sidebar($page)
{
  return new Page(array('path' => $page->getPath() . ':sidebar'));
}
