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
