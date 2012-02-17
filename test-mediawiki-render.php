<?php
include_once(__DIR__ . '/inc/init.php');

$title = fRequest::get('title');
$text = fRequest::get('text');

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Test: MediaWiki Render</title>
  <style type="text/css">
  .monofont { font-family: Consolas,Monaco,"Lucida Console","Liberation Mono","DejaVu Sans Mono","Bitstream Vera Sans Mono","Courier New",monospace; }
  .panel { float: left; }
  .clear { clear: both; }
  </style>
</head>
<body>
  <div class="panel">
    <form action="<?php echo SITE_BASE; ?>/test-mediawiki-render.php" method="POST">
      <textarea class="monofont" rows="40" cols="100" name="text"><?php echo htmlspecialchars($text); ?></textarea><br/>
      <input class="monofont" type="text" name="title" size="90" value="<?php echo $title; ?>"/>
      <input type="submit"/>
    </form>
  </div>
  <?php if (fRequest::isPost()): ?>
  <div class="panel">
    <textarea class="monofont" rows="40" cols="100"><?php echo htmlspecialchars(wiki_render_markup($title, $text)); ?></textarea>
  </div>
  <?php endif; ?>
  <div class="clear">
    <?php echo wiki_render_markup($title, $text); ?>
  </div>
</body>
</html>
