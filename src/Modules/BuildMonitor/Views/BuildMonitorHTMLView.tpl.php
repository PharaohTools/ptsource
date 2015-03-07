<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-3 sidebar">
            <div class="mini-submenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </div>
            <div class="list-group sidebar-list">
                <span href="#" class="list-group-item active"> Menu <span class="pull-right" id="slide-submenu">
                    <i class="fa fa-times"></i>
                </span> </span>
                <a href="/index.php?control=Index&action=show" class="list-group-item">
                    <i class="fa fa-comment-o"></i> Dashboard
                </a>
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-search"></i> All Pipelines
                </a>
                <a href="/index.php?control=BuildConfigure&action=show&item=<?php echo $pageVars["data"]["item"] ; ?>" class="list-group-item">
                    <i class="fa fa-user"></i> Configure
                </a>
                <a href="/index.php?control=Workspace&action=show&item=<?php echo $pageVars["data"]["item"] ; ?>" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Workspace
                </a>
                <a href="index.php?control=BuildMoniter&action=show&item=<?php echo $pageVars["data"]["item"] ; ?>" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Moniter
                </a>
                <a href="/index.php?control=BuildHome&action=changes&item=<?php echo $pageVars["data"]["item"] ; ?>" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Changes <span class="badge">3</span>
                </a>
                <a href="/index.php?control=BuildHome&action=history&item=<?php echo $pageVars["data"]["item"] ; ?>" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> History <span class="badge">3</span>
                </a>
                <a href="/index.php?control=BuildHome&action=delete&item=<?php echo $pageVars["data"]["item"] ; ?>" class="list-group-item">
                    <i class="fa fa-envelope"></i> Delete
                </a>
                <a href="/index.php?control=PipeRunner&action=start&item=<?php echo $pageVars["data"]["item"] ; ?>" class="list-group-item">
                    <i class="fa fa-envelope"></i> Run Now
                </a>
            </div>
        </div>
        <div class="col-sm-8 col-md-9 clearfix main-container">
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
                <script src="Assets/BuildMoniter/js/Chart.js"></script>
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


