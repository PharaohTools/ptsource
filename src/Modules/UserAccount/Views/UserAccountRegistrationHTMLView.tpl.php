<script type="text/javascript" src="/Assets/Modules/UserAccount/js/registration.js"></script>
<div class="container" id="wapper">
	<div class="row">
        <div class=" col-md-7 col-md-offset-2 ">
			<div class="login-panel panel panel-default">
				<div class="col-md-12">
                <h3 class="hero-unit"><strong>Sign Up</strong> </h3>

                    <?php echo $this->renderLogs() ; ?>

                    <hr>
				</div> 
				
					
				<div class="row clearfix no-margin">
                    <h5 class="text-uppercase text-light" style="margin-top: 15px;margin-left: 51px;">  </h5>
                    <p style="color: #7CFC00; margin-left: 100px;" id="registration_error_msg"></p>
                    <form class="form-horizontal custom-form">
                        <div class="form-group">
                            <label for="login_username" class="col-sm-4 control-label text-left" style="color:#757575">User Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="login_username" name="login_username" placeholder="User Name">
                                <span style="color:#FF0000;" id="login_username_alert"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="login_email" class="col-sm-4 control-label text-left" style="color:#757575">Email</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="login_email" name="login_email" placeholder=" Email">
                                <span style="color:#FF0000;" id="login_email_alert"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="login_password" class="col-sm-4 control-label text-left" style="color:#757575">Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Password">
                                <span style="color:#FF0000;" id="login_password_alert"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="login_password_match" class="col-sm-4 control-label text-left" style="color:#757575;" >Retype Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" id="login_password_match" name="login_password_match" placeholder="Retype Password">
                                <span style="color:#FF0000;" id="login_password_match_alert"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-3">
                                <button type="button" onclick="subReg();" class="btn  btn-primary hvr-grow-shadow">
                                  Sign up
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
                <div style="height: 1.5px; background-color: #eee; text-align: center">
  <span style="background-color: white; position: relative; top: -0.7em;color:#337ab7">
  </div>
                <p class="text-center" style="color:#337ab7">
						---------------------------------------
						<br/>
						Visit www.pharaohtools.com for more
					</p>
            </div>
        </div>
    </div>
</div>

