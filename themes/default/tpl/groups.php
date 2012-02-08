<?php
fSession::open();
$css = array('base', 'groups');
$js = array('jquery', 'groups');
include '_header.php';
?>

<h1><?php echo $lang['Groups']; ?></h1>

<?php fMessaging::show('failure', 'groups'); ?>

<form action="<?php echo wiki_create_group_path(); ?>" method="post">
  <input type="text" name="name"/>
  <input type="submit" value="<?php echo $lang['create group']; ?>"/>
</form>

<dl class="groups">
<?php foreach ($groups as $group): ?>
  <dt><?php echo $group->getName(); ?></dt>
  <dd>
    <dl class="memberships">
    <?php foreach ($group->memberships() as $membership): ?>
      <dt><?php echo $membership->getUserName(); ?></dt>
      <dd>
        <form action="<?php echo wiki_destroy_membership_path($membership); ?>" method="post">
          <input type="submit" value="-"/>
        </form>
      </dd>
    <?php endforeach; ?>
    </dl>
    <form action="<?php echo wiki_create_membership_path($group->getId()); ?>" method="post">
      <input type="text" name="user_name"/>
      <input type="submit" value="+"/>
    </form>
  </dd>
<?php endforeach; ?>
</dl>

<?php
include '_footer.php';
