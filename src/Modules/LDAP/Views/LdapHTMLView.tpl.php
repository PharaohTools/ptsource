<div class="container" id="wapper">
	<div class="row">
      
   <?php 
					if($pageVars["route"]["action"] == "ldaplogin"){
						
				?>
				
				<div class="col-md-4 col-md-offset-4 clearfix main-container signup-position">
					<div class="login-panel panel panel-default" style="margin-top: 40px">
				<div class="panel-heading">
					<h3 class="panel-title"><center><b>LDAP</b></center> </h3> 
				</div>
<!--					<h4 class="text-uppercase text-light"><a href="/"> <center>PTBuild - Pharaoh Tools <center></a></h4>-->
					<a href="#"><img src="/Assets/Modules/DefaultSkin/image/5.png" class="navbar-img" style="height: 50px;margin-left: auto;margin-right: auto;display: block" /></a>
					<div class="row clearfix no-margin">
						<h5 class="text-uppercase text-light" style="margin-top: 15px;margin-left: 51px;">  </h5> 
						<p style="color: #6DA900; margin-left: 100px;" id="login_error_msg"></p> 
						<form class="form-horizontal custom-form">
							<div class="form-group">
								<label for="login_servername" class="col-sm-1 control-label text-left"></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="login_servername" placeholder="Server Name">
									<span style="color:#FF0000;" id="login_servername_alert"></span>
								</div>
							</div>
							<div class="form-group">
								<label for="login_dn" class="col-sm-1 control-label text-left"></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="login_dn" placeholder="Login DN">
									<span style="color:#FF0000;" id="login_dn_alert"></span>
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
								<div class="col-sm-offset-1 col-sm-10">
									<button type="button" onclick="submit_ldap();" class="btn btn-lg btn-info btn-block">
										Login
									</button>
									
								</div>
							</div>
						</form>
					</div>
					  <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>

				</div>
				<?php } ?>


    </div><!---->

<!-- /.container -->
<script type="text/javascript" src="/Assets/Modules/LDAP/js/ldap.js"></script>
