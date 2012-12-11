<?php include 'tpl/_header.php' ?>
	
	<div class="container">
		<div id="login-box">
			<div id="content">
				<div id="login-form-wrap">
					<div class="page-header"><h1 id="logotype">修改密码</h1></div>
					<div>
						<form action="<?php echo LOGIN_BASE; ?>/change-password.php" id="login-form" method="POST" autocomplete="off">
							<fieldset>
								<div class="control-group">
									<label for="old-password" class="control-label">
										请输入您的旧密码
									</label>
								<input type="password" class="text" name="old-password" tabindex="1" id="old-password"/>
								</div>
								<div class="control-group">
									<label for="new-password" class="control-label">
										请输入您的新密码
									</label>
									<input type="password" class="text" name="new-password" tabindex="2" id="new-password"/>
								</div>
								<div class="control-group">
									<label for="confirm-password" class="control-label">
										请确认您的新密码
									</label>
									<input type="password" class="text" name="confirm-password" tabindex="3" id="confirm-password"/>
								</div>
								<div class="form-actions">
									<input class="btn btn-primary" type="submit" value="确认修改" class="button fn-left" tabindex="4" id="submit"/>
									<a class="btn" href="javascript: history.go(-1);">取消</a>
								</div>
							</fieldset>
						</form>
						<script type="text/javascript">
							document.getElementById('password').focus();
						</script>
					</div>
				</div>
			</div>
		</div>
	</div><!-- container -->
	
<?php include 'tpl/_footer.php' ?>
