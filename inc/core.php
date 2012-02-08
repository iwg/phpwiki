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
