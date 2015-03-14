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
					 </li>
                <li>
                    <a href="/index.php?control=Index&amp;action=show">
                        <i class="fa fa-comment-o"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=BuildList&amp;action=show">
                        <i class="fa fa-user"></i> All Pipelines
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildConfigure&action=show&item=<?php echo $pageVars["data"]["item"] ; ?>">
                        <i class="fa fa-user"></i> Configure
                    </a>
                </li>
                
                <li>
                    <a href="index.php?control=Workspace&action=show&item=<?php echo $pageVars["data"]["item"] ; ?>">
                        <i class="fa fa-folder-open-o"></i> Workspace
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildMonitor&action=show&item=<?php echo $pageVars["data"]["item"] ; ?>">
                        <i class="fa fa-bar-chart-o"></i> Monitors
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildHome&action=changes&item=<?php echo $pageVars["data"]["item"] ; ?>">
                        <i class="fa fa-bar-chart-o"></i> Changes
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildHome&action=history&item=<?php echo $pageVars["data"]["item"] ; ?>">
                        <i class="fa fa-bar-chart-o"></i> History <span class="badge"></span>
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildHome&action=delete&item=<?php echo $pageVars["data"]["item"] ; ?>">
                        <i class="fa fa-envelope"></i> Delete
                    </a>
                </li>
                <li>
                    <a href="index.php?control=PipeRunner&action=start&item=<?php echo $pageVars["data"]["item"] ; ?>">
                        <i class="fa fa-envelope"></i> Run Now
                    </a>
                </li>
            </ul>
        </div>
       </div>
    
       <div class="col-md-9 col-sm-10" id="page-wrapper">
       <h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools</a></h2>

            <div class="row clearfix no-margin">
                <!--<h4 class="text-uppercase text-light">Chart For <?php echo $pageVars['data']["item"]; ?></h4>-->
                <h3><a class="lg-anchor text-light" href="/index.php?control=BuildList&action=show">Chart For <?php echo $pageVars['data']["item"]; ?> <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                
                <span class="foo" style="background-color:#00ff00;"></span>Success<br />
				<span class="foo" style="background-color:#ff0000;"></span>Fail<br />
				<span class="foo" style="background-color:#0000ff;"></span>Running<br />
				<style>
					.foo {
						float:left;   
					    width: 20px;
					    height: 20px;
					    margin: 5px;
					    border-width: 1px;
					    border-style: solid;
					    border-color: rgba(0,0,0,.2);
					}
				</style>
                <script src="Assets/BuildMonitor/js/Chart.js"></script>
                <div id="canvas-holder">
					<canvas id="chart-area" width="300" height="300"/>
				</div>
				<div class="col-sm-8 col-md-9">
					<canvas id="canvas" height="450" width="600"></canvas>
				</div>
				<?php
				$success = $fail = $running = $date = array();
				foreach ( $pageVars['data']["history"] as $value) {
					if (isset($value->status)) {
						if ($value->status == "SUCCESS")
							array_push($success, $value->end-$value->start);
						else
							array_push($success, 0);
						if ($value->status == "FAIL")
							array_push($fail, $value->end-$value->start);
						else
							array_push($fail, 0);
					}
					array_push($date, date("m/d/y", $value->start));
				}?>
				<script>
					var pieData = [
							{
								value: <?php echo $pageVars['data']['success']; ?>,
								color:"#00FF00",
								highlight: "#00EE00",
								label: "Success"
							},
							{
								value: <?php echo $pageVars['data']['fail']; ?>,
								color: "#FF0000",
								highlight: "#EE0000",
								label: "Fail"
							},
							{
								value: <?php echo $pageVars['data']['running']; ?>,
								color: "#0000FF",
								highlight: "#0000EE",
								label: "Running"
							}
						];
						var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

						var barChartData = {
							labels : <?php echo json_encode($date); ?>,
							datasets : [
								{
									fillColor : "rgba(0,255,0,0.5)",
									strokeColor : "rgba(220,0,0,0.8)",
									highlightFill: "rgba(220,0,0,0.75)",
									highlightStroke: "rgba(220,0,0,1)",
									data : <?php echo json_encode($success); ?>
								},
								{
									fillColor : "rgba(255,0,0,0.5)",
									strokeColor : "rgba(220,0,0,0.8)",
									highlightFill: "rgba(220,0,0,0.75)",
									highlightStroke: "rgba(220,0,0,1)",
									data : <?php echo json_encode($fail); ?>
								}
							]
						}

			
						window.onload = function(){
							var ctx = document.getElementById("chart-area").getContext("2d");
							window.myPie = new Chart(ctx).Pie(pieData);
							var ctx = document.getElementById("canvas").getContext("2d");
								window.myBar = new Chart(ctx).Line(barChartData, {
								responsive : true
							});
						};
					</script>

            </div>

            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>
        </div>


    </div>

</div><!-- /.container -->


