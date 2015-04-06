<link href="styles/ihover.css" rel="stylesheet">
<div class="container" id="wrapper">

	<div class="navbar-default col-sm-2 sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
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
					<a href="/index.php?control=Index&action=show" class="active hvr-bounce-in" ><i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard</a>
				</li>
				<li>
					<a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-cogs fa-fw"></i> Configure PTBuild<span class="fa arrow"></span>
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
					<a href="/index.php?control=BuildConfigure&action=new" class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> New Pipeline</a>
				</li>
				<li>
					<a href="/index.php?control=BuildList&action=show" class=" hvr-bounce-in"><i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Pipelines</a>
				</li>
				<li>
					<a href="/index.php?control=Monitors&action=DefaultHistory" class=" hvr-bounce-in"><i class="fa fa-history fa-fw hvr-bounce-in"></i> History</a>
				</li>
			</ul>
		</div>
	</div>
    <div class="col-lg-9">
                    <div class="well well-lg">
        <div class="row clearfix no-margin">
            <div class="row">
            	 
                    <div class="col-lg-3 col-md-4 hvr-pop">
                    	
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-database   fa-4x hvr-buzz-out"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge hvr-grow-rotate" ><?php echo $pageVars['pipesDetail']['total']; ?></div>
                                        <div>All!</div>
                                    </div>
                                </div>
                            </div>
                           <!-- <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>-->
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 hvr-pop">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-check-circle fa-4x hvr-buzz-out"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge  hvr-grow-rotate"><?php echo $pageVars['pipesDetail']['success']; ?></div>
                                        <div>All sucess!</div>
                                    </div>
                                </div>
                            </div>
                        <!--    <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>-->
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 hvr-pop">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-times-circle fa-4x hvr-buzz-out"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge  hvr-grow-rotate"><?php echo $pageVars['pipesDetail']['fail']; ?></div>
                                        <div>All Failed!</div>
                                    </div>
                                </div>
                            </div>
                         <!--   <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>-->
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 hvr-pop">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-chain-broken fa-4x hvr-buzz-out"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge hvr-grow-rotate"><?php echo $pageVars['pipesDetail']['unstable']; ?></div>
                                        <div>All Unstable!</div>
                                    </div>
                                </div>
                            </div>
                          <!--  <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>-->
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                $graphData = array();
                foreach ($pageVars['pipesDetail']['buildHistory'] as $key => $value) {
					$day = date('j', $value->start);
                	if(date('m', $value->start) == date('m', time())) {
                		if (in_array($day, array_keys($graphData))) { 
                			if (isset($value->status)) {
                				if ($value->status == 'SUCCESS')
									$graphData[$day]['success']++;
								if ($value->status == 'FAIL')
									$graphData[$day]['fail']++;
							}
							else
								$graphData[$day]['unstable']++;
                		} else {
							if (isset($value->status)) 
                				if ($value->status == 'SUCCESS') 
									$graphData[$day] = array( 'success' => 1, 'fail' => 0, 'unstable' => 0 ); 
								if ($value->status == 'FAIL') 
									$graphData[$day] = array( 'success' => 0, 'fail' => 1, 'unstable' => 0 );
							else
								$graphData[$day] = array( 'success' => 0, 'fail' => 0, 'unstable' => 1);
						}
					}
				}
				foreach ($graphData as $key => $value) {
					$data[] = array( 'day'  => $key,
									 'success' => $value['success'],
									 'fail'	=> $value['fail'],
									 'unstable' => $value['unstable']
									);
				} ?>
				
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
				        xkey: 'day',
				        ykeys: ['success', 'fail', 'unstable'],
				        labels: ['Success', 'Failed', 'Unstable'],
				        xLabelFormat: ['day'],
				        pointSize: 1,
				        lineColors: ['#d9534f','#5cb85c','#F0AD4E'],
				        hideHover: 'auto',
				        resize: true
				    });
				
				});
			</script>
				        

               </div>

        </div>

        <hr>
        <div class="col-lg-13">
                    <div class="well well-lg ">
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

            
                <hr>
                <p class="text-center">
                Visit www.pharaohtools.com for more
            </p>
        </div>

    </div>

</div>
