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
    <a class="btn btn-danger remove" href="#">Remove</a>
    <form action="<?php echo wiki_destroy_group_path($group->getId()); ?>" method="post"></form>
  </dt>
  <dd>
    <ul class="memberships">
    <?php foreach ($group->memberships() as $membership): ?>
      <li>
        <span class="username" title="<?php echo $membership->getUserName(); ?>"><?php echo $membership->getUserName(); ?></span>
        <a class="btn btn-danger remove" href="#">Remove</a>
        <form action="<?php echo wiki_destroy_membership_path($membership->getId()); ?>" method="post"></form>
      </li>
    <?php endforeach; ?>
      <li>
        <form action="<?php echo wiki_create_membership_path($group->getId()); ?>" method="post">
          <div class="input-append">
          	<input class="name username input-medium" type="text" name="user_name"/><a class="add btn btn-success" href="#">Add</a>
          </div>
        </form>  
        
      </li>
    </ul>
  </dd>
  <div class="fn-clear"></div>
<?php endforeach; ?>
  <dt>
    <form action="<?php echo wiki_create_group_path(); ?>" method="post">
      <span class="label label-success" for="group_name"><?php echo $lang['Group name:']; ?></span><br/>
      <div class="input-append">
      	<input class="name input-medium" type="text" id="group_name" name="name"/><input class="btn btn-primary" type="submit" value="<?php echo $lang['create group']; ?>"/>
      </div>
    </form>
  </dt>
</dl>

<?php
include '_footer.php';
