<?php
fSession::open();
$css = array('main', 'revision');
$js = array('sugar', 'jquery');
include '_header.php';
?>
<div class="revision"><?php $revision->show(); ?></div>
<?php
include '_footer.php';
