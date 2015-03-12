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

		<!-- Bootstrap Core CSS -->
		<link href="/index.php?control=AssetLoader&action=show&module=PostInput&type=css&asset=bootstrap.min.css" rel="stylesheet">

		<!-- MetisMenu CSS -->
		<link href="/Assets/startbootstrap-sb-admin-2-1.0.5/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

		<!-- Timeline CSS -->
		<link href="/Assets/startbootstrap-sb-admin-2-1.0.5/dist/css/timeline.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="/Assets/startbootstrap-sb-admin-2-1.0.5/dist/css/sb-admin-2.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="/Assets/startbootstrap-sb-admin-2-1.0.5/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- Metis Menu Plugin JavaScript -->
		<script src="/Assets/startbootstrap-sb-admin-2-1.0.5/bower_components/metisMenu/dist/metisMenu.min.js"></script>

		<!-- Custom Theme JavaScript 
		<script src="/Assets/startbootstrap-sb-admin-2-1.0.5/dist/js/sb-admin-2.js"></script>-->

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

		<![endif]-->
		<!--  sign up add -->
        <!-- Bootstrap Core CSS -->
        <link href="/index.php?control=AssetLoader&action=show&module=PostInput&type=css&asset=default.css" rel="stylesheet">

	</head>

	<body>
		<input type="hidden" id="base_url" value="http://www.ptbuild.tld">
<?php
	if($pageVars["route"]["action"] != "registration" && $pageVars["route"]["action"] != "login") { ?>
		<div id="wrapper">
			<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-top: -70px">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-" href="/index.php?control=Index&action=show">
                        <img src="/index.php?control=AssetLoader&action=show&module=PostInput&type=image&asset=5.png" class="navbar-img" style="height: 60px;padding: 5px" /><b>PTBuild</b>
                    </a>
				</div>
				<!-- /.navbar-header -->

				<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
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
                    <!-- /.dropdown-alerts --
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/index.php?control=Signup&action=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>   
            <!-- /.navbar-top-links -->
			</nav>
<?php } ?>
			<?php echo $this -> renderMessages($pageVars); ?>
			<?php echo $templateData; ?>

			<!-- Bootstrap core JavaScript
			================================================== -->
			<!-- Placed at the end of the document so the pages load faster -->
			<script>
				$(function() {
					$('#slide-submenu').on('click', function() {
						$(this).closest('.list-group').fadeOut('slide', function() {
							$('.mini-submenu').fadeIn();
						});
					});

					$('.mini-submenu').on('click', function() {
						$(this).next('.list-group').toggle('slide');
						$('.mini-submenu').hide();
					});

					$.ajax({
						type : 'POST',
						url : $('#base_url').val() + '/index.php?control=Signup&action=login-status',
						data : {
							url : document.URL
						},
						dataType : "json",
						success : function(result) {
							if (result.status == false) {
								window.location.assign($('#base_url').val() + '/index.php?control=Signup&action=login');
							}
						}
					});
				})

			</script>
	</body>
</html>
