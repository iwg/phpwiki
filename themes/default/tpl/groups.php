<?php
fSession::open();
$css = array('main', 'groups');
$js = array('jquery', 'groups');
include '_header.php';
?>

<?php fMessaging::show('success', 'groups'); ?>
<?php fMessaging::show('failure', 'groups'); ?>

<form action="<?php echo wiki_create_group_path(); ?>" method="post">
  <input type="text" name="name"/>
  <input type="submit" value="<?php echo $lang['create group']; ?>"/>
</form>

<dl class="groups">
<?php foreach ($groups as $group): ?>
  <dt>
    <?php echo $group->getName(); ?>
    <form action="<?php echo wiki_destroy_group_path($group->getId()); ?>" method="post">
      <input type="submit" value="-"/>
    </form>
  </dt>
  <dd>
    <dl class="memberships">
    <?php foreach ($group->memberships() as $membership): ?>
      <dt><?php echo $membership->getUserName(); ?></dt>
      <dd>
        <form action="<?php echo wiki_destroy_membership_path($membership->getId()); ?>" method="post">
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