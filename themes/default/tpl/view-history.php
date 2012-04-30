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
    <div class="field">
      <label for="history">History:</label>
      <select id="history" name="history" <?php echo $disabled?>>
        <option value="<?php echo $page_revision; ?>"> <?php echo $page_revision; ?></option>
        <?php foreach (wiki_get_page_revision() as $name): ?>
          <?php if ($name != $page_revision): ?>
            <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="action">
      <input type="submit" name="submit" value="Show source" <?php echo $disabled?>/>
      <input type="submit" name="submit" value="Show history" <?php echo $disabled?>/>
      <a href="javascript: history.go(-1);">Cancel</a>
    </div>
  </fieldset>
  <fieldset>
    <legend>General Information</legend>
    <div class="field">
      <label for="title">Title:</label>
      <input class="monofont" type="text" id="title" name="title" readonly="readonly" value="<?php echo $page_title; ?>" <?php echo $disabled?>/>
    </div>
    <div class="field">
      <label for="path">Page URL:</label>
      <span class="monofont"><?php echo HOST_URL . SITE_BASE . $page_path; ?></span>
    </div>
  </fieldset>
  <fieldset>
    <legend>Content &amp; Visualization</legend>
    <div class="field">
      <textarea class="monofont" id="body" name="body" readonly="readonly" <?php echo $disabled?>><?php echo htmlentities($body, ENT_COMPAT | ENT_HTML401, "UTF-8"); ?></textarea>
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
</form>

<?php
include '_footer.php';
