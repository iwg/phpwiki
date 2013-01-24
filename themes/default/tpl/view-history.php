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
    <div class="field">
      <span class="label label-success" for="history">History</span><br/>
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
      <input class="btn btn-primary" type="submit" name="submit" value="Show history" <?php echo $disabled?>/>
      <a class="btn" href="javascript: history.go(-1);">Cancel</a>
    </div>
  </fieldset><br/><br/>
  
  <fieldset>
    <legend><b>General Information</b></legend>
    <div class="field">
      <span class="label label-success" for="title">Title</span><br/>
      <input class="input-xlarge" type="text" id="title" name="title" readonly="readonly" value="<?php echo $page_title; ?>" <?php echo $disabled?>/>
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
      <textarea class="" id="body" name="body" readonly="readonly" <?php echo $disabled?>><?php echo htmlentities($body, ENT_COMPAT | ENT_HTML401, "UTF-8"); ?></textarea>
    </div>   
    <div class="field">
      <span class="label label-success" for="theme">Theme</span><br/>
      <select id="theme" name="theme" <?php echo $disabled?> style="display:none">
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
    <div class="field">
      <span class="label label-success" for="history2">Compare with</span><br/>
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
      <input class="btn btn-primary" type="submit" name="submit" value="Compare" <?php echo $disabled?>/>
    </div>
  </fieldset>
</form>

<?php
include '_footer.php';
