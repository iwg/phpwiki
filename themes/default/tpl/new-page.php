<?php
fSession::open();
$css = array('main', 'new-page');
$js = array('jquery');
include '_header.php';
?>

<?php fMessaging::show('success', 'new page'); ?>
<?php fMessaging::show('failure', 'new page'); ?>

<form id="new-page" action="<?php echo wiki_create_page_path($slug); ?>" method="post">
  <fieldset>
    <legend>General Information</legend>
    <div class="field">
      <label for="title">Title:</label>
      <input class="monofont" type="text" id="title" name="title" value="<?php echo $page_title; ?>"/>
    </div>
    <div class="field">
      <label for="path">Page URL:</label>
      <?php if (empty($slug)): ?>
        <span class="monofont"><?php echo HOST_URL . SITE_BASE; ?>/</span><input class="monofont" type="text" id="path" name="path" value="<?php echo $page_path; ?>"/>
      <?php else: ?>
        <span class="monofont"><?php echo HOST_URL . SITE_BASE . $slug; ?></span>
        <input type="hidden" name="path" value="<?php echo $slug; ?>"/>
      <?php endif; ?>
    </div>
  </fieldset>
  <fieldset>
    <legend>Content &amp; Visualization</legend>
    <div class="field">
      <textarea class="monofont" id="body" name="body"><?php echo $body; ?></textarea>
    </div>
    <div class="field">
      <label for="markup">Markup:</label>
      <select id="markup" name="markup">
        <option value="<?php echo $markup; ?>"><?php echo $markup; ?></option>
        <?php foreach (wiki_enabled_markup_names() as $name): ?>
          <?php if ($name != $markup): ?>
            <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="field">
      <label for="theme">Theme:</label>
      <select id="theme" name="theme">
        <option value="<?php echo $page_theme; ?>"><?php echo $page_theme; ?></option>
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
      <label for="summary">Summary:</label>
      <input class="monofont" type="text" id="summary" name="summary" value="<?php echo $summary; ?>"/>
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
