<?php
function wiki_theme_path($theme_name)
{
  return THEME_BASE . "/$theme_name";
}

function wiki_groups_path()
{
  return SITE_BASE . '/groups.php';
}

function wiki_create_group_path()
{
  return SITE_BASE . '/create-group.php';
}

function wiki_new_page_path($slug)
{
  return SITE_BASE . '/new-page.php?slug=' . $slug;
}

function wiki_create_membership_path($group_id)
{
  return SITE_BASE . '/create-membership.php?group_id=' . $group_id;
}

function wiki_destroy_membership_path($membership)
{
  return SITE_BASE . '/destroy-membership.php?id=' . $membership->getId();
}
