<?php
fSession::open();
$css = array('main', 'edit-page');
$js = array('sugar', 'jquery', 'difflib', 'diffview', 'diff');
include '_header.php';
?>

  <strong>Diff View Type:</strong>
  <input type="radio" name="_viewtype" checked="checked" id="sidebyside"/> Side by Side
  &#160;&#160;
  <input type="radio" name="_viewtype" id="inline"/> Inline
  <h2>Text1(Base)</h2>
  <textarea id="baseText" style="width:600px;height:300px" readonly="readonly"><?php echo htmlentities($body, ENT_COMPAT | ENT_HTML401, "UTF-8"); ?></textarea><br/>
  <h2>Text2</h2>
  <textarea id="newText" style="width:600px;height:300px" readonly="readonly"><?php echo htmlentities($body2, ENT_COMPAT | ENT_HTML401, "UTF-8"); ?></textarea><br/><br/>
  <input type="button" value="Diff" onclick="javascript:diffUsingJS();"/><br/><br/>
  <a name="diff"> </a>
  <div id="diffoutput" style="width:100%"> </div>

<?php
include '_footer.php';

