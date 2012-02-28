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
    if (empty($name) or $name[0] == '.') {
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

function wiki_enabled_theme_names()
{
  return array_filter(wiki_list_theme_names(), 'wiki_is_theme_enabled');
}

function wiki_guess_title_from_slug($slug)
{
  // TODO
  return $slug;
}

function wiki_bit_checked_helper($bits, $mask)
{
  return ($bits & $mask) > 0 ? ' checked' : '';
}

function wiki_equals_helper($a, $b, $c, $d = '')
{
  return $a == $b ? $c : $d;
}

function wiki_get_current_user()
{
  // TODO
  return "xjia";
}

function wiki_clear_previous_previews($db, $path, $user)
{
  $db->translatedExecute('DELETE FROM previews WHERE path=%s AND owner_name=%s', $path, $user);
}

function wiki_remove_page_by_path($db, $path)
{
  $db->translatedExecute('DELETE FROM pages WHERE path=%s', $path);
}
