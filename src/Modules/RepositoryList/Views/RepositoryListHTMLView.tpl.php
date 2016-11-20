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
					<a href="/index.php?control=RepositoryConfigure&action=new"class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> New Repository</a>
				</li>
				<li>
					<a href="/index.php?control=RepositoryConfigure&action=copy"class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> Copy Repository</a>
				</li>
			</ul>
		</div>
		<br />


	</div>

	<div class="col-lg-9">
		<div class="well well-lg">

			<div class="row clearfix no-margin">
				<h4 class="text-uppercase text-light">All Repositories</h4>

				<div role="tabpanel grid">

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="all">
							<div class="table-responsive">

							<div class="table table-striped table-bordered table-condensed">
                                <div class="blCell cellRowIndex">#</div>
                                <div class="blCell cellRowName">Repository</div>
                                <div class="blCell cellRowFeatures">Features</div>
                                <div class="blCell cellRowMore">More</div>
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

                                if (isset($repositoryDetails["project-name"])) {
                                    $slugOrName = $repositoryDetails["project-name"] ; }
                                else if (isset($repositorySlug)) {
                                    $slugOrName = $repositorySlug ; }
                                else {
                                    $slugOrName = "Unnamed Project" ; }

                                ?>

							<div class="repositoryRow <?php echo $successFailureClass ?>" id="blRow_<?php echo $repositorySlug; ?>" >
                                <div class="blCell cellRowIndex" scope="row">
                                    <?php echo $i; ?>
                                </div>
                                <div class="blCell cellRowName">
                                    <a href="/index.php?control=RepositoryHome&action=show&item=<?php echo $repositorySlug; ?>" class="pipeName">
                                        <?php echo $slugOrName; ?>
                                    </a>
                                </div>
                                <div class="blCell cellRowFeatures">
                                    <?php

                                    if (isset($repositoryDetails["features"]) &&
                                        count($repositoryDetails["features"])>0 ) {
                                        foreach ($repositoryDetails["features"] as $repository_feature) {
                                            echo '<div class="repository-feature">' ;
                                            echo ' <a target="_blank" href="'.$repository_feature["model"]["link"].'">' ;
//                                                echo  '<h3>'.$repository_feature["model"]["title"].'</h3>' ;
                                            echo '  <img src="'.$repository_feature["model"]["image"].'" />' ;
                                            echo " </a>" ;
                                            echo '</div>' ; } }
                                    else {
                                        echo '&nbsp;' ; }

                                    ?>
                                </div>
                                <div  class="blCell cellRowMore">
                                    <span class="fullRow">
                                        <a href="/index.php?control=RepositoryMonitors&action=show&item=<?php echo $repositorySlug; ?>">Graphs</a>
                                    </span>
                                    <span class="fullRow">
                                        <a href="/index.php?control=RepositoryMonitors&action=contributors&item=<?php echo $repositorySlug; ?>">Contributors</a>
                                    </span>
                                    <span class="fullRow">
                                        <a href="/index.php?control=RepositoryHistory&action=show&item=<?php echo $repositorySlug; ?>">History</a>
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
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryList/css/repositorylist.css">
<script type="text/javascript" src="/Assets/Modules/RepositoryList/js/repositorylist.js"></script>
