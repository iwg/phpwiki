<?php
include_once(__DIR__ . '/inc/init.php');

$groups = fRecordSet::build('Group');
$memberships = array();
foreach ($groups as $group) {
  $memberships[$group->getId()] = $group->buildMemberships();
}

$title = wiki_title('Groups');
$theme_path = wiki_theme_path('default');
include wiki_theme('default', 'groups');
