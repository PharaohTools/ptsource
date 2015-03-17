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
                        <i class="fa fa-cogs fa-fw"></i> Configure PTBuild</a>
					<!-- /.nav-second-level -->
				</li>
				<li>
					<a href="/index.php?control=BuildConfigure&action=new"><i class="fa fa-edit fa-fw"></i> New Pipeline</a>
				</li>
				<li>
					<a href="/index.php?control=BuildList&action=show"><i class="fa fa-bars fa-fw"></i> All Pipelines</a>
				</li>
				<li>
					<a href="/index.php?control=Monitors&action=DefaultHistory"><i class="fa fa-history fa-fw"></i> History</a>
				</li>
			</ul>
		</div>
	</div>
    <div class="col-lg-9">
                    <div class="well well-lg"> 
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
                                        <div class="huge"><?php echo $pageVars['pipesDetail']['total']; ?></div>
                                        <div>All!</div>
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
                                        <div class="huge"><?php echo $pageVars['pipesDetail']['success']; ?></div>
                                        <div>All sucess!</div>
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
                                        <div class="huge"><?php echo $pageVars['pipesDetail']['fail']; ?></div>
                                        <div>All Failed!</div>
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
                                        <div class="huge"><?php echo $pageVars['pipesDetail']['unstable']; ?></div>
                                        <div>All Unstable!</div>
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
                <?php
                $graphData = array();
				$success = $fail = $running = 0;
                foreach ($pageVars['pipesDetail']['buildHistory']['history'] as $key => $value) {
                	if(date('m', $value->start) == date('m', time())) {
                		$old_start = $value->start;
                		if(date('m', $value->start) == date('m', $old_start)) {
                			if (isset($value->status)) 
                				if ($value->status == 'SUCCESS') 
									$success++ ; 
								if ($value->status == 'FAIL') 
									$fail++ ;
							else
								$running++ ;
                		}
						else {
							$success = $fail = $running = 0;
                			if (isset($value->status)) 
                				if ($value->status == 'success') 
									$success++ ; 
								if ($value->status == 'fail') 
									$fail++ ;
							else
								$running++ ;
						}
						$graphData[date("j", $value->start)] = array( 'success' => $success, 'fail' => $fail, 'running' => $running );
					}
				}
				foreach ($graphData as $key => $value) {
					$data[] = array( 'period'  => $key,
									 'success' => $value['success'],
									 'fail'	=> $value['fail'],
									 'runnung' => $value['running']
									);
				}
                ?>
                <div class="row">
	                <div class="col-lg-12">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <i class="fa fa-bar-chart-o fa-fw"></i> All Pipes Build Status
	                            <div class="pull-right">
	                                <!--<div class="btn-group">
	                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
	                                        Actions
	                                        <span class="caret"></span>
	                                    </button>
	                                    <ul class="dropdown-menu pull-right" role="menu">
	                                        <li><a href="#">Action</a>
	                                        </li>
	                                        <li><a href="#">Another action</a>
	                                        </li>
	                                        <li><a href="#">Something else here</a>
	                                        </li>
	                                        <li class="divider"></li>
	                                        <li><a href="#">Separated link</a>
	                                        </li>
	                                    </ul>
	                                </div>-->
	                            </div>
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class="panel-body">
	                            <div id="pipes-build-chart"></div>
	                        </div>
	                        <!-- /.panel-body -->	                    
	                	</div>
	                </div>             
            </div>    
			<script>
				$(function() {
				    Morris.Area({
				        element: 'pipes-build-chart',
				        data: <?php echo json_encode($data); ?>,
				        xkey: 'period',
				        ykeys: ['success', 'fail', 'running'],
				        labels: ['Success', 'Failed', 'Running'],
				        pointSize: 2,
				        hideHover: 'auto',
				        resize: true
				    });
				
				});
			</script>

			<div class="col-lg-14">
                    <div class="well well-lg">
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
                </div>
               </div>

        </div>

        <hr>
        <div class="col-lg-13">
                    <div class="well well-lg">
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
