<div class="container" id="wapper">
	<div class="row">
		<?php if($pageVars["route"]["action"] == "login"){
		?>
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Login</strong> </h3>
				</div>
				<div class="panel-body">
					<h4 class="text-uppercase text-light"><a href="/"><center> PTBuild - Pharaoh Tools </center></h4>
					<a href="/">
                        <img src="/index.php?control=AssetLoader&action=show&module=PostInput&type=image&asset=5.png" class="navbar-img" style="height: 50px;margin-left: auto;margin-right: auto;display: block" />
                    </a>
					<div class="row clearfix no-margin">
						<h5 class="text-uppercase text-light" style="margin-top: 15px;">  </h5>
						<p style="color: #ff6312; margin-left: 46px;" id="login_error_msg"></p>
						<form class="form-horizontal custom-form">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label text-left"></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="login_username" placeholder="User Name">
									<span style="color:#FF0000;" id="login_username_alert"></span>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-1 control-label text-left"></label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="login_password" placeholder="Password">
									<span style="color:#FF0000;" id="login_password_alert"></span>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-1 col-sm-10">
									<button type="button" onclick="submit_login();" class="btn btn-lg btn-info btn-block">
										Login
									</button> 
								<br>
								<a href="http://www.ptbuild.tld/index.php?control=Signup&action=registration"> Registration </a>
								<br />
								Sign in with:
								<a href="/index.php?control=OAuth&action=githublogin" class="btn btn-social-icon btn-lg" title="Github"><i class="fa fa-github"></i></a>
								<a href="/index.php?control=OAuth&action=fblogin" class="btn btn-social-icon btn-lg" title="Facebook"><i class="fa fa-facebook"></i></a>
								<a href="/index.php?control=OAuth&action=linkedinlogin" class="btn btn-social-icon btn-lg" title="LinkedIn"><i class="fa fa-linkedin"></i></a>
								</div>
							</div>
						</form>
					</div>
					<p>
						---------------------------------------
						<br/>
						Visit www.pharaohtools.com for more
					</p>

				</div>
				
				<?php }
					if($pageVars["route"]["action"] == "registration"){
						
				?>
				
				<div class="col-md-4 col-md-offset-4 clearfix main-container signup-position">
					<div class="login-panel panel panel-default" style="margin-top: 40px">
				<div class="panel-heading">
					<h3 class="panel-title"><center><b>Registration</b></center> </h3> 
				</div>
					<h4 class="text-uppercase text-light"><a href="/"> <center>PTBuild - Pharaoh Tools <center></a></h4>
					<a href="#"><img src="/index.php?control=AssetLoader&action=show&module=PostInput&type=image&asset=5.png" class="navbar-img" style="height: 50px;margin-left: auto;margin-right: auto;display: block" /></a>
					<div class="row clearfix no-margin">
						<h5 class="text-uppercase text-light" style="margin-top: 15px;margin-left: 51px;">  </h5>
						<p style="color: #7CFC00; margin-left: 100px;" id="registration_error_msg"></p>
						<form class="form-horizontal custom-form">
							<div class="form-group">
								<label for="login_username" class="col-sm-1 control-label text-left"></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="login_username" placeholder="User Name">
									<span style="color:#FF0000;" id="login_username_alert"></span>
								</div>
							</div>
							<div class="form-group">
								<label for="login_email" class="col-sm-1 control-label text-left"></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="login_email" placeholder=" Email">
									<span style="color:#FF0000;" id="login_email_alert"></span>
								</div>
							</div>
							<div class="form-group">
								<label for="login_password" class="col-sm-1 control-label text-left"></label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="login_password" placeholder="Password">
									<span style="color:#FF0000;" id="login_password_alert"></span>
								</div>
							</div>

							<div class="form-group">
								<label for="login_password_match" class="col-sm-1 control-label text-left"></label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="login_password_match" placeholder="Retype Password">
									<span style="color:#FF0000;" id="login_password_match_alert"></span>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-1 col-sm-10">
									<button type="button" onclick="submit_registration();" class="btn btn-lg btn-info btn-block">
										Sign up
									</button>
									
								</div>
							</div>
						</form>
					</div>
					<p>
						---------------------------------------
						<br/>
						Visit www.pharaohtools.com for more 
					</p>

				</div>
				<?php } ?>
			</div><!---->

			<!-- /.container -->

<script type="text/javascript" src="/index.php?control=AssetLoader&action=show&module=Signup&type=js&asset=signup.js"></script>
