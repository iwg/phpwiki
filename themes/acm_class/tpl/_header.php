<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8"/>
  <title>上海交通大学ACM班 - <?php echo $title; ?></title>
  <meta name="generator" content="phpwiki"/>
  <meta name="author" content="ACM Infrastructure Working Group"/>
  <meta name="description" content="上海交通大学ACM班"/>
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/css/main.css" media="all"/>
  <?php foreach ($css as $name): ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/css/<?php echo $name; ?>.css" media="screen"/>
  <?php endforeach; ?>
</head>
<body>
  <div id="main">
    <div id="heading">
      <div class="inner">
        <h1>
          <a href="<?php echo SITE_BASE; ?>">
            <img src="<?php echo $theme_path; ?>/img/head-logo.png" title="上海交通大学ACM班"/>
          </a>
        </h1>
        <div id="nav" class="nav">
          <div class="navlist">
            <ul class="nav">
              <li class="<?php echo wiki_equals_helper($page->getPath(), '/', 'active'); ?>"><a href="<?php echo SITE_BASE; ?>">首页</a></li>
              <li class="<?php echo wiki_equals_helper($page->getPath(), '/班级介绍', 'active'); ?>"><a href="<?php echo SITE_BASE; ?>/班级介绍">班级介绍</a></li>
              <li class="<?php echo wiki_equals_helper($page->getPath(), '/招生信息', 'active'); ?>"><a href="<?php echo SITE_BASE; ?>/招生信息">招生信息</a></li>
              <li class="<?php echo wiki_equals_helper($page->getPath(), '/courses', 'active'); ?>"><a href="<?php echo SITE_BASE; ?>/courses">课程中心</a></li>
              <li class="<?php echo wiki_equals_helper($page->getPath(), '/科研成果', 'active'); ?>"><a href="<?php echo SITE_BASE; ?>/科研成果">科研成果</a></li>
              <li class="<?php echo wiki_equals_helper($page->getPath(), '/课余生活', 'active'); ?>"><a href="<?php echo SITE_BASE; ?>/课余生活">课余生活</a></li>
              <li class="<?php echo wiki_equals_helper($page->getPath(), '/icpc', 'active'); ?>"><a href="<?php echo SITE_BASE; ?>/icpc">ACM竞赛</a></li>
            </ul>
          </div><!-- END .navlist -->
        </div><!-- END #nav -->
      </div><!-- END .inner -->
    </div><!-- END #heading -->

    <div class="subpage" id="content">
      <div class="inner-page">
        <div class="newspaper">
          <div id="blog-post">
            <div class="post-content">
              <div class="zh_page_body <?php echo wiki_slugify($revision->getMarkupName()); ?>">
