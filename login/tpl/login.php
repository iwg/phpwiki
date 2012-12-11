<?php include 'tpl/_header.php' ?>
	
	<div class="container">
		<div id="login-box">
			<div id="content">
				<div id="login-form-wrap">
					<div class="page-header"><h1 id="logotype">登录</h1></div>
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
	
<?php include 'tpl/_footer.php' ?>
