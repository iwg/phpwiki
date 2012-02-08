<?php
function wiki_path_info()
{
  return array_key_exists('PATH_INFO', $_SERVER) ? $_SERVER['PATH_INFO'] : '/';
}

function wiki_slugify($str)
{
  return preg_replace('/\s+/', '_', strtolower(trim($str)));
}

function wiki_get_slug()
{
  return wiki_slugify(wiki_path_info());
}

function wiki_theme($theme_name, $view_name)
{
  // XXX should query database for themes dir
  return __DIR__ . "/../themes/$theme_name/tpl/$view_name.php";
}

function wiki_title($title)
{
  return $title . TITLE_SUFFIX;
}
