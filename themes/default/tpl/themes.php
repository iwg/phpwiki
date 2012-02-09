<?php
fSession::open();
$css = array('main', 'themes');
$js = array('jquery', 'themes');
include '_header.php';
?>

<?php fMessaging::show('success', 'themes'); ?>
<?php fMessaging::show('failure', 'themes'); ?>

<ul class="themes">
<?php foreach ($theme_names as $theme_name): ?>
  <li>
    <?php echo $theme_name; ?>
    <?php if (wiki_is_theme_enabled($theme_name)): ?>
      <a class="disable action" href="#">(disable)</a>
      <form action="<?php echo wiki_disable_theme_path($theme_name); ?>" method="post"></form>
    <?php else: ?>
      <a class="enable action" href="#">(enable)</a>
      <form action="<?php echo wiki_enable_theme_path($theme_name); ?>" method="post"></form>
    <?php endif; ?>
  </li>
<?php endforeach; ?>
</ul>

<?php
include '_footer.php';
