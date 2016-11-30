<div class="container" id="wrapper">
	<div class="navbar-default col-sm-2 sidebar" role="navigation">
		<div class="sidebar-nav ">
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
					<a href="/index.php?control=TeamConfigure&action=new"class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> New Team</a>
				</li>
				<li>
					<a href="/index.php?control=TeamConfigure&action=copy"class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> Copy Team</a>
				</li>
			</ul>
		</div>
		<br />


	</div>

	<div class="col-lg-9">
		<div class="well well-lg">

			<div class="row clearfix no-margin">
				<h4 class="text-uppercase text-light">All Teams</h4>

				<div role="tabpanel grid">

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="all">
							<div class="table-responsive">

							<div class="table table-striped table-bordered table-condensed">
                                <div class="blCell cellRowIndex">#</div>
                                <div class="blCell cellRowName">Team</div>
                                <div class="blCell cellRowFeatures">Features</div>
                                <div class="blCell cellRowMore">More</div>
                            </div>
							<div class="allBuildRows table-hover">

							<?php

							$i = 1;
							foreach ($pageVars["data"]["teams"] as $teamSlug => $teamDetails) {

                                if ($teamDetails["last_status"] === true) {
                                    $successFailureClass = "successRow"  ; }
                                else if ($teamDetails["last_status"] === false) {
                                    $successFailureClass = "failureRow" ; }
                                else {
                                    $successFailureClass = "unstableRow" ; }

                                if (isset($teamDetails["team_name"])) {
                                    $slugOrName = $teamDetails["team_name"] ; }
                                else if (isset($teamSlug)) {
                                    $slugOrName = $teamSlug ; }
                                else {
                                    $slugOrName = "Unnamed Team" ; }

                                ?>

							<div class="teamRow <?php echo $successFailureClass ?>" id="blRow_<?php echo $teamSlug; ?>" >
                                <div class="blCell cellRowIndex" scope="row">
                                    <?php echo $i; ?>
                                </div>
                                <div class="blCell cellRowName">
                                    <a href="/index.php?control=TeamHome&action=show&item=<?php echo $teamSlug; ?>" class="pipeName">
                                        <?php echo $slugOrName; ?>
                                    </a>
                                </div>
                                <div class="blCell cellRowFeatures">
                                    <?php

                                    if (isset($teamDetails["features"]) &&
                                        count($teamDetails["features"])>0 ) {
                                        foreach ($teamDetails["features"] as $team_feature) {
                                            echo '<div class="team_feature">' ;
                                            echo ' <a target="_blank" href="'.$team_feature["model"]["link"].'">' ;
//                                                echo  '<h3>'.$team_feature["model"]["title"].'</h3>' ;
                                            echo '  <img src="'.$team_feature["model"]["image"].'" />' ;
                                            echo " </a>" ;
                                            echo '</div>' ; } }
                                    else {
                                        echo '&nbsp;' ; }

                                    ?>
                                </div>
                                <div  class="blCell cellRowMore">
                                    <span class="fullRow">
                                        <a href="/index.php?control=TeamCharts&action=show&item=<?php echo $teamSlug; ?>">Graphs</a>
                                    </span>
<!--                                    <span class="fullRow">-->
<!--                                        <a href="/index.php?control=TeamCharts&action=contributors&item=--><?php //echo $teamSlug; ?><!--">Contributors</a>-->
<!--                                    </span>-->
                                    <span class="fullRow">
                                        <a href="/index.php?control=TeamHistory&action=show&item=<?php echo $teamSlug; ?>">History</a>
                                    </span>
                                </div>
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
		 <hr>
                <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>
	</div>
</div><!-- /.container -->
<link rel="stylesheet" type="text/css" href="/Assets/Modules/TeamList/css/teamlist.css">
