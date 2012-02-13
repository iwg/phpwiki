<?php
$css = array('topic_nav');
$js = array('jquery');
include '_header.php';
?>

<h1><?php echo $revision->getTitle(); ?></h1>

<?php $revision->show(); ?>

<?php
include '_footer.php';
