<div class="container" id="wrapper">
	<div class="navbar-default col-sm-2 sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav in" id="side-menu">
				<li class="sidebar-search">
					<div class="input-group custom-search-form  hvr-bounce-in">
						<input type="text" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">
								<i class="fa fa-search"></i>
							</button> </span>
					</div>
					<!-- /input-group -->
				</li>
				<li>
					<a href="/index.php?control=Index&action=show" class=" hvr-bounce-in"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
				</li>
				<li>
					<a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in"> <i class="fa fa-cogs fa-fw"></i> Configure PTBuild<span class="fa arrow"></span> </a>
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
					<a href="/index.php?control=BuildConfigure&action=new"class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> New Pipeline</a>
				</li>
				<li>
					<a href="/index.php?control=BuildConfigure&action=copy"class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> Copy Pipeline</a>
				</li>
				<li>
					<a href="/index.php?control=BuildList&action=show " class="active  hvr-bounce-in"><i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Pipelines</a>
				</li>
				<!--<li>
					<a href="/index.php?control=Monitors&action=DefaultHistory" class=" hvr-bounce-in"><i class="fa fa-history fa-fw hvr-bounce-in"></i> History<span class="fa arrow"></span></a>
				</li> -->
			</ul>
		</div>
		<br />

		<div class="alert alert-info">
			<h4>Running Builds </h4>
			<div id="runningBuilds">
				<p>
					No builds currently being executed
				</p>
				
			</div>
		</div>

	</div>

	<div class="col-lg-9">
		<div class="well well-lg">
<!--			<h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools</a></h2>-->

			<div class="row clearfix no-margin">
				<h4 class="text-uppercase text-light">All Pipelines</h4>
				<!--
				<h3>
				<a class="lg-anchor text-light" href="/index.php?control=BuildList&action=show">
				Build List <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a>
				</h3>
				-->
				<div role="tabpanel grid">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a>
                        </li>
                        <li role="presentation">
                            <a onclick="showFilteredRows('success'); return false ;">All Success</a>
                        </li>
                        <li role="presentation">
                            <a onclick="showFilteredRows('failure'); return false ;">All Failed</a>
                        </li>
                        <li role="presentation">
                            <a onclick="showFilteredRows('unstable'); return false ;">All Unstable</a>
                        </li>
                    </ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="all">
							<div class="table-responsive" ">
							<div class="table table-striped table-bordered table-condensed">
                                <div>
                                    <div class="blCell cellRowIndex">#</div>
                                    <div class="blCell cellRowName">Pipeline</div>
                                    <div class="blCell cellRowRun">Run Now</div>
                                    <div class="blCell cellRowStatus">Status</div>
                                    <div class="blCell cellRowSuccess">Success</div>
                                    <div class="blCell cellRowFailure">Failure</div>
                                    <div class="blCell cellRowDuration">Duration</div>
                                </div>
							<div class="allBuildRows table-hover">

							<?php

							$i = 1;
							foreach ($pageVars["data"]["pipelines"] as $pipelineSlug => $pipelineDetails) {
                                $successFailureClass = ($pipelineDetails["last_status"] == true) ? "successRow" : "failureRow" ;
                                ?>

							<div class="buildRow <?php echo $successFailureClass ?>" id="blRow_<?php echo $pipelineSlug; ?>" >
							<div class="blCell cellRowIndex" scope="row"><?php echo $i; ?> </div>
							<div class="blCell cellRowName"><a href="/index.php?control=BuildHome&action=show&item=<?php echo $pipelineSlug; ?>" class="pipeName"><?php echo $pipelineDetails["project-name"]; ?>  </a> </div>
							
							<div class="blCell cellRowRun">
							<?php
							echo '<a href="/index.php?control=PipeRunner&action=start&item=' . $pipelineDetails["project-slug"] . '">';
							echo '<i class="fa fa-play fa-2x hvr-grow-shadow" style="color:rgb(13, 193, 42);"></i></a>';
							?>
							</div>
							<div  class="blCell cellRowStatus"
                                <?php

                                if ($pipelineDetails["last_status"] === true) {
                                    echo ' style="background-color:rgb(13, 193, 42);" '; }
                                else if ($pipelineDetails["last_status"] === false) {
                                    echo ' style="background-color:#D32B2B" '; }
                                else {
                                    echo ' style="background-color:gray" '; }
                                ?>

                                >

                                <?php

                                echo '<p> #'.$pipelineDetails["last_run_build"].'</p>' ;

							?>

							</div>
							
							<div class="blCell cellRowSuccess">
							<?php

                            $today = new DateTime(); // This object represents current date/time
                            $actualToday = $today; // copy original for display
                            $today->setTime( 0, 0, 0 ); // reset time part, to prevent partial comparison

                            if ($pipelineDetails["last_success"] != false) {

                                $match_date = new DateTime(date('d.m.Y H:i', $pipelineDetails["last_success"]));

//                                var_dump($match_date) ;

                                $diff = $today->diff( $match_date );
                                $diffDays = (integer)$diff->format( "%R%a" ); // Extract days count in interval

								$date = date($pipelineDetails["last_success"]);
                                if( $diffDays == 0 ) {
                                    echo date_format($match_date, 'g:ia')." Today"; }
                                else if( $diffDays == -1 ) {
                                    echo date_format($match_date, 'g:ia')." Yesterday"; }
                                else {
                                    echo date_format($match_date, 'g:ia \o\n D jS M Y'); }
								echo ' #(' . $pipelineDetails["last_success_build"] . ')'; }
                            else {
								echo 'N/A'; }
							?>
							</div>
							<div class="blCell cellRowFailure">
							<?php
							if ($pipelineDetails["last_fail"] != false) {

                                $match_date = new DateTime(date('d.m.Y H:i', $pipelineDetails["last_fail"]));
//                                var_dump($match_date) ;

                                $diff = $today->diff( $match_date );
                                $diffDays = (integer)$diff->format( "%R%a" ); // Extract days count in interval

                                $date = date($pipelineDetails["last_fail"]);
                                if( $diffDays == 0 ) {
                                    echo date_format($match_date, 'g:ia')." Today"; }
                                else if( $diffDays == -1 ) {
                                    echo date_format($match_date, 'g:ia')." Yesterday"; }
                                else {
                                    echo date_format($match_date, 'g:ia \o\n D jS M Y'); }
                                echo ' #(' . $pipelineDetails["last_fail_build"] . ')';}
                            else {
                                echo 'N/A'; }

							?>
							</div>
							<div class="blCell cellRowDuration">
							<?php
							if ($pipelineDetails["duration"] != false) {
								echo $pipelineDetails["duration"] . ' seconds';
							} else {
								echo 'N/A';
							}
							?>
							</div>
							<!--
							<div>
							<?php
							if ($pipelineDetails["has_parents"] === true) {
							echo '<img class="listImage" src="/Assets/Modules/BuildList/image/tick.png" />' ; }
							else {
							echo '<img class="listImage" src="/Assets/Modules/BuildList/image/cross.png" />' ; }
							?>
							</div>
							<div>
							<?php
							if ($pipelineDetails["has_children"] === true) {
							echo '<img class="listImage" src="/Assets/Modules/BuildList/image/tick.png" />' ; }
							else {
							echo '<img class="listImage" src="/Assets/Modules/BuildList/image/cross.png" />' ; }
							?>
							</div>
							-->
							</div>
							<?php
							$i++;
							}
							?>

							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		 <hr>
                <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>
	</div>
</div><!-- /.container -->
<link rel="stylesheet" type="text/css" href="/Assets/Modules/BuildList/css/buildlist.css">
<script type="text/javascript" src="/Assets/Modules/BuildList/js/buildlist.js"></script>
