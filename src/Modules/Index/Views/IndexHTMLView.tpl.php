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
					<a href="/index.php?control=Index&action=show" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
				</li>
				<li>
					<a href="/index.php?control=ApplicationConfigure&action=show">
                        <i class="fa fa-sitemap fa-fw"></i> Configure PTBuild<span class="fa arrow"></span>
                    </a>
					<ul class="nav nav-second-level collapse">
						<li>
							<a href="flot.html">New Pipeline</a>
						</li>
						<li>
							<a href="morris.html">Morris.js Charts</a>
						</li>
					</ul>
					<!-- /.nav-second-level -->
				</li>
				<li>
					<a href="/index.php?control=BuildConfigure&action=new"><i class="fa fa-table fa-fw"></i> New Pipeline</a>
				</li>
				<li>
					<a href="/index.php?control=BuildList&action=show"><i class="fa fa-edit fa-fw"></i> All Pipelines</a>
				</li>
				<li>
					<a href="/index.php?control=Monitors&action=DefaultHistory"><i class="fa fa-history fa-fw"></i> History<span class="fa arrow"></span></a>
				</li>
			</ul>
		</div>
	</div>

    <div class="col-md-9 col-sm-10" id="page-wrapper">
        <h4 class="text-uppercase text-light">Pharaoh Tools</h4>
        <div class="row clearfix no-margin">
            <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-database   fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">100</div>
                                        <div>All !</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-check-circle fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">50</div>
                                        <div>All sucess !</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-times-circle fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">20</div>
                                        <div>All Failed !</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-chain-broken fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">30</div>
                                        <div>All Unstable !</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <h3><a class="lg-anchor text-light" href=""> PTBuild - The Builder <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
            <p>
                Build and Monitoring Server in PHP.
                <br/>
                Create simple or complex build pipelines fully integrated with pharaoh tools
                <br/>
                Create monitoring application features in minutes.
                <br/>
                Using Convention over Configuration, a lot of common build tasks can be completed with little or
                no extra implementation work.
            </p>
        </div>
        <hr>
        <div class="row clearfix no-margin">
            <h3> Available Modules: <i style="font-size: 18px;" class="fa fa-chevron-right"></i></h3>
            <p>
                ---------------------------------------
            </p>
            <?php

            foreach ($pageVars["modulesInfo"] as $moduleInfo) {
                if ($moduleInfo["hidden"] != true) {
                    echo '<p>' . $moduleInfo["command"] . ' - ' . $moduleInfo["name"] . "</p>";
                }
            }
            ?>

            <p>
                ---------------------------------------
                <br/>
                Visit www.pharaohtools.com for more
            </p>
        </div>

    </div>

</div>