<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>登录 | <?php echo SITE_TITLE; ?></title>
	
	<link rel="stylesheet" type="text/css" href="<?php echo LOGIN_BASE; ?>/css/prettify.css"/>
  	<link rel="stylesheet" type="text/css" href="<?php echo LOGIN_BASE; ?>/css/bootstrap.css"/>
  	<link rel="stylesheet" type="text/css" href="<?php echo LOGIN_BASE; ?>/css/bootstrap-responsive.css"/>
  	
  	<style>
      body { padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */}
  	</style>
	
</head>

<body id="login" onload="prettyPrint()">

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
	        
	      </div><!--/.nav-collapse -->
      
	      
	    </div>
	  </div>
	</div>
	
	<div class="container">
		<div id="login-box">
			<div id="content">
				<div id="login-form-wrap">
					<div class="page-header"><h1 id="logotype">登录</h1></div>
					<!--div id="flash-block"><?php //echo $errmsg; ?></div-->
						<form action="<?php echo LOGIN_BASE; ?>/" id="login-form" method="POST" autocomplete="off">
							<fieldset>
								<div class="control-group">
									<label for="username" class="control-label">
										用户名
									</label>
									<input type="text" name="username" value="<?php echo $username; ?>" tabindex="1" id="username"/>
								</div>
								<div class="control-group">
									<label for="password" class="control-label">
										密码
									</label>
									<input type="password" name="password" tabindex="2" id="password"/>
								</div>
								<div class="form-actions">
								<input class="btn btn-primary" type="submit" value="登录" class="button fn-left" tabindex="3" id="submit"/>
								</div>
							</fieldset>
						</form>
						<script type="text/javascript">
							document.getElementById('username').focus();
						</script>
				</div>
			</div>
		</div><!-- login-box -->
	</div><!-- container -->
	
	<div id="footer">
    	<div class="container">
    	    <p class="muted credit">
         		<b>PHPWiki</b> is sponsored and made possible by constant development from <a href="http://php.net/">PHP Technologies</a> |
         		<a href="http://twitter.github.com/bootstrap/">Bootstrap</a> |
  				<a href="<?php echo wiki_contributors(); ?>">Contributors</a>
  				<br>
  				Copyright &copy; 2012 <a href="http://acm.sjtu.edu.cn/">ACM Class</a>.
  				All rights reserved.
  				<br>
       		</p>
     	</div>
   </div>
	
<script src="<?php echo LOGIN_BASE; ?>/js/jquery.min.js"></script>
<script src="<?php echo LOGIN_BASE; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo LOGIN_BASE; ?>/js/prettify.js"></script>
</body>
</html>
