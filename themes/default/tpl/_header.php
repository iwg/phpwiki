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
      <ul id="sidebar-items">
        <li>
          <h3>General</h3>
          <ul class="links">
            <li><a href="#">Discussion</a></li>
            <li><a href="https://github.com/oipn4e2/phpwiki/wiki">Documentation</a></li>
          </ul>
        </li>
        <li>
          <h3>Development</h3>
          <ul class="links">
            <li><a href="https://github.com/oipn4e2/phpwiki">GitHub</a></li>
            <li><a href="https://github.com/oipn4e2/phpwiki/issues">Issues</a></li>
          </ul>
        </li>
        <li>
          <h3>Developers</h3>
          <ul class="links">
            <li><a href="http://acm.sjtu.edu.cn">ACM class</a></li>
            <li><a href="http://acm.sjtu.edu.cn/~xjia">Xiao Jia</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div id="content">
      <div id="header">
        <h1><?php echo $title; ?></h1>
      </div>

      <div id="center">
