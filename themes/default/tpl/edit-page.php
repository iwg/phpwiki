<?php
fSession::open();
$css = array('main', 'edit-page');
$js = array('sugar', 'jquery');
include '_header.php';
?>

<?php fMessaging::show('success', 'edit page'); ?>
<?php fMessaging::show('failure', 'edit page'); ?>

<form class="form form-horizontal" id="edit-page" action="<?php echo wiki_update_page_path($page_id); ?>" method="post">

  <fieldset>
    <legend><b>General Information</b></legend>
    <div class="field">
      <span class="label label-success" for="title">Title</span><br/>
      <input class="input-xlarge" type="text" id="title" name="title" value="<?php echo $page_title; ?>" <?php echo $disabled?>/>
    </div>
    <div class="field">
      <span class="label label-success" for="path">Page URL</span><br/>
      <span class="input-xlarge uneditable-input"><?php echo HOST_URL . SITE_BASE . $page_path; ?></span><br/>
    </div>
  </fieldset><br/><br/>
  
  <fieldset>
    <legend><b>Content &amp; Visualization</b></legend>
    <div class="field">
      <style>textarea{width:400px;height:400px;resize:none;}</style>
      <textarea class="" id="body" name="body" <?php echo $disabled?>><?php echo htmlentities($body, ENT_COMPAT | ENT_HTML401, "UTF-8"); ?></textarea>
    </div>
    <div class="field">
      <span class="label label-success" for="theme">Theme</span><br/>
      <select id="theme" name="theme" <?php echo $disabled?>>
        <option value="<?php echo $page_theme; ?>"> <?php echo $page_theme; ?></option>
        <?php foreach (wiki_enabled_theme_names() as $name): ?>
          <?php if ($name != $page_theme): ?>
            <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
    </div>
  </fieldset><br/><br/>
  
  <fieldset>
    <legend><b>Finishing Up</b></legend>
    <div class="field">
      <span class="label label-success">Permission</span><br/>
      <div class="permission-group">
        <span class="group-type">Group</span><br/>
        <input type="checkbox" name="group_bits[]" value="4" id="gr"<?php echo wiki_bit_checked_helper($group_bits, 4); ?> <?php echo $gpdisabled?>/>
        <span class="label" for="gr">r</span>
        <input type="checkbox" name="group_bits[]" value="2" id="gw"<?php echo wiki_bit_checked_helper($group_bits, 2); ?> <?php echo $gpdisabled?>/>
        <span class="label" for="gw">w</span>
        <input type="checkbox" name="group_bits[]" value="1" id="gx"<?php echo wiki_bit_checked_helper($group_bits, 1); ?> <?php echo $gpdisabled?>/>
        <span class="label" for="gx">x</span>
      </div>
      <div class="permission-group">
        <span class="group-type">Others</span><br/>
        <input type="checkbox" name="other_bits[]" value="4" id="or"<?php echo wiki_bit_checked_helper($other_bits, 4); ?> <?php echo $opdisabled?>/>
        <span class="label" for="or">r</span>
        <input type="checkbox" name="other_bits[]" value="2" id="ow"<?php echo wiki_bit_checked_helper($other_bits, 2); ?> <?php echo $opdisabled?>/>
        <span class="label" for="ow">w</span>
        <input type="checkbox" name="other_bits[]" value="1" id="ox"<?php echo wiki_bit_checked_helper($other_bits, 1); ?> <?php echo $opdisabled?>/>
        <span class="label" for="ox">x</span><br/>
      </div>
    </div>
    <div class="field">
      <span class="label label-success" for="summary">Summary</span><br/>
      <input class="input-xlarge" type="text" id="summary" name="summary" value="<?php echo $summary; ?>" <?php echo $disabled?>/>
    </div>
    <div class="field">
      <label><!-- placeholder --></label>
      <input type="checkbox" name="is_minor_edit" value="1" id="is_minor_edit"<?php if ($is_minor_edit) echo ' checked'; ?> <?php echo $disabled?>/>
      <span class="label label" class="checkbox-text" for="is_minor_edit">This is a minor edit</span><br/>
    </div>
    <br/><br/>
    <div class="action">
      <input class="btn btn-primary" type="submit" name="submit" value="Save page" <?php echo $disabled?>/>
      <input class="btn btn-success" type="submit" name="submit" value="Show preview" <?php echo $disabled?>/>
      <a class="btn" href="javascript: history.go(-1);">Cancel</a>
    </div>
  </fieldset>
</form>

<?php
include '_footer.php';
