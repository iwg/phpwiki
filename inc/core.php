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


function wiki_get_page_revision($page)
{
  return array();
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
  $temp = fAuthorization::getUserToken();
  return $temp['name'];
}

function wiki_get_current_user_id()
{
  $temp = fAuthorization::getUserToken();
  return $temp['id'];
}

function wiki_get_current_user_display_name()
{
  $temp = fAuthorization::getUserToken();
  return $temp['display_name'];
}

function wiki_get_current_user_group($db)
{
  $temp = fAuthorization::getUserToken();
  $result = $db->translatedQuery('SELECT group_id FROM memberships WHERE user_name=%s', $temp['name']);
  if ($result->countReturnedRows() == 0) {
    return Group::nobody()->getId();
  } else {
    foreach ($result as $row)
      return $row['group_id'];
  }
}

function wiki_clear_previous_previews($db, $path, $user)
{
  $db->translatedExecute('DELETE FROM previews WHERE path=%s AND owner_name=%s', $path, $user);
}

function wiki_remove_page_by_path($db, $path)
{
  $db->translatedExecute('DELETE FROM pages WHERE path=%s', $path);
}

function wiki_check_lock($db, $page_id, $user_id) 
{
  $result = $db->translatedQuery('SELECT * FROM locks WHERE page_id=%i', $page_id);
  if (!$result) {
    return false;
  }
  foreach ($result as $row) {
    $time_diff = strtotime(now()) - strtotime($row['created_at']);
    if ($time_diff > LOCK_TIME) {
      wiki_unlock($db, $page_id);
      return false;
    }
    return $row['user_id'];
  }
}

function wiki_set_lock($db, $page_id, $user_id)
{
  if (LOCK_TIME == 0) {
    return;
  }
  $db->translatedExecute('INSERT INTO locks 
(page_id, user_id, created_at) VALUES 
(%i, %i, %s)', $page_id, $user_id, now());
}

function wiki_unlock($db, $page_id)
{
  $db->translatedExecute('DELETE FROM locks WHERE page_id=%i', $page_id);
}

function wiki_is_root($user_id)
{
  global $ROOT_IDS;
  return array_search($user_id, $ROOT_IDS);
}

function wiki_no_permission()
{
  echo "You don't have the permission!";
  exit();
}

function wiki_allow_write($permission_bits)
{
  return (int)(($permission_bits % 4) / 2) == 1;
}

function wiki_allow_read($permission_bits)
{
  return (int)($permission_bits / 4) == 1;
}

function wiki_allow_create($permission_bits)
{
  return (int)($permission_bits % 2) == 1;
}
