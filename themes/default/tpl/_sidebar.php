<!--div class="container-fluid">
  <div class="row-fluid"-->
    
    <div class="span3">
      <div class="well sidebar-nav">
        <ul class="nav nav-list">
          <li class="nav-header">Hi, <?php echo wiki_get_current_user_display_name() ?></li>
          <?php if (isset($revision)): ?>
      		<li><a href="<?php echo wiki_edit_page_path($revision->getPageId()); ?>">Edit this page</a></li>
    	  <?php endif; ?>
    	  <?php if (isset($revision)): ?>
      		<li><a href="<?php echo wiki_view_history_path($revision->getPageId()); ?>">View history</a></li>
    	  <?php endif; ?>
          <li class="divider"></li>
          <li class="nav-header"><?php echo $lang['General']; ?></li>
          <li class=""><a href="http://groups.google.com/group/php-wiki"><?php echo $lang['Discussion']; ?></a></li>
          <li class=""><a href="https://github.com/oipn4e2/phpwiki/wiki"><?php echo $lang['Documentation']; ?></a></li>
          <li class="divider"></li>
          <li class="nav-header">Development</li>
          <li class=""><a href="https://github.com/oipn4e2/phpwiki">GitHub</a></li>
          <li class=""><a href="https://github.com/oipn4e2/phpwiki/issues"><?php echo $lang['Issues']; ?></a></li>
        </ul>
      </div>
    </div>
    
  <!--/div>
</div-->

