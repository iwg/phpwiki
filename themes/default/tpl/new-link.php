<?php
fSession::open();
$css = array('main', 'new-link');
$js = array('sugar', 'jquery');
include '_header.php';
?>

<?php fMessaging::show('success', 'new link'); ?>
<?php fMessaging::show('failure', 'new link'); ?>

<form id="new-link" action="<?php echo wiki_create_link_path(); ?>" method="post">
  <fieldset>
    <legend>General Information</legend>
    <div class="field">
      <label for="path">Page URL:</label>
      <span class="monofont"><?php echo HOST_URL . SITE_BASE; ?>/</span><input class="monofont" type="text" id="path" name="path" value="<?php echo substr($page_path, 1); ?>"/>
    </div>
    <div class="field">
      <label for="dest">Destination:</label>
      <input class="monofont" type="text" name="dest" id="dest" value="<?php echo $dest; ?>"/>
    </div>
  </fieldset>
  <fieldset>
    <legend>Finishing Up</legend>
    <div class="field">
      <label>Permission:</label>
      <div class="permission-group">
        <span class="group-type">(owner)</span>
        <input type="checkbox" name="owner_bits[]" value="4" id="ur"<?php echo wiki_bit_checked_helper($owner_bits, 4); ?>/>
        <label for="ur">r</label>
        <input type="checkbox" name="owner_bits[]" value="2" id="uw"<?php echo wiki_bit_checked_helper($owner_bits, 2); ?>/>
        <label for="uw">w</label>
        <input type="checkbox" name="owner_bits[]" value="1" id="ux"<?php echo wiki_bit_checked_helper($owner_bits, 1); ?>/>
        <label for="ux">x</label>
      </div>
      <div class="permission-group">
        <span class="group-type">(group)</span>
        <input type="checkbox" name="group_bits[]" value="4" id="gr"<?php echo wiki_bit_checked_helper($group_bits, 4); ?>/>
        <label for="gr">r</label>
        <input type="checkbox" name="group_bits[]" value="2" id="gw"<?php echo wiki_bit_checked_helper($group_bits, 2); ?>/>
        <label for="gw">w</label>
        <input type="checkbox" name="group_bits[]" value="1" id="gx"<?php echo wiki_bit_checked_helper($group_bits, 1); ?>/>
        <label for="gx">x</label>
      </div>
      <div class="permission-group">
        <span class="group-type">(other)</span>
        <input type="checkbox" name="other_bits[]" value="4" id="or"<?php echo wiki_bit_checked_helper($other_bits, 4); ?>/>
        <label for="or">r</label>
        <input type="checkbox" name="other_bits[]" value="2" id="ow"<?php echo wiki_bit_checked_helper($other_bits, 2); ?>/>
        <label for="ow">w</label>
        <input type="checkbox" name="other_bits[]" value="1" id="ox"<?php echo wiki_bit_checked_helper($other_bits, 1); ?>/>
        <label for="ox">x</label>
      </div>
    </div>
    <div class="field">
      <label><!-- placeholder --></label>
      <input type="checkbox" name="overwrite" value="1" id="overwrite"<?php if ($overwrite) echo ' checked'; ?>/>
      <label class="checkbox-text" for="overwrite">Overwrite if path already exists</label>
    </div>
    <div class="action">
      <input type="submit" name="submit" value="Save link"/>
      <a href="javascript: history.go(-1);">Cancel</a>
    </div>
  </fieldset>
</form>

<?php
include '_footer.php';
