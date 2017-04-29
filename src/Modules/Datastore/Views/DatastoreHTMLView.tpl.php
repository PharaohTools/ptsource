<div class="container" id="wrapper">

    <div class="navbar-default col-sm-2 sidebar" role="navigation">
            <div class="sidebar-nav ">
                <ul class="nav in" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form hvr-bounce-in">
                            <input type="text" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">
                                <i class="fa fa-search hvr-"></i>
                            </button>
                        </span>
                        </div>
                        <!-- /input-group -->
                    </li>

                    <li>

                        <a href="/index.php?control=Datastore&action=index" class="active hvr-bounce-in">
                            <i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in">
                            <i class="fa fa-cogs fa-fw"></i> Configure <?= ucfirst(PHARAOH_APP_FRIENDLY) ?><span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-curl-bottom-right">Application</a>
                            </li>
                            <li>
                                <a href="/index.php?control=UserManager&action=show" class=" hvr-curl-bottom-right">Users</a>
                            </li>
                            <li>
                                <a href="/index.php?control=ModuleManager&action=show" class=" hvr-curl-bottom-right">Modules</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="/index.php?control=VirtualizeConfigure&action=new" class=" hvr-bounce-in">
                            <i class="fa fa-edit fa-fw hvr-bounce-in fa-user"></i> New Virtualize
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=VirtualizeList&action=show" class=" hvr-bounce-in">
                            <i class="fa fa-edit fa-fw hvr-bounce-in fa-user"></i> All Virtualizes
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=Monitors&action=DefaultHistory" class=" hvr-bounce-in">
                            <i class="fa fa-edit fa-fw hvr-bounce-in fa-bar-chart-o"></i> History
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-12">

        <?php echo $this->renderLogs() ; ?>

            <h4 class="text-uppercase text-light">Pharaoh Tools</h4>
            <div class="row clearfix no-margin">
                <h3>
                    <a class="lg-anchor text-light" href="">
                        PTManage - The Creator <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                    <p> Enterprise DevOps Orchestration in PHP <br/>
                    Create and control anything DevOps - Development Environments, Applications, Infrastructure Management,
                    Software and Operating Systems, Configurations, Deployments, Virtualizes, Virtualizes and Monitoring.
                    <br/> Using Convention over Configuration, prototype anything in minutes, go to production smoothly
                    and solidly, and manage your entire Infrastructure. </p>
            </div>
            <hr>
            <div class="row clearfix no-margin">
                <h3> Available Modules: <i style="font-size: 18px;" class="fa fa-chevron-right"></i></h3>
                <p> --------------------------------------- </p>
                <?php

                foreach ($pageVars["modulesInfo"] as $moduleInfo) {
                    if ($moduleInfo["hidden"] != true) {
                        echo '<p>'.$moduleInfo["command"].' - '.$moduleInfo["name"]."</p>";
                    }
                }

                ?>

                <p>
                    ---------------------------------------<br/>
                    Visit www.pharaohtools.com for more
                </p>
            </div>

        </div>

    </div>
</div><!-- /.container -->