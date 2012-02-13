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

function wiki_enabled_theme_names()
{
  return array_filter(wiki_list_theme_names(), 'wiki_is_theme_enabled');
}

function wiki_enabled_markup_names()
{
  return array('MediaWiki', 'Markdown', 'HTML', 'Plain Text');
}

function wiki_is_valid_markup_name($markup_name)
{
  return in_array($markup_name, wiki_enabled_markup_names());
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

function wiki_render_markdown($text)
{
  return Markdown($text);
}
