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
                    <a href="/index.php?control=FileBrowser&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildMonitor&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Monitors
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"><?php echo $pageVars["data"]["history_count"] ; ?></span>
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryHome&action=delete&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-trash fa-fw hvr-bounce-in"></i> Delete
                    </a>
                </li>
			</ul>
		</div>
		<br />
	</div>

	<div class="col-lg-9">
		<div class="well well-lg">
<!--			<h2 class="text-uppercase text-light"><a href="/"> PTSource - Pharaoh Tools</a></h2>-->

			<div class="row clearfix no-margin">
				<h4 class="text-uppercase text-light">Commit History</h4>
				<!--
				<h3>
				<a class="lg-anchor text-light" href="/index.php?control=RepositoryHistory&action=show">
				Build History <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a>
				</h3>
				-->

                <?php

                echo $this->renderWidgetPosition('IdentifierSelector', 'default') ;

                ?>

				<div role="tabpanel grid">

                    <!-- Nav tabs -->
<!--                    <ul class="nav nav-tabs" role="tabhistory">-->
<!--                        <li role="presentation" class="active">-->
<!--                            <a onclick="showFilteredRows('all'); return false ;">All</a>-->
<!--                        </li>-->
<!--                        <li role="presentation">-->
<!--                            <a onclick="showFilteredRows('success'); return false ;">All Success</a>-->
<!--                        </li>-->
<!--                        <li role="presentation">-->
<!--                            <a onclick="showFilteredRows('failure'); return false ;">All Failed</a>-->
<!--                        </li>-->
<!--                        <li role="presentation">-->
<!--                            <a onclick="showFilteredRows('unstable'); return false ;">All Unstable</a>-->
<!--                        </li>-->
<!--                    </ul>-->

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="all">
							<div class="table-responsive" ">
							<div class="table table-striped table-bordered table-condensed">
                                <div>
                                    <div class="blCell cellRowIndex">#</div>
                                    <div class="blCell cellRowMessage">Message</div>
                                    <div class="blCell cellRowAuthor">Author</div>
                                    <div class="blCell cellRowDate">Date</div>
                                    <div class="blCell cellRowHash">Hash</div>
<!--                                    <div class="blCell cellRowFailure">Failure</div>-->
<!--                                    <div class="blCell cellRowDuration">Duration</div>-->
                                </div>
							<div class="allBuildRows table-hover">

							<?php

							$i = 1;

                            foreach ($pageVars["data"]["commits"] as $commitDetails) {

                                ?>

							<div class="commitRow" id="blRow_<?php echo $commitDetails["commit"]; ?>" >
							<div class="blCell cellRowIndex" scope="row"><?php echo $i; ?> </div>
                            <div class="blCell cellRowMessage"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>" class="pipeName"><?php echo $commitDetails["message"]; ?>  </a> </div>
                            <div class="blCell cellRowAuthor"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>" class="pipeName"><?php echo $commitDetails["author"]; ?>  </a> </div>
                            <div class="blCell cellRowDate"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>" class="pipeName"><?php echo $commitDetails["date"]; ?>  </a> </div>
                            <div class="blCell cellRowHash"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>" class="pipeName"><?php echo substr($commitDetails["commit"], 0, 6); ?>  </a> </div>
                                <?php

                                $i++ ;
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
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryHistory/css/repositoryhistory.css">
<script type="text/javascript" src="/Assets/Modules/RepositoryHistory/js/repositoryhistory.js"></script>


