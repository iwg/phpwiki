<?php
fSession::open();
$css = array('main', 'edit-page');
$js = array('sugar', 'jquery');
include '_header.php';
?>

<?php fMessaging::show('success', 'edit page'); ?>
<?php fMessaging::show('failure', 'edit page'); ?>

<form id="edit-page" action="<?php echo wiki_update_page_path($page_id); ?>" method="post">
  <fieldset>
    <legend>General Information</legend>
    <div class="field">
      <label for="title">Title:</label>
      <input class="monofont" type="text" id="title" name="title" value="<?php echo $page_title; ?>" <?php echo $disabled?>/>
    </div>
    <div class="field">
      <label for="path">Page URL:</label>
      <span class="monofont"><?php echo HOST_URL . SITE_BASE . $page_path; ?></span>
    </div>
  </fieldset>
  <fieldset>
    <legend>Content &amp; Visualization</legend>
    <div class="field">
      <textarea class="monofont" id="body" name="body" <?php echo $disabled?>><?php echo htmlentities($body); ?></textarea>
    </div>
    <div class="field">
      <label for="theme">Theme:</label>
      <select id="theme" name="theme" <?php echo $disabled?>>
        <option value="<?php echo $page_theme; ?>"> <?php echo $page_theme; ?></option>
        <?php foreach (wiki_enabled_theme_names() as $name): ?>
          <?php if ($name != $page_theme): ?>
            <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
    </div>
  </fieldset>
  <fieldset>
    <legend>Finishing Up</legend>
    <div class="field">
      <label>Permission:</label>
      <div class="permission-group">
        <span class="group-type">(group)</span>
        <input type="checkbox" name="group_bits[]" value="4" id="gr"<?php echo wiki_bit_checked_helper($group_bits, 4); ?> <?php echo $disabled?>/>
        <label for="gr">r</label>
        <input type="checkbox" name="group_bits[]" value="2" id="gw"<?php echo wiki_bit_checked_helper($group_bits, 2); ?> <?php echo $disabled?>/>
        <label for="gw">w</label>
        <input type="checkbox" name="group_bits[]" value="1" id="gx"<?php echo wiki_bit_checked_helper($group_bits, 1); ?> <?php echo $disabled?>/>
        <label for="gx">x</label>
      </div>
      <div class="permission-group">
        <span class="group-type">(other)</span>
        <input type="checkbox" name="other_bits[]" value="4" id="or"<?php echo wiki_bit_checked_helper($other_bits, 4); ?> <?php echo $disabled?>/>
        <label for="or">r</label>
        <input type="checkbox" name="other_bits[]" value="2" id="ow"<?php echo wiki_bit_checked_helper($other_bits, 2); ?> <?php echo $disabled?>/>
        <label for="ow">w</label>
        <input type="checkbox" name="other_bits[]" value="1" id="ox"<?php echo wiki_bit_checked_helper($other_bits, 1); ?> <?php echo $disabled?>/>
        <label for="ox">x</label>
      </div>
    </div>
    <div class="field">
      <label for="summary">Summary:</label>
      <input class="monofont" type="text" id="summary" name="summary" value="<?php echo $summary; ?>" <?php echo $disabled?>/>
    </div>
    <div class="field">
      <label><!-- placeholder --></label>
      <input type="checkbox" name="is_minor_edit" value="1" id="is_minor_edit"<?php if ($is_minor_edit) echo ' checked'; ?> <?php echo $disabled?>/>
      <label class="checkbox-text" for="is_minor_edit">This is a minor edit</label>
    </div>
    <div class="action">
      <input type="submit" name="submit" value="Save page" <?php echo $disabled?>/>
      <input type="submit" name="submit" value="Show preview" <?php echo $disabled?>/>
      <a href="javascript: history.go(-1);">Cancel</a>
    </div>
  </fieldset>
</form>

<?php
include '_footer.php';
