<div class="container " id="wapper">
	<div class="row">

        <form class="form-horizontal custom-form" method="POST" action="javascript:submit_login();">

        <div class=" col-md-7 col-md-offset-2 ">

			<div class="login-panel panel panel-default">

				<div class="col-md-12">
					<h3 class="hero-unit"><strong>Log in</strong> </h3>

                    <?php echo $this->renderLogs() ; ?>

                    <!--<div class="pull-right">
                    switch to
                    <a href="http://www.pttrack.tld/index.php?control=UserAccount&action=registration"> OpenID log in</a>
                    </div> -->
					<hr>
				</div>

                <div class="panel-body">
					
					<div class="row clearfix no-margin">
						<h5 class="text-uppercase text-light" style="margin-top: 15px;">  </h5>
                        <div id="login_error_msg">

                            <?php

                                if(isset($pageVars["registration_disabled"]) && $pageVars["registration_disabled"]==true) {
                                    echo "Registration has disabled by your administrator." ;
                                }

                            ?>

                        </div>
                        <div id="login_success_msg"></div>
							<div class="form-group load_pending" >
                                <img src="/Assets/Modules/SourceHome/images/loading.gif">
                            </div>
							<div class="form-group load_hidden" >
								
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
								<div class="col-sm-offset-3 col-sm-4">
									<div >
									<label for="Signed in"><input name="Signed in" id="Signed in"  type="checkbox" style="color:#A2A1A1;"> Keep Me Signed in</label>
									</div>	
									<button type="submit" onclick="submit_login(); false;" class="load_hidden btn  btn-primary  btn-1 btn-1a hvr-grow-shadow" >
										Log in
									</button>
									
									</div>
									
									
									<div class="col-sm-offset-3 col-sm-12 ">
									<br />	
									<div>

                                        <?php
                                            if (isset($pageVars["data"]["settings"]["UserAccount"]["registration_enabled"]) && $pageVars["data"]["settings"]["UserAccount"]["registration_enabled"]=="on") {
                                        ?>
                                            <a href="/index.php?control=UserAccount&action=registration">  <b> Need an account ? Sign Up  </b> </a>
                                        <?php
                                            }
                                        ?>

                                    </div>
								</div>
							</div>
					           
								<div style="height: 1.5px; background-color: #eee; text-align: center">
</div>
                                
							    <div class="text-center ">

                                    <?php
//
//                                    var_dump($pageVars["data"]["settings"]["OAuth"]) ;

                                    if (isset($pageVars["data"]["settings"]["OAuth"]["oauth_enabled"]) && $pageVars["data"]["settings"]["OAuth"]["oauth_enabled"]=="on") {

                                        ?>

                                        <span style="background-color: white; position: relative; top: -0.7em;color:#337ab7"><b>or</b> </span>

                                        <?php

                                        if (isset($pageVars["data"]["settings"]["OAuth"]["github_enabled"]) && $pageVars["data"]["settings"]["OAuth"]["github_enabled"]=="on") {
                                            ?>
                                            <button onclick="return submit_login('github');" class="btn btn-github hvr-pop" title="Github"><i class="fa fa-github"></i> Github </button> |
                                        <?php
                                        }

                                        if (isset($pageVars["data"]["settings"]["OAuth"]["fb_enabled"]) && $pageVars["data"]["settings"]["OAuth"]["fb_enabled"]=="on") {
                                            ?>
                                            <a href="/index.php?control=OAuth&action=fblogin" class="btn btn-facebook hvr-pop" title="Facebook"><i class="fa fa-facebook"></i>  Facebook</a>  |
                                        <?php
                                        }

                                        if (isset($pageVars["data"]["settings"]["OAuth"]["li_enabled"]) && $pageVars["data"]["settings"]["OAuth"]["li_enabled"]=="on") {
                                            ?>
                                            <a href="/index.php?control=OAuth&action=linkedinlogin" class="btn btn-linkedin hvr-pop" title="LinkedIn"><i class="fa fa-linkedin"></i> linkedin</a> |
                                        <?php
                                        }

                                        if (isset($pageVars["data"]["settings"]["LDAP"]["ldap_enabled"]) && $pageVars["data"]["settings"]["LDAP"]["ldap_enabled"]=="on") {
                                            ?>

<!--                                            <div class="form-group">-->
<!--                                                <div class="col-sm-offset-1 col-sm-10">-->
<!--                                                    <button type="button" onclick="submit_ldap();" class="btn btn-lg btn-info btn-block">-->
<!--                                                        Login-->
<!--                                                    </button>-->
<!---->
<!--                                                </div>-->
<!--                                            </div>-->

                                            <a href="/index.php?control=ldap&action=ldaplogin" onclick="show_ldap_login_form();" class="btn btn-social-icon hvr-pop" title="LDAP">LDAP</a>
                                        <?php
                                        }
                                    }

                                    ?>

                                </div>


                                <?php
                                    if (!isset($pageVars["data"]["settings"]["PublicScope"]["disable_public"]) ||
                                        (isset($pageVars["data"]["settings"]["PublicScope"]["disable_public"]) &&
                                        $pageVars["data"]["settings"]["PublicScope"]["disable_public"] != "on")) {
                                ?>
                                    <div id="public_links" class="public_links">
                                        <?php
                                            $pl = \Model\RegistryStore::getValue('public_links') ;
                                            echo $pl ;
                                        ?>
                                    </div>
                                <?php
                                    }
                                ?>

                    </div>
					</div>
					
					<p class="text-center" style="color:#337ab7">
						---------------------------------------
						<br/>
						Visit www.pharaohtools.com for more
					</p>

				</div>

            </div>
        </form>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/Assets/Modules/UserAccount/css/signup.css">
<script type="text/javascript" src="/Assets/Modules/UserAccount/js/signup.js"></script>
