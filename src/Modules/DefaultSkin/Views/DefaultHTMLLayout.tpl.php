<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="/Assets/Modules/DefaultSkin/image/favicon.ico">
		
		<title><?php echo ucfirst(PHARAOH_APP_FRIENDLY) ; ?> - Pharaoh Tools</title>


        <script src="/Assets/Modules/DefaultSkin/js/jquery-full.js"></script>
        <script src="/Assets/Modules/DefaultSkin/js/jquery-ui.min.js"></script>
        <script src="/Assets/Modules/DefaultSkin/js/bootstrap.min.js"></script>

        <link href="/Assets/Modules/DefaultSkin/Hover-master/css/hover.css" rel="stylesheet" media="all">
		<link href="/Assets/Modules/DefaultSkin/css/font-awesome.min.css" rel="stylesheet" media="all">

		<!-- Bootstrap Core CSS -->
		<link href="/Assets/Modules/DefaultSkin/css/bootstrap.min.css" rel="stylesheet">
		
		
		<!-- MetisMenu CSS -->
		<link href="/Assets/Modules/DefaultSkin/startbootstrap-sb-admin-2-1.0.5/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

		<!-- Timeline CSS -->
		<link href="/Assets/Modules/DefaultSkin/startbootstrap-sb-admin-2-1.0.5/dist/css/timeline.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="/Assets/Modules/DefaultSkin/startbootstrap-sb-admin-2-1.0.5/dist/css/sb-admin-2.css" rel="stylesheet">

		<!-- Morris Charts CSS -->
    	<link href="/Assets/Modules/DefaultSkin/startbootstrap-sb-admin-2-1.0.5/bower_components/morrisjs/morris.css" rel="stylesheet">
    
		<!-- Custom Fonts -->
		<link href="/Assets/Modules/DefaultSkin/startbootstrap-sb-admin-2-1.0.5/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

 		<!-- Metis Menu Plugin JavaScript -->
    	<script src="/Assets/Modules/DefaultSkin/startbootstrap-sb-admin-2-1.0.5/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    	<!-- Morris Charts JavaScript -->
    	<script src="/Assets/Modules/DefaultSkin/startbootstrap-sb-admin-2-1.0.5/bower_components/raphael/raphael-min.js"></script>
    	<script src="/Assets/Modules/DefaultSkin/startbootstrap-sb-admin-2-1.0.5/bower_components/morrisjs/morris.min.js"></script>
    	
    	<!-- Custom Theme JavaScript -->
	    <script src="/Assets/Modules/DefaultSkin/startbootstrap-sb-admin-2-1.0.5/dist/js/sb-admin-2.js"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="/Assets/Modules/DefaultSkin/js/html5shiv.min.js"></script>
		<script src="/Assets/Modules/DefaultSkin/js/respond.min.js"></script>

		<![endif]-->
		<!--  sign up add -->
        <!-- Bootstrap Core CSS -->
        <link href="/Assets/Modules/DefaultSkin/css/default.css" rel="stylesheet">
        <script type="text/javascript" src="/Assets/Modules/DefaultSkin/js/pharaoh_default.js"></script>
    </head>

	<body>
		<input type="hidden" id="base_url" value="">
<?php
   // @todo this doesn't seem right
   // @todo can we do HTML output with a blank template
	 ?>
			<nav class="navbar navbar-default navbar-static-top navbar-fixed-top" style="background-color: #242424;  border-color:#242424;">
				<div class="navbar-header">

                    <?php

                    if (isset($_SESSION) && $_SESSION["login-status"]==true) {

                    ?>

                    <!-- /.navbar-header -->
                    <ul class="nav navbar-top-links navbar-right">

                        <li class="dropdown hvr-hang ">

                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">

                                <i class="fa fa-bell fa-fw "></i>  <i class="fa fa-caret-down " ></i>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts hvr-grow-shadow ">
                                <li>
                                    <a href="#">
                                        <div >
                                            <i class="fa fa-comment fa-fw "></i> New Comment
                                            <span class="pull-right text-muted small"> 4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>

                                <li class="divider"></li>
                                <li>
                                    <a class="text-center" href="#">
                                        <strong>See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                            <!-- /.dropdown-alerts -->
                        </li>
                        <!-- /.dropdown -->
                        <li class="dropdown  hvr-hang">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user ">
                                <li><a href="/index.php?control=UserProfile&action=show" class=" hvr-grow-shadow"><i class="fa fa-user fa-fw"></i> User Profile</a>
                                </li>
                                <li><a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-grow-shadow"><i class="fa fa-gear fa-fw"></i> Settings</a>
                                </li>
                                <li><a href="/index.php?control=About&action=show" class=" hvr-grow-shadow"><i class="fa fa-help fa-fw"></i> About</a>
                                </li>
                                <?php
                                if($pageVars["route"]["action"] != "registration" && $pageVars["route"]["action"] != "login") { ?>
                                    <li class="divider"></li>
                                    <li><a href="/index.php?control=Signup&action=logout" class=" hvr-grow-shadow"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                                    </li><?php } ?>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <!-- /.dropdown -->
                    </ul>

                        <h3 class="nav navbar-top-links navbar-right title_username">
                            Hello, <strong><?php echo $_SESSION["username"] ; ?></strong>
                        </h3>

                    <?php } ?>

                    <a class="navbar-left" href="/index.php?control=Index&action=show">
						<figure class="rollover">
                            <img src="/Assets/Modules/DefaultSkin/image/<?php echo PHARAOH_APP_FRIENDLY ;?>-logo.png" class="navbar-img hvr-grow-shadow" alt="Pharaoh <?php echo ucfirst(PHARAOH_APP_FRIENDLY) ;?>" style="height: 60px;padding: 5px;" />
                            <span class="title hvr-grow-shadow">Pharaoh <?php echo ucfirst(PHARAOH_APP_FRIENDLY) ;?></span>
                        </figure>
                    </a>
				</div>
            <!-- /.navbar-top-links -->
			</nav>
			
			<?php echo $this -> renderMessages($pageVars); ?>
			<?php echo $templateData; ?>

			<!-- Bootstrap core JavaScript
			================================================== -->
			<!-- Placed at the end of the document so the pages load faster -->
	
			<div class="scroll-top-wrapper ">
                <span class="scroll-top-inner">
                    <i class="fa fa-2x fa-arrow-circle-up"></i>
                </span>
            </div>
            <script type="text/javascript" src="/Assets/Modules/DefaultSkin/js/bundle.js"></script>
	</body>
</html>
