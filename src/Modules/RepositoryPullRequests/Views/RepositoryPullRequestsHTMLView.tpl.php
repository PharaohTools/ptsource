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
					<a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-cogs fa-fw"></i> Configure PTSource<span class="fa arrow"></span>
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
                    <a href="/index.php?control=FileBrowser&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryPullRequests&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-pullrequests fa-fw hvr-bounce-in"></i> History <span class="badge"><?php echo $pageVars['data']["pullrequests_count"] ; ?></span>
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryHome&action=delete&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-trash fa-fw hvr-bounce-in"></i> Delete
                    </a>
                </li>
			</ul>
		</div>
		<br />
	</div>

	<div class="col-lg-9">
		<div class="well well-lg">
			<div class="row clearfix no-margin">
				<h4 class="text-uppercase text-light">Pull Requests</h4>

                <?php
                    echo $this->renderWidgetPosition('IdentifierSelector', 'default') ;
                ?>

				<div role="tabpanel grid">

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="all">
							<div class="table-responsive">
							    <div class="table table-striped table-bordered table-condensed">
                                    <div>
                                        <div class="blCell cellRowIndex">#</div>
                                        <div class="blCell cellRowMessage">Message</div>
                                        <div class="blCell cellRowAuthor">Author</div>
                                        <div class="blCell cellRowDate">Date</div>
                                        <div class="blCell cellRowHash">Hash</div>
                                    </div>
                                    <div class="allBuildRows table-hover">

                                    <?php

                                    $i = 1;

                                    foreach ($pageVars['data']['pull_requests'] as $onePullRequest) {

                                        ?>

                                        <div class="pullRequestRow" id="blRow_<?php echo $onePullRequest['pr_id']; ?>" >
                                            <div class="blCell cellRowIndex" scope="row"><?php echo $i; ?> </div>
                                            <div class="blCell cellRowMessage">
                                                <a href="/index.php?control=PullRequest&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars['data']['identifier'] ; ?>&pr_id=<?php echo $onePullRequest['pr_id'] ; ?>" class="pipeName">
                                                    <?php echo $onePullRequest["message"]; ?>
                                                </a>
                                            </div>
                                            <div class="blCell cellRowAuthor">
                                                <a href="/index.php?control=PullRequest&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars['data']['identifier'] ; ?>&pr_id=<?php echo $onePullRequest['pr_id'] ; ?>" class="pipeName">
                                                    <?php echo $onePullRequest["requestor"]; ?>
                                                </a>
                                            </div>
                                            <div class="blCell cellRowDate">
                                                <a href="/index.php?control=PullRequest&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars['data']['identifier'] ; ?>&pr_id=<?php echo $onePullRequest['pr_id'] ; ?>" class="pipeName">
                                                    <?php echo str_replace('+0000', '', $onePullRequest["date"]) ; ?>
                                                </a>
                                            </div>
                                            <div class="blCell cellRowHash">
                                                <a href="/index.php?control=PullRequest&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars['data']['identifier'] ; ?>&pr_id=<?php echo $onePullRequest['pr_id'] ; ?>" class="pipeName">
                                                    <?php echo substr($onePullRequest['pr_id'], 0, 6); ?>
                                                </a>
                                            </div>
                                        </div>

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
            <hr />
            <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>
        </div>
    </div><!-- /.container -->
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryPullRequests/css/repositorypullrequests.css">
<script type="text/javascript" src="/Assets/Modules/RepositoryPullRequests/js/repositorypullrequests.js"></script>


