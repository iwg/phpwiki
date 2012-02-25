<ul id="sidebar-items">
  <li>Hi, <?php echo fSession::get('current_user[display_name]') ?></li>
  <li>
    <h3><?php echo $lang['Dashboard']; ?></h3>
    <ul class="links">
      <li><a href="<?php echo SITE_BASE; ?>"><?php echo $lang['Home']; ?></a></li>
      <li><a href="<?php echo wiki_new_page_path(); ?>"><?php echo $lang['New Page']; ?></a></li>
      <li><a href="<?php echo wiki_new_link_path(); ?>"><?php echo $lang['New Link']; ?></a></li>
      <li><a href="<?php echo wiki_groups_path(); ?>"><?php echo $lang['Groups']; ?></a></li>
      <li><a href="<?php echo wiki_themes_path(); ?>"><?php echo $lang['Themes']; ?></a></li>
    </ul>
  </li>
  <li>
    <h3><?php echo $lang['General']; ?></h3>
    <ul class="links">
      <li><a href="http://groups.google.com/group/php-wiki"><?php echo $lang['Discussion']; ?></a></li>
      <li><a href="https://github.com/oipn4e2/phpwiki/wiki"><?php echo $lang['Documentation']; ?></a></li>
    </ul>
  </li>
  <li>
    <h3><?php echo $lang['Development']; ?></h3>
    <ul class="links">
      <li><a href="https://github.com/oipn4e2/phpwiki">GitHub</a></li>
      <li><a href="https://github.com/oipn4e2/phpwiki/issues"><?php echo $lang['Issues']; ?></a></li>
    </ul>
  </li>
</ul>
