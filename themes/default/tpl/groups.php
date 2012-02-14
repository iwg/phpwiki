<?php
fSession::open();
$css = array('main', 'groups');
$js = array('sugar', 'jquery', 'groups');
include '_header.php';
?>

<?php fMessaging::show('success', 'groups'); ?>
<?php fMessaging::show('failure', 'groups'); ?>

<dl class="groups">
<?php foreach ($groups as $group): ?>
  <dt>
    <?php echo $group->getName(); ?>
    (<?php echo $group->countMemberships(); ?> <?php echo fGrammar::inflectOnQuantity($group->countMemberships(), 'member'); ?>)
    <a class="remove" href="#">(remove)</a>
    <form action="<?php echo wiki_destroy_group_path($group->getId()); ?>" method="post"></form>
  </dt>
  <dd>
    <ul class="memberships">
    <?php foreach ($group->memberships() as $membership): ?>
      <li>
        <span class="username" title="<?php echo $membership->getUserName(); ?>"><?php echo $membership->getUserName(); ?></span>
        <a class="remove" href="#">(remove)</a>
        <form action="<?php echo wiki_destroy_membership_path($membership->getId()); ?>" method="post"></form>
      </li>
    <?php endforeach; ?>
      <li>
        <form action="<?php echo wiki_create_membership_path($group->getId()); ?>" method="post">
          <input class="name username" type="text" name="user_name"/>
        </form>  
        <a class="add" href="#">(add)</a>
      </li>
    </ul>
  </dd>
  <div class="fn-clear"></div>
<?php endforeach; ?>
  <dt>
    <form action="<?php echo wiki_create_group_path(); ?>" method="post">
      <label for="group_name"><?php echo $lang['Group name:']; ?></label>
      <input class="name" type="text" id="group_name" name="name"/>
      <input type="submit" value="<?php echo $lang['create group']; ?>"/>
    </form>
  </dt>
</dl>

<?php
include '_footer.php';
