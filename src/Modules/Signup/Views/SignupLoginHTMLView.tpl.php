<div class="container " id="wapper">
	<div class="row">
		
		<div class=" col-md-7 col-md-offset-2 ">
			<div class="login-panel panel panel-default">
				<div class="col-md-12">
					<h3 class="hero-unit"><strong>Log in</strong> </h3>
					
									<p class="text-right "><a href="/index.php?control=Signup&action=registration">  <b> Need an account ? Sign Up  </b> </a> </p>
									
					<!--<div class="pull-right">
					switch to
					<a href="http://www.ptbuild.tld/index.php?control=Signup&action=registration"> OpenID log in</a>
					</div> -->
					<hr>
				</div>
				
				
				
            <div class="panel-body">
					
					<div class="row clearfix no-margin">
						<h5 class="text-uppercase text-light" style="margin-top: 15px;">  </h5>
						<p style="color: #ff6312; margin-left: 46px;" id="login_error_msg"></p>
						<form class="form-horizontal custom-form">
							<div class="form-group" >
								
								<label for="inputEmail3" class="col-sm-3 control-label text-left" style="color:#757575;">User Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control " id="login_username" placeholder="User Name">
									<span style="color:#FF0000;" id="login_username_alert"></span>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-3 control-label text-left" style="color:#757575;">Password</label>
								<div class="col-sm-8">
									<input type="password" class="form-control " id="login_password" placeholder="Password">
									<span style="color:#FF0000;" id="login_password_alert"></span>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
										
									<button type="button" onclick="submit_login();"  class="btn  btn-primary  btn-1 btn-1a hvr-grow-shadow" >
										Log in
									</button>
									<label  style="color:#337ab7;   margin-left: 145px;;" for="Signed in "><input name="Signed in" id="Signed in"  type="checkbox" > Keep Me Signed in</label>
								    </div>
									
									
									<div class="col-sm-offset-3 col-sm-12 ">
									<br />	
									
								</div>
							</div>
					           
								<div style="height: 1.5px; background-color: #eee; text-align: center">
  <span style="background-color: white; position: relative; top: -0.7em;color:#337ab7"><b>or</b>
   
  </span>
</div>
                                
							    <div class="text-center ">
							    <a href="/index.php?control=OAuth&action=googlelogin" class="btn btn-google hvr-pop" title="Google"><i class="fa fa-google"></i> Google </a> |
								<a href="/index.php?control=OAuth&action=githublogin" class="btn btn-github hvr-pop" title="Github"><i class="fa fa-github"></i> Github </a> | 
								<a href="/index.php?control=OAuth&action=fblogin" class="btn btn-facebook hvr-pop" title="Facebook"><i class="fa fa-facebook"></i>  Facebook</a>  |
								<a href="/index.php?control=OAuth&action=linkedinlogin" class="btn btn-linkedin hvr-pop" title="LinkedIn"><i class="fa fa-linkedin"></i> linkedin</a> |
                                <a href="/index.php?control=ldap&action=ldaplogin" class="btn btn-social-icon hvr-pop" title="LDAP">LDAP</a>

                                </div>
                                
							</div>
						</form>
					</div>
					
					<p class="text-center" style="color:#337ab7">
						---------------------------------------
						<br/>
						Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
					</p>

				</div>

            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Palatino Linotype">

<script type="text/javascript" src="/index.php?control=AssetLoader&action=show&module=Signup&type=js&asset=signup.js"></script>
