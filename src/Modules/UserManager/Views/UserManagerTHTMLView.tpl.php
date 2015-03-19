<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav in" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
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
                    <a href="/index.php?control=Index&action=show">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ApplicationConfigure&action=show">
                        <i class="fa fa-cogs fa-fw"></i> Configure PTBuild</a>
                </li>
                <li>
                    <a href="/index.php?control=UserManager&action=show">
                        <i class="fa fa-user"></i> User Manager
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ModuleManager&action=show">
                        <i class="fa fa-suitcase"></i> Module Manager
                    </a>
                </li>
            </ul>
        </div>
    </div>

<?php      
	$i = 1;   
	foreach ($pageVars["userdata"] as $userdetails) { ?>
	<div class="well col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
        <div class="row user-row">	
            <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                <img class="img-circle"
                     src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                     alt="User Pic">
            </div>
            <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">					
                <strong><?php echo $userdetails->username; ?></strong><br>
                <span class="text-muted">User level: <?php 
							if($userdetails->role==1){
							echo '<b><p class="text-primary">Admin</p></b>'; }
							if($userdetails->role==2){
							echo '<b><p class="text-success">Builder</p></b>'; }
							if($userdetails->role==3){
							echo '<b><p class="text-warning">Viewer</p></b>'; } ?>
				</span>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".cyruxx">
                <i class="glyphicon glyphicon-chevron-down text-muted"></i>
            </div>
        </div>
        <div class="row user-infos cyruxx">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">User information</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                                <img class="img-circle"
                                     src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100"
                                     alt="User Pic">
                            </div>
                            <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                                <img class="img-circle"
                                     src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                                     alt="User Pic">
                            </div>
                            <div class="col-xs-10 col-sm-10 hidden-md hidden-lg">
								<strong><?php echo $userdetails->username; ?></strong><br>
                                <dl>
                                    <dt>User level:</dt>
                                    <dd><?php 
							if($userdetails->role==1){
							echo '<b><p class="text-primary">Admin</p></b>'; }
							if($userdetails->role==2){
							echo '<b><p class="text-success">Builder</p></b>'; }
							if($userdetails->role==3){
							echo '<b><p class="text-warning">Viewer</p></b>'; } ?>
									</dd>
                                    <dt>Registered since:</dt>
                                    <dd>11/12/2013</dd>
                                    <dt>Topics</dt>
                                    <dd>15</dd>
                                    <dt>Warnings</dt>
                                    <dd>0</dd>
                                </dl>
                            </div>
                            <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                                <strong><?php echo $userdetails->username; ?></strong><br>
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>User level:</td>
                                        <td>Administrator</td>
                                    </tr>
                                    <tr>
                                        <td>Registered since:</td>
                                        <td>11/12/2013</td>
                                    </tr>
                                    <tr>
                                        <td>Topics</td>
                                        <td>15</td>
                                    </tr>
                                    <tr>
                                        <td>Warnings</td>
                                        <td>0</td>
                                    </tr>
                                    </tbody>
                                </table>         
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-sm btn-primary" type="button"
                                data-toggle="tooltip"
                                data-original-title="Send message to user"><i class="glyphicon glyphicon-envelope"></i></button>
                        <span class="pull-right">
                            <button class="btn btn-sm btn-warning" type="button"
                                    data-toggle="tooltip"
                                    data-original-title="Edit this user"><i class="glyphicon glyphicon-edit"></i></button>
                            <button class="btn btn-sm btn-danger" type="button"
                                    data-toggle="tooltip"
                                    data-original-title="Remove this user"><i class="glyphicon glyphicon-remove"></i></button>
                        </span>
                    </div>
                </div>
</div>
</div> 
</div><?php $i++; } ?>




               

 
</div><!-- container -->

<link rel="stylesheet" type="text/css" href="/index.php?control=AssetLoader&action=show&module=UserManager&type=css&asset=usermanager.css">
<script type="text/javascript" src="/index.php?control=AssetLoader&action=show&module=UserManager&type=js&asset=usermanager.js"></script>
