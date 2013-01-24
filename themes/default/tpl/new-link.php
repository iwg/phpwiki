<?php
fSession::open();
$css = array('main', 'new-link');
$js = array('sugar', 'jquery');
include '_header.php';
?>

<?php fMessaging::show('success', 'new link'); ?>
<?php fMessaging::show('failure', 'new link'); ?>

<form class="form form-horizontal" id="new-link" action="<?php echo wiki_create_link_path(); ?>" method="post">
  <fieldset>
    <legend><b>General Information</b></legend>
    <div class="field">
      <span class="label label-success" for="path">Page URL</span><br/>
      <div class="input-prepend">
       <span class="add-on"><?php echo HOST_URL . SITE_BASE; ?>/</span><input class="input-xlarge" type="text" id="path" name="path" value="<?php echo substr($page_path, 1); ?>"/>
      </div>
    </div>
    <div class="field">
      <span class="label label-success" for="dest">Destination</span><br/>
      <input class="input-xlarge" type="text" name="dest" id="dest" value="<?php echo $dest; ?>"/>
    </div>
  </fieldset><br/><br/>
  
  <fieldset>
    <legend><b>Finishing Up</b></legend>
    <div class="field">
      <span class="label label-success">Permission</span>
      <div class="permission-group">
        <span class="group-type">Group</span>
        <input type="checkbox" name="group_bits[]" value="4" id="gr"<?php echo wiki_bit_checked_helper($group_bits, 4); ?>/>
        <span class="label" for="gr">r</span>
        <input type="checkbox" name="group_bits[]" value="2" id="gw"<?php echo wiki_bit_checked_helper($group_bits, 2); ?>/>
        <span class="label" for="gw">w</span>
        <input type="checkbox" name="group_bits[]" value="1" id="gx"<?php echo wiki_bit_checked_helper($group_bits, 1); ?>/>
        <span class="label" for="gx">x</span>
      </div>
      <div class="permission-group">
        <span class="group-type">Others</span>
        <input type="checkbox" name="other_bits[]" value="4" id="or"<?php echo wiki_bit_checked_helper($other_bits, 4); ?>/>
        <span class="label" for="or">r</span>
        <input type="checkbox" name="other_bits[]" value="2" id="ow"<?php echo wiki_bit_checked_helper($other_bits, 2); ?>/>
        <span class="label" for="ow">w</span>
        <input type="checkbox" name="other_bits[]" value="1" id="ox"<?php echo wiki_bit_checked_helper($other_bits, 1); ?>/>
        <span class="label" for="ox">x</span>
      </div>
    </div>
    <div class="field">
      <span class="label label-success"><!-- placeholder --></span><br/>
      <input type="checkbox" name="overwrite" value="1" id="overwrite"<?php if ($overwrite) echo ' checked'; ?>/>
      <span class="checkbox-text label" for="overwrite">Overwrite if path already exists</span>
    </div>
    <br/><br/>
    <div class="action">
      <input class="btn btn-primary" type="submit" name="submit" value="Save link"/>
      <a class="btn" href="javascript: history.go(-1);">Cancel</a>
    </div>
  </fieldset>
</form>

<?php
include '_footer.php';
