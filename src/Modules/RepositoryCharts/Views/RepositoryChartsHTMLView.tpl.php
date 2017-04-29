<div class="container" id="wrapper">
       
        <div id="page_sidebar" class="navbar-default col-sm-2 sidebar" role="navigation">
		    <div class="sidebar-nav ">

                <div class="sidebar-search">
                    <button class="btn btn-success" id="menu_visibility_label" type="button">
                        Show Menu
                    </button>
                    <i class="fa fa-1x fa-toggle-off hvr-grow" id="menu_visibility_switch"></i>
                </div>
			<ul class="nav in" id="side-menu">

                <?php

                if (in_array($pageVars['data']["current_user_role"], array("1", "2"))) {

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
                        <a href="index.php?control=RepositoryConfigure&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa  fa-cog fa-fw hvr-bounce-in"></i> Configure
                        </a>
                    </li>

                <?php

                }

                ?>
                
                    <li>
                        <a href="index.php?control=FileBrowser&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"></span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryPullRequests&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-history fa-fw hvr-bounce-in"></i> Pull Requests <span class="badge"></span>
                        </a>
                    </li>
                    <?php
                        if (in_array($pageVars['data']["current_user_role"], array("1", "2"))) {
                    ?>

                    <li>
                        <a href="index.php?control=RepositoryCharts&action=delete&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-trash fa-fw hvr-bounce-in"></i> Delete
                        </a>
                    </li>

                <?php
                    }
                ?>

            </ul>
        </div>
        </div>
    
        <div class="col-lg-12">

            <div class="well well-lg ">
                <?php


                if (isset($pageVars['data']["repository"]["project-name"])) {
                    $slugOrName = $pageVars['data']["repository"]["project-name"] ; }
                else if (isset($pageVars['data']["repository"]["project-slug"])) {
                    $slugOrName = $pageVars['data']["repository"]["project-slug"] ; }
                else {
                    $slugOrName = "Unnamed Project" ; }

                if (isset($pageVars['data']["repository"]["project-description"])) {
                    $slugOrDescription = $pageVars['data']["repository"]["project-description"] ; }
                else {
                    $slugOrDescription = "No Description configured for Project" ; }

                if (isset($pageVars['data']["repository"]["project-owner"])) {
                    $ownerOrDescription = $pageVars['data']["repository"]["project-owner"] ; }
                else {
                    $ownerOrDescription = "No Owner configured for Project" ; }

                ?>
           
            <div class="row clearfix no-margin">
            	<h3 class="text-uppercase text-light ">Repository: <strong><?php echo $slugOrName ; ?></strong> </h3>
                <p> Slug: <?php echo $pageVars['data']["repository"]["project-slug"] ; ?></p>
                <p> Description: <?php echo $slugOrDescription ; ?></p>
            </div>


            <?php

            if (count($pageVars['data']['repository_charts']['statistics']) == 0) {

                ?>

                <div class="row">
                    <h3>No Statistics could be generated</h3>
                </div>

                <?php
            }
            else {
                ?>

            <div class="row">

                <div class="col-lg-3 col-md-4 hvr-pop">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-database fa-4x hvr-buzz-out"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="chart_feature_text huge hvr-grow-rotate" >
                                        <?php echo $pageVars['data']['repository_charts']['statistics']["Total contributors"]; ?>
                                    </div>
                                    <div>Contributors</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 hvr-pop">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check-circle fa-4x hvr-buzz-out"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="chart_feature_text huge hvr-grow-rotate">
                                        <?php echo $pageVars['data']['repository_charts']['statistics']["Total commits"]; ?>
                                    </div>
                                    <div>Commits</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 hvr-pop">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check-circle fa-4x hvr-buzz-out"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="chart_feature_text huge hvr-grow-rotate">
                                        <?php echo $pageVars['data']['repository_charts']['statistics']["Average commits per day"]; ?>
                                    </div>
                                    <div>Daily</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 hvr-pop">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check-circle fa-4x hvr-buzz-out"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="chart_feature_text huge hvr-grow-rotate">
                                        <?php echo str_replace(" days", "", $pageVars['data']['repository_charts']['statistics']["Active for"]) ; ?>
                                    </div>
                                    <div>Days Active</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 hvr-pop">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check-circle fa-4x hvr-buzz-out"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge hvr-grow-rotate">
                                        <?php echo $pageVars['data']['repository_charts']['statistics']["First commit date"]; ?>
                                    </div>
                                    <div>First commit date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 hvr-pop">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check-circle fa-4x hvr-buzz-out"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge hvr-grow-rotate">
                                        <?php echo $pageVars['data']['repository_charts']['statistics']["Latest commit date"] ; ?>
                                    </div>
                                    <div>Latest commit date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <hr />
                    <div class="col-sm-4">
                        <h5>Total Contributors:</h5>
                        <strong>
                            <?php
//                            var_dump($pageVars['data']['repository_charts']) ;

                            echo $pageVars['data']['repository_charts']['statistics']["Total contributors"] ; ?>
                        </strong>
                    </div>
                    <div class="col-sm-4">
                        <h5>Total commits:</h5>
                        <strong>
                            <?php echo $pageVars['data']['repository_charts']['statistics']["Total commits"] ; ?>
                        </strong>
                    </div>
                    <div class="col-sm-4">
                        <h5>Average commits per day:</h5>
                        <strong>
                            <?php echo $pageVars['data']['repository_charts']['statistics']["Average commits per day"] ; ?>
                        </strong>
                    </div>
                    <hr />
                    <div class="col-sm-4">
                        <h5>Active for:</h5>
                        <strong>
                            <?php echo $pageVars['data']['repository_charts']['statistics']["Active for"] ; ?>
                        </strong>
                    </div>
                    <div class="col-sm-4">
                        <h5>First commit date:</h5>
                        <strong>
                            <?php echo $pageVars['data']['repository_charts']['statistics']["First commit date"] ; ?>
                        </strong>
                    </div>
                    <div class="col-sm-4">
                        <h5>Latest commit date:</h5>
                        <strong>
                            <?php echo $pageVars['data']['repository_charts']['statistics']["Latest commit date"] ; ?>
                        </strong>
                    </div>

                </div>

            </div>

            <?php
            }
            ?>

            <div class="row clearfix no-margin build-home-properties">
                <div class="fullRow">
                    <hr />
                    <p class="text-center">
                        Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
                    </p>
                </div>
            </div>

        </div>

    </div>
</div>
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryCharts/css/repositorycharts.css">
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryHistory/css/repositoryhistory.css">