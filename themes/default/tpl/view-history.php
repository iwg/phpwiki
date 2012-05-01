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
        <?php $i=1; $r=1+$page->getRevisionID($revision); ?>
        <option value="<?php echo $r.' '.$revision->getUpdated_at(); ?>"> <?php echo $r.' '.$revision->getUpdated_at(); ?></option>
        <?php foreach (wiki_get_page_revision($page) as $name): ?>
          <?php if ($name != $revision): ?>  
            <option value="<?php echo $i.' '.$name->getUpdated_at(); ?>"><?php echo $i.' '.$name->getUpdated_at(); ?></option>
          <?php endif; ?>
          <?php $i++; ?>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="action">
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
      <select id="theme" name="theme" <?php echo $disabled?> onbeforeactivate="return false" onfocus="this.blur()" onmouseover="this.setCapture()" onmouseout="this.releaseCapture()">
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
    <div class="field">
      <label for="history2">Compare with:</label>
      <select id="history2" name="history2" <?php echo $disabled?>>
        <?php $i=1; $r=1+$page->getRevisionID($revision); ?>
        <option value="<?php echo $r.' '.$revision->getUpdated_at(); ?>"> <?php echo $r.' '.$revision->getUpdated_at(); ?></option>
        <?php foreach (wiki_get_page_revision($page) as $name): ?>
          <?php if ($name != $revision): ?>  
            <option value="<?php echo $i.' '.$name->getUpdated_at(); ?>"><?php echo $i.' '.$name->getUpdated_at(); ?></option>
          <?php endif; ?>
          <?php $i++; ?>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="action">
      <input type="submit" name="submit" value="Compare" <?php echo $disabled?>/>
    </div>
  </fieldset>
</form>

<?php
include '_footer.php';
