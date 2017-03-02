<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
		<div class="sidebar-nav ">
			<ul class="nav in" id="side-menu">
                <?php

                if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {

                ?>
                    <li>
                        <a href="/index.php?control=Index&amp;action=show" class="hvr-bounce-in">
                            <i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryList&amp;action=show" class="hvr-bounce-in">
                            <i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Repositories
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryConfigure&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa  fa-cog fa-fw hvr-bounce-in"></i> Configure
                        </a>
                    </li>

                <?php

                }
                ?>

                <li>
                    <a href="index.php?control=FileBrowser&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"></span>
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryPullRequests&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-code fa-fw hvr-bounce-in"></i> Pull Requests <span class="badge"></span>
                    </a>
                </li>


                <?php
                if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {
                    ?>

                    <li>
                        <a href="index.php?control=PullRequest&action=delete&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-trash fa-fw hvr-bounce-in"></i> Delete
                        </a>
                    </li>

                <?php
                }
                ?>

            </ul>
        </div>
    </div>
    
    <div class="col-lg-9">
        <div class="well well-lg ">
            <div class="row clearfix no-margin">
                <h3 class="text-uppercase text-light">
                    <strong>
                        <?php echo $pageVars["data"]["repository"]["project-name"] ; ?>:
                    </strong>
                    Pull Request
                </h3>
            </div>

            <div class="row clearfix no-margin">
                <h3>
                    <strong>Title: </strong><?php echo $pageVars["data"]['pull_request']['title'] ; ?>
                </h3>
                <div>
                    <?php

                    if (isset($pageVars["data"]['pull_request']['status'])) {
                        if ($pageVars["data"]['pull_request']['status'] === 'rejected') {
                            ?>
                            <span class="pull_request_status_display btn btn-danger">
                                Rejected
                            </span>
                            <?php
                        } else if ($pageVars["data"]['pull_request']['status'] === 'closed') {
                            ?>
                            <span class="pull_request_status_display btn btn-danger">
                                Closed
                            </span>
                            <?php
                        } else if ($pageVars["data"]['pull_request']['status'] === 'open') {
                            ?>
                            <span class="pull_request_status_display btn btn-warning">
                                Open
                            </span>
                            <?php
                        } else if ($pageVars["data"]['pull_request']['status'] === 'accepted') {
                            ?>
                            <span class="pull_request_status_display btn btn-success">
                                Accepted
                            </span>
                            <?php
                        }
                    }

                    ?>
                </div>
                <h5>
                    <a href="index.php?control=UserProfilePublic&action=show&user=<?php echo $pageVars["data"]['pull_request']['requestor'] ; ?>"><?php echo $pageVars["data"]['pull_request']['requestor'] ; ?></a>
                    wants to merge 1 commit into <?php echo $pageVars["data"]['pull_request']['target_branch'] ; ?> from <?php echo $pageVars["data"]['pull_request']['source_branch'] ; ?>
                </h5>


                <?php

                if ($pageVars["data"]['pull_request']['status'] === 'rejected') {
                    ?>
                        <h4>This pull request has been rejected, on XX_DATE_XX by XX_USER_XX.</h4>
                    <?php
                }
                else if ($pageVars["data"]['pull_request']['status'] === 'accepted') {
                    ?>
                        <h4>This pull request has been accepted, on XX_DATE_XX by XX_USER_XX.</h4>
                    <?php
                }
                else if ($pageVars["data"]['pull_request']['status'] === 'open') {
                    ?>

                    <hr />

                    <h4>
                        Merge Request:
                    </h4>
                    <?php
                    $request_can_be_merged = true ;

                    if ($request_can_be_merged === true) {

                        ?>
                        <div class="form-group col-sm-12">

                            <div class="col-sm-8">
                                <h5>This pull request can be automatically merged </h5>
                            </div>

                            <div class="col-sm-4">
                                <i class="huge fa fa-check-square"></i>
                            </div>

                            <div class="col-sm-12">

                                <div class="col-sm-4">
                                <span id="merge_request_accept" class="btn btn-success ">
                                    Perform Merge
                                </span>
                                </div>

                                <div class="col-sm-4">
                                <span id="merge_request_reject" class="btn btn-danger ">
                                    Reject Request
                                </span>
                                </div>

                                <div class="col-sm-4">
                                </div>

                            </div>

                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="col-sm-8">
                            <h5>This pull request cannot be automatically merged </h5>
                        </div>

                        <div class="col-sm-12">

                            <div class="col-sm-4">
                            <span id="merge_unable_notify_requestor" class="btn btn-success ">
                                Notify Requestor
                            </span>
                            </div>

                            <div class="col-sm-4">
                            <span id="merge_request_reject" class="btn btn-danger ">
                                Reject Request
                            </span>
                            </div>

                            <div class="col-sm-4">
                            </div>

                        </div>
                        <?php
                    }


                if (isset($pageVars['data']['pharaoh_build_integration']) &&
                    $pageVars['data']['pharaoh_build_integration'] !== false) {
                    $pharaoh_build_integration = true ; }
                else {
                    $pharaoh_build_integration = false ; }

                if ($pharaoh_build_integration === true) {

                    ?>
                    <div class="form-group col-sm-12">
                        <hr />

                        <h4>
                            Pharaoh Build Integration:
                        </h4>

                        <?php echo count($pageVars['data']['pharaoh_build_integration']) ; ?>
                        check/s

                        <?php

                        foreach ($pageVars['data']['pharaoh_build_integration'] as $build_job) {

                            $build_status = $build_job['build_status']['status'] ;

                            if ($build_status === 'error') {
                                ?>
                                <div class="form-group col-sm-12 build_integration_row">
                                    <div class="col-sm-12">
                                        <h4 class="text-center">
                                            <strong>
                                                Error retrieving build status :
                                                <?php
                                                echo $build_job['build_status']['message'] ;
                                                ?>
                                            </strong>
                                        </h4>
                                        <hr class="no-margin-hr" />
                                    </div>
                                </div>

                                <?php
                            } else if ($build_job['build_status']['result'] === 'failure') {
                                ?>
                                <div class="form-group col-sm-12 build_integration_row">
                                    <div class="col-sm-12">
                                        <h4 class="text-center">
                                            <strong>
                                                Build Status Failed :
                                                <?php
                                                echo $build_job['build_status']['data'] ;
                                                ?>
                                            </strong>
                                        </h4>
                                        <hr class="no-margin-hr" />
                                    </div>
                                </div>

                                <?php
                            } else {
//                                var_dump($build_job) ;

                                if ($build_job['results']['status'] === 'success') {
                                    $text_status = "Passing" ;
                                    $btn_class = "btn-success" ;
                                }
                                else if ($build_job['results']['status'] === 'pending') {
                                    $text_status = "Pending" ;
                                    $btn_class = "btn-warning" ;
                                }
                                else if ($build_job['results']['status'] === 'failure') {
                                    $text_status = "Failed" ;
                                    $btn_class = "btn-danger" ;
                                }
                                else {
                                    $text_status = "Passing" ;
                                    $btn_class = "btn-success" ;
                                }
                                ?>

                                <div class="form-group col-sm-12 build_integration_row">
                                    <div class="col-sm-12">
                                        <h4 class="text-center">
                                            Build Job:
                                            <strong>
                                                <a target="_blank" href="<?php echo $build_job['build_status']['data']['build_job_link'] ; ?>">
                                                    <?php echo $build_job['build_status']['data']['build_job_title'] ; ?>
                                                </a>
                                            </strong>
                                        </h4>
                                        <hr class="no-margin-hr" />
                                    </div>
                                    <div class="col-sm-2">
                                    <span class="btn <?php echo $btn_class ; ?>">
                                        <h3><?php echo $text_status ; ?></h3>
                                    </span>
                                    </div>
                                    <div class="col-sm-10">
                                        <h5>Build Link:
                                            <a target="_blank" href="<?php echo $build_job['build_status']['data']['build_job_link'] ; ?>">
                                                <?php echo $build_job['build_status']['data']['build_job_link'] ; ?>
                                            </a>
                                        </h5>
                                        <h5>Run ID:
                                            <a target="_blank" href="<?php echo $build_job['build_status']['data']['build_run_link'] ; ?>">
                                                <?php echo $build_job['build_status']['data']['build_id'] ; ?>
                                            </a>
                                        </h5>
                                        <h5>Run Time: <?php echo date('H:i d/m/Y', $build_job['build_status']['data']['build_run_time']) ; ?></h5>
                                    </div>
                                </div>

                                <?php

                            }

                        }

                        ?>

                    </div>

                    <?php
                }
                ?>

                <div class="form-group col-sm-12">
                    <hr />
                    <div id="comments_table">
                    <?php
                        $comments = $pageVars["data"]['pull_request_comments'] ;

                        if (is_array($comments) && count($comments)>0) {
                            ?>
                            <h4>Comments:</h4>
                            <?php
                            foreach ($comments as $comment) {
                                ?>
                                <div class="form-group col-sm-12 comment_row">
                                    <div class="fullWidth">
                                        <div class="col-sm-6">
                                            <?php echo $comment['requestor'] ; ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php echo date('H:i d/m/Y', $comment['created_on']) ; ?>
                                        </div>
                                    </div>
                                    <div class="fullWidth">
                                        <p>
                                            <?php echo $comment['data'] ; ?>
                                        </p>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="form-group col-sm-12">
                                <h4>No comments have been made yet</h4>
                            </div>
                            <?php
                        }
                    ?>
                    </div>

                </div>

                <div class="form-group col-sm-12">
                    <hr />
                    <h4>
                        New Comment:
                    </h4>
                    <textarea class="col-sm-12 new_pr_comment_field"
                              name="new_pull_request_comment"
                              id="new_pull_request_comment"></textarea>
                    <span id="save_new_pull_request_comment" class="new_pr_comment_field btn btn-success">
                        Add Comment
                    </span>
                </div>

                <div class="col-sm-12">
                    <div class="col-sm-12 loading_pull_request_comments">
                        <img src="/Assets/Modules/DefaultSkin/image/loader.gif" alt="Saving Comment" />
                    </div>
                </div>

                <input type="hidden" name="pr_id" id="pr_id" value="<?php echo $pageVars["data"]['pull_request']['pr_id'] ; ?>">
                <input type="hidden" name="repo_name" id="repo_name" value="<?php echo $pageVars["data"]['repository']['project-slug'] ; ?>">

                <?php

                    // end if pull request is open
                }
                ?>
            </div>

        </div>

    </div>
</div>
<link rel="stylesheet" type="text/css" href="/Assets/Modules/PullRequest/css/pullrequest.css">
