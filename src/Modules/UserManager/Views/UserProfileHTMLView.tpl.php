<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav in" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form hvr-bounce-in">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li>
                    <a href="/index.php?control=Index&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-dashboard hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-cogs fa-fw hvr-bounce-in"></i> Configure PTBuild</a>
                </li>
                <li>
                    <a href="/index.php?control=UserManager&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-group hvr-bounce-in"></i> User Manager
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ModuleManager&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-suitcase hvr-bounce-in"></i> Module Manager
                    </a>
                </li>
            </ul>
        </div>
    </div>

  <div class="col-lg-9">
     <div class="well well-lg">
        <h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools</a></h2>
        <hr>
        <div class="row clearfix no-margin">
				 
    <div class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav ">
                    <li><a href="#"></a></li>
                    <li><a href="#"></a></li>
                    <li><a href="#"></a></li>
                    <li><a href="#"></a></li>
                </ul>
            </div>

        </div>
    </div>
    <!-- NAVBAR CODE END -->


    <div class="well-lg col-md-12 alert-info">
                <div class="form-group col-md-5 alert-primary">
                    <h3 class="text-primary">Profile</h3>
                    <hr>
                    <h4 class="text-primary">User name :
                    <strong class="text-danger"><?php foreach($pageVars as $key => $value ) { echo $value->username; }?></strong></h4>
					<h4 class="text-primary">User email :
                    <strong class="text-danger"><?php foreach($pageVars as $key => $value ) { echo $value->email; }?></strong></h4>
                    <h4 class="text-primary">User Role &nbsp;:
                    <strong class="text-danger"><?php 
						foreach($pageVars as $key => $value ) { 
							if($value->role == 1){ 
								echo "Admin";
								}
							if($value->role == 2){ 
								echo "Builder";
								}
							if($value->role == 3){ 
								echo "Viewer";
								} 
							}?></strong></h4>
                    <!-- a href="#" class="btn btn-success">Update Details</a -->
                </div>
					<form class="form-horizontal custom-form">
                    <div class="form-group col-md-5 alert-primary">
                        <h3>Change Password</h3>
                        <h6 id="form_alert"></h6>
                        <hr>
                        <label>Enter Old Password</label>
                        <input type="password" class="form-control" id="old_password" name="old_password">
                        <p style="color: #7CFC00;" id="old_password_alert"></p>
                        <label>Enter New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                        <p style="color: #7CFC00;" id="new_password_alert"></p>
                        <label>Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_match" name="new_password_match">
                        <p style="color: #7CFC00;" id="new_password_match_alert"></p>
                        <p style="color: #7CFC00;" id="password_match_error"></p>
                        <br/>
                        <button type="button" onclick="changePassword();" class="btn  btn-primary hvr-grow-shadow">Change Password</button>
                    </div>
                    </form>
				</div>
		
		<hr>
                <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>
	  </div>
   </div>
</div> 
</div><!-- container -->
<link rel="stylesheet" href="/index.php?control=AssetLoader&action=show&module=UserManager&type=css&asset=usermanager.css">
<script type="text/javascript" src="/index.php?control=AssetLoader&action=show&module=UserManager&type=js&asset=userprofile.js"></script>
