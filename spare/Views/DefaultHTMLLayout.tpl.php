<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="/index.php?control=AssetLoader&action=show&module=PostInput&type=image&asset=favicon.ico">
		
		<title>PTBuild - Pharaoh Tools</title>
		 
		

        <script src="/index.php?control=AssetLoader&action=show&module=PostInput&type=js&asset=jquery.min.js"></script>
        <script src="/index.php?control=AssetLoader&action=show&module=PostInput&type=js&asset=jquery-ui.min.js"></script>
        <script src="/index.php?control=AssetLoader&action=show&module=PostInput&type=js&asset=bootstrap.min.js"></script>
        
       <link href="Assets/Hover-master/css/hover.css" rel="stylesheet" media="all">
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">

		<!-- Bootstrap Core CSS -->
		<link href="/index.php?control=AssetLoader&action=show&module=PostInput&type=css&asset=bootstrap.min.css" rel="stylesheet">
		
		
		<!-- MetisMenu CSS -->
		<link href="/Assets/startbootstrap-sb-admin-2-1.0.5/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

		<!-- Timeline CSS -->
		<link href="/Assets/startbootstrap-sb-admin-2-1.0.5/dist/css/timeline.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="/Assets/startbootstrap-sb-admin-2-1.0.5/dist/css/sb-admin-2.css" rel="stylesheet">

		<!-- Morris Charts CSS -->
    	<link href="/Assets/startbootstrap-sb-admin-2-1.0.5/bower_components/morrisjs/morris.css" rel="stylesheet">
    
		<!-- Custom Fonts -->
		<link href="/Assets/startbootstrap-sb-admin-2-1.0.5/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

 		<!-- Metis Menu Plugin JavaScript -->
    	<script src="/Assets/startbootstrap-sb-admin-2-1.0.5/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    	<!-- Morris Charts JavaScript -->
    	<script src="/Assets/startbootstrap-sb-admin-2-1.0.5/bower_components/raphael/raphael-min.js"></script>
    	<script src="/Assets/startbootstrap-sb-admin-2-1.0.5/bower_components/morrisjs/morris.min.js"></script>	
    	
    	<!-- Custom Theme JavaScript -->
	    <script src="/Assets/startbootstrap-sb-admin-2-1.0.5/dist/js/sb-admin-2.js"></script>

    	<script src="/Assets/js/notification.js"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


		<![endif]-->
		<!--  sign up add -->
        <!-- Bootstrap Core CSS -->
        <link href="/index.php?control=AssetLoader&action=show&module=PostInput&type=css&asset=default.css" rel="stylesheet">

	</head>

	<body>
		<input type="hidden" id="base_url" value="<?php echo "" ; ?>">
<?php
   // @todo this doesn't seem right
   // @todo can we do HTML output with a blank template
	 ?>
		<div id="wrapper">
			<nav class="navbar navbar-default navbar-static-top navbar-fixed-top" role="navigation" style="background-color: #242424;  border-color:#242424;">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" style="color:#FFFFFF" coldata-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-" href="/index.php?control=Index&action=show">
						<figure class="rollover">
                        <img src="/index.php?control=AssetLoader&action=show&module=PostInput&type=image&asset=5.png" class="navbar-img hvr-grow-shadow" style="height: 60px;padding: 5px;" />
                        <span class="title hvr-grow-shadow">PTBuild</span>
                    </a>
				</div>
				
				
				<!-- /.navbar-header -->
				<ul class="nav navbar-top-links navbar-right">
					
                <?php 
                        if($pageVars["route"]["action"] != "registration" && $pageVars["route"]["action"] != "login") { ?>
                <li class="dropdown hvr-hang ">
                	
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    	
                        <i class="fa fa-bell fa-fw " id="bell"></i>  <i class="fa fa-caret-down " id="caret"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts hvr-grow-shadow" id="runningBuildsnotif">
                        <li>
                        	<a href="#">
                        		<div>
        							<span>No builds currently being executed...</span>
        						</div >
        					</a>
        				</li>
                     <!--   <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li> -->
                    </ul>
                </li>
               
                <!-- /.dropdown -->
                <li class="dropdown  hvr-hang">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw" id="bell"></i>  <i class="fa fa-caret-down" id="caret"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user ">
                        <li><a href="/index.php?control=UserManager&action=userprofile" class=" hvr-grow-shadow"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-grow-shadow"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li> 
                        <li><a href="/index.php?control=About&action=show" class=" hvr-grow-shadow"><i class="fa fa-help fa-fw"></i> About</a>
                        </li> 
                        <?php }
                        if($pageVars["route"]["action"] != "registration" && $pageVars["route"]["action"] != "ldaplogin" && $pageVars["route"]["action"] != "login") { ?>
                        <li class="divider"></li>
                        <li><a href="/index.php?control=Signup&action=logout" class=" hvr-grow-shadow"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li><?php } ?>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>   
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
	</body>
</html>
