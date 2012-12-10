<?php
fSession::open();
$css = array('main');
$js = array('sugar', 'jquery', 'themes');
include '_header.php';
?>

<?php fMessaging::show('success', 'themes'); ?>
<?php fMessaging::show('failure', 'themes'); ?>

<ul class="themes">
<?php foreach ($theme_names as $theme_name): ?>
  <li>
    <?php if (wiki_is_theme_enabled($theme_name)): ?>
      <a class="btn btn-success disable action" href="#"><i class="icon-white icon-ok"></i><?php echo $theme_name; ?></a>
      <form action="<?php echo wiki_disable_theme_path($theme_name); ?>" method="post"></form>
    <?php else: ?>
      <a class="btn enable action" href="#"><i class="icon-remove"></i><?php echo $theme_name; ?></a>
      <form action="<?php echo wiki_enable_theme_path($theme_name); ?>" method="post"></form>
    <?php endif; ?>
  </li>
<?php endforeach; ?>
</ul>

<?php
include '_footer.php';
