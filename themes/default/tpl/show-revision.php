<?php
fSession::open();
$css = array('main');
$js = array('sugar', 'jquery');
include '_header.php';
$revision->show();
include '_footer.php';
