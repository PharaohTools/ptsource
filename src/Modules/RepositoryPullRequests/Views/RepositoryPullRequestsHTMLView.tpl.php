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

                <?php

                if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {

                    ?>
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
                            <li>
                                <a href="/index.php?control=Integrations&action=show" class=" hvr-curl-bottom-right">Integrations</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryConfigure&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa  fa-cog fa-fw hvr-bounce-in"></i> Configure Repository
                        </a>
                    </li>

                    <?php

                }

                ?>
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
                        <i class="fa fa-pullrequests fa-fw hvr-bounce-in"></i> History
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
				<h3 class="text-uppercase text-light">Pull Requests for <strong><?php echo $pageVars['data']["repository"]["project-name"] ; ?></strong></h3>

				<div role="tabpanel grid">

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="all">

                            <div class="col-sm-12" id="create_new_pull_request_fields">
                                <div class="col-sm-12 create_new_pull_request_field">
                                    <label for="new_pull_request_title" class="col-sm-1 control-label text-left" style="color:#757575">Title</label>
                                    <div class="col-sm-11">
                                        <input type="text" class="form-control" id="new_pull_request_title" name="new_pull_request_title" value="" placeholder="Pull Request Title" />
                                        <span style="color:#FF0000;" id="new_pull_request_title_alert"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 create_new_pull_request_field">
                                    <span class="col-sm-1 control-label text-left" style="color:#757575">Source</span>
<!--                                    <label for="new_pull_request_source_branch" class="col-sm-1 control-label text-left" style="color:#757575">Branch</label>-->
                                    <div class="col-sm-5">
                                        <div class="col-sm-6">
                                            <button class="btn btn-info dropdown-toggle" type="button" id="source_branch_selection" data-toggle="dropdown" aria-expanded="true">
                                                Select Branch
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" id="source_branch_list" role="menu" aria-labelledby="source_branch_selection">
                                                <?php
                                                foreach($pageVars["data"]["branches"] as $branch_name) {
                                                    ?>
                                                    <li role="presentation">
                                                        <a role="menuitem"
                                                           tabindex="-1"
                                                           class="source_branch_option"
                                                           id="source_branch_option_<?= $branch_name ?>"
                                                           data-source_branch="<?= $branch_name ?>">
                                                            <?= $branch_name ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="btn btn-success" id="new_pull_request_source_branch_display">None</span>
                                            <span style="color:#FF0000;" id="new_pull_request_source_branch_alert"></span>
                                            <input type="hidden" id="new_pull_request_source_branch" name="new_pull_request_source_branch" value="" />
                                        </div>
                                    </div>
                                    <label for="new_pull_request_source_commit" class="col-sm-1 control-label text-left" style="color:#757575;">Commit</label>
                                    <div class="col-sm-3">
                                        <input type="text"
                                               class="form-control"
                                               id="new_pull_request_source_commit"
                                               name="new_pull_request_source_commit"
                                               value=""
                                               placeholder="Latest Commit" />
                                        <span style="color:#FF0000;" id="new_pull_request_source_commit_alert"></span>
                                    </div>
                                    <div class="col-sm-1">
                                        <span class="btn btn-primary findButton" id="new_pull_request_source_commit_find">Find</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 create_new_pull_request_field">
                                    <span class="col-sm-1 control-label text-left" style="color:#757575">Target</span>
<!--                                    <label for="new_pull_request_target_branch" class="col-sm-1 control-label text-left" style="color:#757575">Branch</label>-->
                                    <div class="col-sm-5">
                                        <div class="col-sm-6">
                                            <button class="btn btn-info dropdown-toggle" type="button" id="target_branch_selection" data-toggle="dropdown" aria-expanded="true">
                                                Select Branch
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" id="target_branch_list" role="menu" aria-labelledby="target_branch_selection">
                                                <?php
                                                foreach($pageVars["data"]["branches"] as $branch_name) {
                                                    ?>
                                                    <li role="presentation">
                                                        <a role="menuitem"
                                                           tabindex="-1"
                                                           class="target_branch_option"
                                                           id="target_branch_option_<?= $branch_name ?>"
                                                           data-target_branch="<?= $branch_name ?>">
                                                            <?= $branch_name ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="btn btn-success" id="new_pull_request_target_branch_display">None</span>
                                            <span style="color:#FF0000;" id="new_pull_request_target_branch_alert"></span>
                                            <input type="hidden" id="new_pull_request_target_branch" name="new_pull_request_target_branch" value="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 create_new_pull_request_field">
                                    <label for="new_pull_request_title" class="col-sm-1 control-label text-left" style="color:#757575">Desc.</label>
                                    <div class="col-sm-11">
                                        <textarea class="form-control"
                                                  id="new_pull_request_description"
                                                  name="new_pull_request_description"
                                                  placeholder="Pull Request Description"></textarea>
                                        <span style="color:#FF0000;" id="new_pull_request_description_alert"></span>
                                    </div>
                                </div>
                                <input type="hidden"
                                       id="new_pull_request_item"
                                       value="<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" />

                                <div class="col-sm-12 create_new_pull_request_field">
                                    <div class="col-sm-offset-4 col-sm-3 actionButtonWrap">
                                        <a id="save_new_pull_request" class="btn btn-success hvr-grow-shadow actionButton">
                                            Save this Pull Request
                                        </a>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12">
                                <div class="col-sm-12 loading_pull_requests">
                                    <img src="/Assets/Modules/UserSSHKey/image/loading.gif" alt="Loading Keys">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="col-sm-8">
                                    <h5>Filters</h5>
                                </div>
                                <div class="col-sm-4">
                                    <span id="create_new_pull_request" class="btn btn-success">
                                        New Pull Request
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <div class="table table-striped table-bordered table-condensed">

                                        <?php

                                        if (isset($pageVars['data']['pull_requests']) &&
                                            is_array($pageVars['data']['pull_requests']) &&
                                            count($pageVars['data']['pull_requests'])>0) {

                                            $i = 1;

                                            ?>

                                            <div id="allPullRequestRows" class="allPullRequestRows table-hover">

                                            <?php
                                            foreach ($pageVars['data']['pull_requests'] as $onePullRequest) {

                                                ?>

                                                <div class="pullRequestRow" id="blRow_<?php echo $onePullRequest['id']; ?>" >
                                                    <div class="blCell cellRowIndex col-sm-2"><?php echo $i; ?> </div>
                                                    <div class="col-sm-6">
                                                        <div class="blCell cellRowTitle col-sm-12">
                                                            <a href="/index.php?control=PullRequest&action=show&item=<?php echo $onePullRequest["repo_pr_id"]; ?>&pr_id=<?php echo $onePullRequest['pr_id'] ; ?>" class="pipeName">
                                                                <h4><?php echo $onePullRequest['title']; ?></h4>
                                                            </a>
                                                        </div>
                                                        <div class="blCell cellRowAuthor col-sm-12">
                                                            <a href="/index.php?control=PullRequest&action=show&item=<?php echo $onePullRequest["repo_pr_id"]; ?>&pr_id=<?php echo $onePullRequest['pr_id'] ; ?>" class="pipeName">
                                                                <?php echo $onePullRequest['requestor']; ?>
                                                            </a>
                                                            opened this request on <?php echo date('H:i d/m/Y', $onePullRequest['created_on']) ; ?>
                                                        </div>
                                                    </div>
                                                    <div class="blCell col-sm-4">
                                                        <?php

                                                        if ($onePullRequest['status'] === 'rejected') {
                                                            ?>
                                                            <span class="pull_request_status_display btn btn-danger">
                                                                Rejected
                                                            </span>
                                                            <?php
                                                        } else if ($onePullRequest['status'] === 'closed') {
                                                            ?>
                                                            <span class="pull_request_status_display btn btn-danger">
                                                                Closed
                                                            </span>
                                                            <?php
                                                        } else if ($onePullRequest['status'] === 'open') {
                                                            ?>
                                                            <span class="pull_request_status_display btn btn-warning">
                                                                Open
                                                            </span>
                                                            <?php
                                                        } else if ($onePullRequest['status'] === 'accepted') {
                                                            ?>
                                                            <span class="pull_request_status_display btn btn-success">
                                                                Accepted
                                                            </span>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <?php

                                                $i++ ;
                                            }
                                            ?>
                                            </div>

                                        <?php
                                        } else {

                                            ?>

                                            <div id="allPullRequestRows" class="allPullRequestRows table-hover">
                                                <h4>
                                                    There are no Pull Requests associated with this Repository
                                                </h4>
                                            </div>

                                            <?php
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


