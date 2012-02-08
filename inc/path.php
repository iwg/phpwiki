<?php
function wiki_theme_path($theme_name)
{
  return THEME_BASE . "/$theme_name";
}

function wiki_new_page_path($slug)
{
  return 'new-page.php?slug=' . $slug;
}
