<?php
fSession::open();
$css = array('main', 'new-page');
$js = array('sugar', 'jquery');
include '_header.php';
?>

<?php fMessaging::show('success', 'new page'); ?>
<?php fMessaging::show('failure', 'new page'); ?>

<form class="form form-horizontal" id="new-page" action="<?php echo wiki_create_page_path($slug); ?>" method="post">

  <fieldset>
    <legend><b>General Information</b></legend>
    <div class="field">
      <span class="label label-success" for="title">Title</span><br/>
      <input class="input-xlarge" type="text" id="title" name="title" value="<?php echo $page_title; ?>"/>
    </div>
    <div class="field">
      <span class="label label-success" for="path">Page URL</span><br/>
      <div class="input-prepend">
      	<?php if (empty($slug)): ?>
        	<span class="add-on"><?php echo HOST_URL . SITE_BASE; ?>/</span><input class="input-xlarge" type="text" id="path" name="path" value="<?php echo substr($page_path, 1); ?>"/>
      	<?php else: ?>
        	<span class="add-on"><?php echo HOST_URL . SITE_BASE . $slug; ?></span>
        	<input type="hidden" name="path" value="<?php echo substr($slug, 1); ?>"/>
      	<?php endif; ?>
      </div>
    </div>
  </fieldset><br/><br/>
  
  <fieldset>
    <legend><b>Content &amp; Visualization</b></legend>
    <div class="field">
      <style>textarea{width:400px;height:400px;resize:none;}</style>
      <textarea class="monofont" id="body" name="body"><?php echo htmlentities($body); ?></textarea>
    </div>
    <div class="field">
      <span class="label label-success" for="theme">Theme</span><br/>
      <select id="theme" name="theme">
        <option value="<?php echo $page_theme; ?>"><?php echo $page_theme; ?></option>
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
      <span class="label label-success" for="group">Group:</span><br/>
      <select id="group" name="group">
        <option value="2">nobody</option>
        <?php foreach (wiki_get_current_user_group($db) as $row): ?>
          <?php if ($row != 2): ?>
            <option value="<?php echo $row; ?>">
            <?php 
              $tempgroup = new Group(array('id' => $row));
              echo $tempgroup->getName(); 
            ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field">
      <span class="label label-success">Permission:</span>
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
      <span class="label label-success" for="summary">Summary</span><br/>
      <input class="" type="text" id="summary" name="summary" value="<?php echo $summary; ?>"/>
    </div>
    <br/><br/>
    <div class="action">
      <input class="btn btn-primary" type="submit" name="submit" value="Save page"/>
      <input class="btn btn-success" type="submit" name="submit" value="Show preview"/>
      <a class="btn" href="javascript: history.go(-1);">Cancel</a>
    </div>
  </fieldset>
</form>

<?php
include '_footer.php';
