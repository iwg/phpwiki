<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title><?php echo $title; ?></title>
    <?php foreach ($css as $name): ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/css/<?php echo $name; ?>.css"/>
    <?php endforeach; ?>
  </head>
  <body>
