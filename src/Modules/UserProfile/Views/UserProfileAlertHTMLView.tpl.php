<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav ">
            <div class="sidebar-search">
                <button class="btn btn-success" id="menu_visibility_label" type="button">
                    Show Menu
                </button>
                <i class="fa fa-1x fa-toggle-off hvr-grow" id="menu_visibility_switch"></i>
            </div>
            <ul class="nav in" id="side-menu">
                <li>
                    <a href="/index.php?control=Index&action=show" class="hvr-bounce-in">
                        <i class="fa fa-dashboard hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-cogs fa-fw"></i> Configure PT<?php echo ucfirst(PHARAOH_APP)  ; ?><span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-curl-bottom-right">Application</a>
                        </li>
                        <li>
                            <a href="/index.php?control=UserManager&action=show" class=" hvr-curl-bottom-right">User Manager</a>
                        </li>
                        <li>
                            <a href="/index.php?control=UserProfile&action=show" class=" hvr-curl-bottom-right">User Profile</a>
                        </li>
                        <li>
                            <a href="/index.php?control=ModuleManager&action=show" class=" hvr-curl-bottom-right">Modules</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="/index.php?control=ModuleManager&action=show" class="hvr-bounce-in">
                        <i class="fa fa-suitcase hvr-bounce-in"></i> Module Manager
                    </a>
                </li>
            </ul>
        </div>
    </div>

   <div class="col-lg-12">
     <div class="well well-lg">
<!--        <h2 class="text-uppercase text-light"><a href="/"> PTTrack - Pharaoh Tools</a></h2>-->
		<div class="row clearfix no-margin">
			<h4 class="alert alert-warning">You don't have permission to access this page</h4>
     	<p>
            ---------------------------------------<br/>
            Visit www.pharaohtools.com for more
        </p>
		</div>
	  </div>
	</div>
</div><!-- container -->
<link rel="stylesheet" href="/index.php?control=AssetLoader&action=show&user=UserProfile&type=css&asset=usermanager.css">
