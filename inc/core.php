<?php
function now()
{
  return date('Y-m-d H:i:s');
}

function wiki_path_info()
{
  return array_key_exists('PATH_INFO', $_SERVER) ? $_SERVER['PATH_INFO'] : '/';
}

function wiki_slugify($str)
{
  return
    preg_replace('{/+}', '/',
      preg_replace('/_+/', '_',
        preg_replace('/\s+/', '_',
          strtolower(trim($str))
        )
      )
    );
}

function wiki_get_slug()
{
  return wiki_slugify(wiki_path_info());
}

function wiki_theme($theme_name, $view_name)
{
  return __DIR__ . "/../themes/$theme_name/tpl/$view_name.php";
}

function wiki_list_theme_names()
{
  $names = array();
  foreach (scandir(__DIR__ . '/../themes/') as $name) {
    if ($name == '.' or $name == '..' or $name == DEFAULT_THEME) {
      continue;
    }
    $names[] = $name;
  }
  return $names;
}

function wiki_is_theme_enabled($theme_name)
{
  try {
    $theme = new Theme(array('name' => $theme_name));
    return true;
  } catch (fNotFoundException $e) {
    return false;
  }
}
