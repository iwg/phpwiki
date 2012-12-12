<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title><?php echo $title; ?><?php echo TITLE_SUFFIX; ?></title>
  
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/css/prettify.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/css/bootstrap.css"/>
  <style>
      body { padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */}
  </style>
  
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/css/bootstrap-responsive.css"/>
  
</head>

<body>
  
  <div class="navbar navbar-fixed-top navbar-inverse">
 	 <div class="navbar-inner">
	    <div class="container">
	      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </a>
	      <a class="brand" href="#">PHPWiki</a>
      
	      <div class="nav-collapse">
	        <ul class="nav">
	          <li class="nav-home"><a href="<?php echo SITE_BASE; ?>"><?php echo $lang['Home']; ?></a></li>
      		  <li class="nav-home"><a href="<?php echo wiki_new_page_path(); ?>"><?php echo $lang['New Page']; ?></a></li>
      		  <li class="nav-home"><a href="<?php echo wiki_new_link_path(); ?>"><?php echo $lang['New Link']; ?></a></li>
      		  <li class="nav-home"><a href="<?php echo wiki_groups_path(); ?>"><?php echo $lang['Groups']; ?></a></li>
      		  <li class="nav-home"><a href="<?php echo wiki_themes_path(); ?>"><?php echo $lang['Themes']; ?></a></li>
	        </ul>
	      </div><!--/.nav-collapse -->
      
	      <?php if (!fAuthorization::checkLoggedIn()): ?>
	      <div class="navbar-form pull-right">
	        <div class="navbar-text pull-right">请登录</div>
	      </div>
      
	      <?php else:?>      
	      <div class="btn-group pull-right">
	      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i>当前用户：<?php echo wiki_get_current_user_display_name() ?><span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Email：</a></li>
	            <li class="divider"></li>
	            <li><a href="#">修改个人信息</a></li>
	            <li><a href="<?php echo SITE_BASE; ?>/login/change-password.php">修改密码</a></li>
	            <li class="divider"></li>
	            <li><a href="<?php echo SITE_BASE; ?>/login/logout.php">登出</a></li>
	          </ul>
	      </div>
      	  <?php endif; ?>    
	      
	      <div class="navbar-text pull-right">
	          <time>服务器时间：<?php echo new fTimestamp(); ?>&nbsp;</time>
	      </div>
	    </div>
	  </div>
	</div>
  
  <div id="page">
    <div class="container-fluid">
     <div class="row-fluid">
       <?php include '_sidebar.php'; ?>
    
    <!div class="span9">
     <div class="span5">

      <div id="header">
         <h1><?php echo $title; ?></h1>
      </div>

      <div id="center">
