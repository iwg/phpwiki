<?php
fSession::open();
$css = array('main');
$js = array('sugar', 'jquery', 'contributors');
include '_header.php';
?>

<?php fMessaging::show('success', 'contributors'); ?>
<?php fMessaging::show('failure', 'contributors'); ?>


<div id="header">
<h2>Contributors</h2>
</div>
<hr/>
<h3>Contributors of Current Version</h3>
<h4>ACM 12</h4>
<p>Hao Chen, Wen Xu</p>
<h3>Past Contributors</h3>
<h4>ACM 11</h4>
<p>Kai Sun</p>

<?php
include '_footer.php';

