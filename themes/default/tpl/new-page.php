<?php
fSession::open();
$css = array('main', 'new-page');
$js = array('jquery');
include '_header.php';
?>

<?php fMessaging::show('success', 'new page'); ?>
<?php fMessaging::show('failure', 'new page'); ?>

<form id="new-page" action="<?php echo wiki_create_page_path(); ?>" method="post">
  <fieldset>
    <legend>General Information</legend>
    <div class="field">
      <label for="title">Title:</label>
      <input type="text" id="title" name="title"/>
    </div>
    <div class="field">
      <label for="path">Page URL:</label>
      <?php if (empty($slug)): ?>
        <?php echo HOST_URL . SITE_BASE; ?>/<input type="text" id="path" name="path"/>
      <?php else: ?>
        <?php echo HOST_URL . SITE_BASE . $slug; ?>
        <input type="hidden" name="path" value="<?php echo $slug; ?>"/>
      <?php endif; ?>
    </div>
  </fieldset>
  <fieldset>
    <legend>Content &amp; Visualization</legend>
    <div class="field">
      <textarea id="body" name="body"></textarea>
    </div>
    <div class="field">
      <label for="markup">Markup:</label>
      <select id="markup" name="markup">
        <option value=""></option>
        <?php foreach (wiki_enabled_markup_names() as $name): ?>
          <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="field">
      <label for="theme">Theme:</label>
      <select id="theme" name="theme">
        <option value="<?php echo DEFAULT_THEME; ?>"><?php echo DEFAULT_THEME; ?></option>
        <?php foreach (wiki_enabled_theme_names() as $name): ?>
          <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </fieldset>
  <fieldset>
    <legend>Finishing Up</legend>
    <div class="field">
      <label>Permission:</label>
      <div class="permission-group">
        <span class="group-type">(owner)</span>
        <input type="checkbox" name="owner_bits[]" value="4" id="ur" checked/><label for="ur">r</label>
        <input type="checkbox" name="owner_bits[]" value="2" id="uw" checked/><label for="uw">w</label>
        <input type="checkbox" name="owner_bits[]" value="1" id="ux" checked/><label for="ux">x</label>
      </div>
      <div class="permission-group">
        <span class="group-type">(group)</span>
        <input type="checkbox" name="group_bits[]" value="4" id="gr" checked/><label for="gr">r</label>
        <input type="checkbox" name="group_bits[]" value="2" id="gw" checked/><label for="gw">w</label>
        <input type="checkbox" name="group_bits[]" value="1" id="gx" checked/><label for="gx">x</label>
      </div>
      <div class="permission-group">
        <span class="group-type">(other)</span>
        <input type="checkbox" name="other_bits[]" value="4" id="or"/><label for="or">r</label>
        <input type="checkbox" name="other_bits[]" value="2" id="ow"/><label for="ow">w</label>
        <input type="checkbox" name="other_bits[]" value="1" id="ox"/><label for="ox">x</label>
      </div>
    </div>
    <div class="field">
      <label for="summary">Summary:</label>
      <input type="text" id="summary" name="summary"/>
    </div>
    <div class="action">
      <input type="submit" name="submit" value="Save page"/>
      <input type="submit" name="submit" value="Show preview"/>
      <a href="javascript: history.go(-1);">Cancel</a>
    </div>
  </fieldset>
</form>

<?php
include '_footer.php';
