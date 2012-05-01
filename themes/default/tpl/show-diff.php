<?php
fSession::open();
$css = array('main', 'edit-page');
//$js = array('sugar', 'jquery');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title><?php echo $title; ?><?php echo TITLE_SUFFIX; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/css/base.css" media="all"/>
  <?php foreach ($css as $name): ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/css/<?php echo $name; ?>.css" media="screen"/>
  <?php endforeach; ?>
</head>

<body>
  <div id="page">
    <div id="sidebar">
      <?php include '_sidebar.php'; ?>
    </div>

    <div id="content">
      <div id="header">
        <h1><?php echo $title; ?></h1>
      </div>

      <div id="center">


<html>
<head>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/dojo/1.6.0/dojo/dojo.xd.js"></script>
  <script type="text/javascript" src="<?php echo $theme_path; ?>/js/diffview.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/css/diffview.css"/>
  <script type="text/javascript" src="<?php echo $theme_path; ?>/js/difflib.js"></script>

  <script language="javascript">
  var $ = dojo.byId;
  var url = window.location.toString().split("#")[0];

  function diffUsingJS () {
    var base = difflib.stringAsLines($("baseText").value);
    var newtxt = difflib.stringAsLines($("newText").value);
    var sm = new difflib.SequenceMatcher(base, newtxt);
    var opcodes = sm.get_opcodes();
    var diffoutputdiv = $("diffoutput");
    while (diffoutputdiv.firstChild) diffoutputdiv.removeChild(diffoutputdiv.firstChild);
    var contextSize = $("contextSize").value;
    contextSize = contextSize ? contextSize : null;
    diffoutputdiv.appendChild(diffview.buildView({ baseTextLines:base,
      newTextLines:newtxt,
      opcodes:opcodes,
      baseTextName:"Base Text",
      newTextName:"New Text",
      contextSize:contextSize,
      viewType: $("inline").checked ? 1 : 0 }));
    window.location = url + "#diff";
  }
  </script>
</head>
<body>
  <strong>Context size (optional):</strong> <input type="text" id="contextSize" value=""></input><br/>
  <strong>Diff View Type:</strong>
  <input type="radio" name="_viewtype" checked="checked" id="sidebyside"/> Side by Side
  &#160;&#160;
  <input type="radio" name="_viewtype" id="inline"/> Inline
  <h2>Base Text</h2>
  <textarea id="baseText" style="width:600px;height:300px"></textarea><br/>
  <h2>New Text</h2>
  <textarea id="newText" style="width:600px;height:300px"></textarea><br/><br/>
  <input type="button" value="Diff" onclick="javascript:diffUsingJS();"/><br/><br/>
  <a name="diff"> </a>
  <div id="diffoutput" style="width:100%"> </div>
</body>
</html>

      </div>

      <div id="outtro">
        <strong>phpwiki</strong> is sponsored and made possible by constant development from
        <a href="http://acm.sjtu.edu.cn">ACM class</a>.
      </div>
    </div>

    <div id="footer">
      &copy; 2012
    </div>
  </div>
  <?php foreach ($js as $name): ?>
    <script type="text/javascript" src="<?php echo $theme_path; ?>/js/<?php echo $name; ?>.js"></script>
  <?php endforeach; ?>
</body>
</html>
