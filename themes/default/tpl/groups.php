<?php
$css = array('base', 'groups');
$js = array('jquery', 'groups');
include '_header.php';
?>

<h1>Groups</h1>

<dl class="groups">
<?php foreach ($groups as $group): ?>
  <dt><?php echo $group->getName(); ?></dt>
  <dd></dd>
<?php endforeach; ?>
</dl>

<?php
include '_footer.php';
