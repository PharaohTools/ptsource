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
                        <i class="fa fa-history fa-fw hvr-bounce-in""></i> History <span class="badge"></span>
                    </a>
                </li>

                <?php
                if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {
                    ?>

                    <li>
                        <a href="index.php?control=PullRequest&action=delete&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-trash fa-fw hvr-bounce-in""></i> Delete
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
            	<h3 class="text-uppercase text-light">Pull Request</h3>
                <p><strong>Requestor: </strong><?php echo $pageVars["data"]['pull_request']['requestor'] ; ?></p>
                <p><strong>Source Branch: </strong><?php echo $pageVars["data"]['pull_request']['source_branch'] ; ?></p>
                <p><strong>Source Commit: </strong><?php echo $pageVars["data"]['pull_request']['source_commit'] ; ?></p>
                <p><strong>Target Branch: </strong><?php echo $pageVars["data"]['pull_request']['target_branch'] ; ?></p>
                <hr />
            </div>

            <div class="row clearfix no-margin">
                <h3>
                    <strong>Title: </strong><?php echo $pageVars["data"]['pull_request']['title'] ; ?>
                </h3>
                <div>
                    <?php

                    if ($pageVars["data"]['pull_request']['open'] === false) {
                        ?>
                            <span class="btn btn-danger">
                                Closed
                            </span>
                        <?php
                    } else {
                        ?>
                            <span class="btn btn-success">
                                Open
                            </span>
                        <?php
                    }

                    ?>
                </div>
                <h5>
                    <a href="index.php?control=UserProfilePublic&action=show&user=<?php echo $pageVars["data"]['pull_request']['requestor'] ; ?>"><?php echo $pageVars["data"]['pull_request']['requestor'] ; ?></a>
                    wants to merge 1 commit into <?php echo $pageVars["data"]['pull_request']['target_branch'] ; ?> from <?php echo $pageVars["data"]['pull_request']['source_branch'] ; ?>
                </h5>

                <hr />

                <p>
                    +2 −0
                    Conversation 0 Commits 1 Files changed 1
                    Reviewers
                    No reviews
                    Assignees
                    No one assigned
                    Labels
                    None yet
                    Projects
                    None yet
                    Milestone
                    No milestone
                    Notifications
                </p>
                <p>
                    You’re receiving notifications because you’re subscribed to this repository.
                    1 participant
                    @gitter-badger
                    @gitter-badger
                    gitter-badger commented on 10 Jul 2015
                    asmblah/uniter now has a Chat Room on Gitter
                </p>
                <p>
                    @asmblah has just created a chat room. You can visit it here: https://gitter.im/asmblah/uniter.
                    This pull-request adds this badge to your README.md:
                </p>
                <p>
                    Gitter
                </p>
                <h4>
                    If my aim is a little off, please let me know.
                    Happy chatting.
                </h4>
                <p>
                    PS: Click here if you would prefer not to receive automatic pull-requests from Gitter in future.
                    @gitter-badger 	Added Gitter badge
                    a3b849c
                    All checks have passed
                    1 successful check
                    continuous-integration/travis-ci/pr — The Travis CI build passed
                    Details
                    This branch has no conflicts with the base branch
                    Only those with write access to this repository can merge pull requests.
                </p>

                <?php

                if (isset($pageVars['data']['pharaoh_build_integration']) &&
                    $pageVars['data']['pharaoh_build_integration'] !== false) {
                    $pharaoh_build_integration = true ; }
                else {
                    $pharaoh_build_integration = false ; }

                if ($pharaoh_build_integration === true) {

                    ?>
                    <hr />

                    <?php

                    $status = $pageVars['data']['pharaoh_build_integration']['status'] ;
                    if ($status === 'passed') {
                        $text_status = "Passing" ;
                        $btn_class = "btn-success" ;
                    }
                    else if ($status === 'pending') {
                        $text_status = "Pending" ;
                        $btn_class = "btn-warning" ;
                    }
                    else if ($status === 'none') {
                        $text_status = "Passing" ;
                        $btn_class = "btn-primary" ;
                    }


                    ?>


                    Pharaoh Build Integration Status:
                    <span class="<?php echo $btn_class ; ?>">
                        <?php echo $text_status ; ?>
                    </span>
                    <?php echo $pageVars['data']['pharaoh_build_integration']['success_count'] ; ?> successful check/s
                    continuous-integration/travis-ci/pr — The Travis CI build passed


                    <?php
                }
                ?>


                <hr />
                <h4>
                    New Comment:
                </h4>
                <textarea>

                </textarea>
            </div>

        </div>

    </div>
</div>
<link rel="stylesheet" type="text/css" href="/Assets/Modules/PullRequest/css/commitdetails.css">
