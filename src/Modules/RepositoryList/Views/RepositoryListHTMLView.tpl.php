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
					<a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in"> <i class="fa fa-cogs fa-fw"></i> Configure PTSource<span class="fa arrow"></span> </a>
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
					<a href="/index.php?control=BuildConfigure&action=new"class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> New Repository</a>
				</li>
				<li>
					<a href="/index.php?control=BuildConfigure&action=copy"class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> Copy Repository</a>
				</li>
				<li>
					<a href="/index.php?control=RepositoryList&action=show " class="active  hvr-bounce-in"><i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Repositories</a>
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
					No repositorys currently being executed
				</p>
				
			</div>
		</div>

	</div>

	<div class="col-lg-9">
		<div class="well well-lg">
<!--			<h2 class="text-uppercase text-light"><a href="/"> PTSource - Pharaoh Tools</a></h2>-->

			<div class="row clearfix no-margin">
				<h4 class="text-uppercase text-light">All Repositories</h4>
				<!--
				<h3>
				<a class="lg-anchor text-light" href="/index.php?control=RepositoryList&action=show">
				Build List <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a>
				</h3>
				-->
				<div role="tabpanel grid">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a onclick="showFilteredRows('all'); return false ;">All</a>
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
                                    <div class="blCell cellRowName">Repository</div>
                                    <div class="blCell cellRowRun">Run Now</div>
                                    <div class="blCell cellRowStatus">Status</div>
                                    <div class="blCell cellRowSuccess">Success</div>
                                    <div class="blCell cellRowFailure">Failure</div>
                                    <div class="blCell cellRowDuration">Duration</div>
                                </div>
							<div class="allBuildRows table-hover">

							<?php

							$i = 1;
							foreach ($pageVars["data"]["repositories"] as $repositorySlug => $repositoryDetails) {


                                if ($repositoryDetails["last_status"] === true) {
                                    $successFailureClass = "successRow"  ; }
                                else if ($repositoryDetails["last_status"] === false) {
                                    $successFailureClass = "failureRow" ; }
                                else {
                                    $successFailureClass = "unstableRow" ; }

                                ?>

							<div class="repositoryRow <?php echo $successFailureClass ?>" id="blRow_<?php echo $repositorySlug; ?>" >
							<div class="blCell cellRowIndex" scope="row"><?php echo $i; ?> </div>
							<div class="blCell cellRowName"><a href="/index.php?control=RepositoryHome&action=show&item=<?php echo $repositorySlug; ?>" class="pipeName"><?php echo $repositoryDetails["project-name"]; ?>  </a> </div>
							
							<div class="blCell cellRowRun">
							<?php
							echo '<a href="/index.php?control=PipeRunner&action=start&item=' . $repositoryDetails["project-slug"] . '">';
							echo '<i class="fa fa-play fa-2x hvr-grow-shadow" style="color:rgb(13, 193, 42);"></i></a>';
							?>
							</div>
							<div  class="blCell cellRowStatus"
                                <?php

                                if ($repositoryDetails["last_status"] === true) {
                                    echo ' style="background-color:rgb(13, 193, 42);" '; }
                                else if ($repositoryDetails["last_status"] === false) {
                                    echo ' style="background-color:#D32B2B" '; }
                                else {
                                    echo ' style="background-color:gray" '; }
                                ?>

                                >

                                <?php

                                echo '<p> #'.$repositoryDetails["last_run_repository"].'</p>' ;

							?>

							</div>
							
							<div class="blCell cellRowSuccess">
							<?php

                            $today = new DateTime(); // This object represents current date/time
                            $actualToday = $today; // copy original for display
                            $today->setTime( 0, 0, 0 ); // reset time part, to prevent partial comparison

                            if ($repositoryDetails["last_success"] != false) {

                                $match_date = new DateTime(date('d.m.Y H:i', $repositoryDetails["last_success"]));

//                                var_dump($match_date) ;

                                $diff = $today->diff( $match_date );
                                $diffDays = (integer)$diff->format( "%R%a" ); // Extract days count in interval

								$date = date($repositoryDetails["last_success"]);
                                if( $diffDays == 0 ) {
                                    echo date_format($match_date, 'g:ia')." Today"; }
                                else if( $diffDays == -1 ) {
                                    echo date_format($match_date, 'g:ia')." Yesterday"; }
                                else {
                                    echo date_format($match_date, 'g:ia \o\n D jS M Y'); }
								echo ' #(' . $repositoryDetails["last_success_repository"] . ')'; }
                            else {
								echo 'N/A'; }
							?>
							</div>
							<div class="blCell cellRowFailure">
							<?php
							if ($repositoryDetails["last_fail"] != false) {

                                $match_date = new DateTime(date('d.m.Y H:i', $repositoryDetails["last_fail"]));
//                                var_dump($match_date) ;

                                $diff = $today->diff( $match_date );
                                $diffDays = (integer)$diff->format( "%R%a" ); // Extract days count in interval

                                $date = date($repositoryDetails["last_fail"]);
                                if( $diffDays == 0 ) {
                                    echo date_format($match_date, 'g:ia')." Today"; }
                                else if( $diffDays == -1 ) {
                                    echo date_format($match_date, 'g:ia')." Yesterday"; }
                                else {
                                    echo date_format($match_date, 'g:ia \o\n D jS M Y'); }
                                echo ' #(' . $repositoryDetails["last_fail_repository"] . ')';}
                            else {
                                echo 'N/A'; }

							?>
							</div>
							<div class="blCell cellRowDuration">
							<?php
							if ($repositoryDetails["duration"] != false) {
								echo $repositoryDetails["duration"] . ' seconds';
							} else {
								echo 'N/A';
							}
							?>
							</div>
							<!--
							<div>
							<?php
							if ($repositoryDetails["has_parents"] === true) {
							echo '<img class="listImage" src="/Assets/Modules/RepositoryList/image/tick.png" />' ; }
							else {
							echo '<img class="listImage" src="/Assets/Modules/RepositoryList/image/cross.png" />' ; }
							?>
							</div>
							<div>
							<?php
							if ($repositoryDetails["has_children"] === true) {
							echo '<img class="listImage" src="/Assets/Modules/RepositoryList/image/tick.png" />' ; }
							else {
							echo '<img class="listImage" src="/Assets/Modules/RepositoryList/image/cross.png" />' ; }
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
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryList/css/repositorylist.css">
<script type="text/javascript" src="/Assets/Modules/RepositoryList/js/repositorylist.js"></script>
