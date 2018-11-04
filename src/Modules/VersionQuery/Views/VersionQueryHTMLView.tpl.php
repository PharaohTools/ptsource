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
                <li>
                    <a href="/index.php?control=Index&action=show" class="hvr-bounce-in">
                        <i class="fa fa-dashboard hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryHome&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-home hvr-bounce-in"></i>  Repository Home
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryList&action=show"class="hvr-bounce-in">
                        <i class="fa fa-bars hvr-bounce-in"></i> All Repositories
                    </a>
                </li>
                <li>
                    <a href="index.php?control=FileBrowser&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                    </a>
                </li>

                <?php
                if (in_array($pageVars["data"]["repository"]["project-type"], 'raw')) {
                    ?>

                    <li>
                        <a href="/index.php?control=VersionQuery&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-folder-open-o hvr-bounce-in"></i> Versions
                        </a>
                    </li>

                    <?php
                }
                ?>

                <?php
                if (in_array($pageVars["data"]["repository"]["project-type"], 'git')) {
                    ?>


                    <li>
                        <a href="/index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryPullRequests&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-code fa-fw hvr-bounce-in"></i> Pull Requests <span class="badge"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryReleases&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-code fa-fw hvr-bounce-in"></i> Releases <span class="badge"></span>
                        </a>
                    </li>

                    <?php
                }
                ?>

            </ul>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="well well-lg">
            <?php echo $this->renderLogs() ; ?>
            <div class="row clearfix no-margin">

                <h4 class="text-uppercase text-light">Versions:</h4>

                <div class="row clearfix no-margin">
                <h5 class="text-uppercase text-light" style="margin-top: 15px;margin-left: 51px;">  </h5>
                <div class="col-sm-12">

                    <div role="tabpanel grid">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all">
                                <div class="table-responsive">
                                    <div class="table table-striped table-bordered table-condensed">

                                        <div id="allOAuthKeyRows" class="allOAuthKeyRows table-hover">

                                            <?php

                                            if (isset($pageVars['data']['version']['groups_disabled'])) {
                                                $group_label = 'Groups are disabled for this Repository' ;
                                            }

                                            foreach ($pageVars['data']['version'] as $group_label => $version_set) {

//                                                if (!isset($version_set['groups_disabled'])) {
//                                                    $group_label = 'Groups are disabled for this Repository' ;
//                                                }

                                                ?>

                                                <div class="fullRow">
                                                    <h2><?php echo $group_label; ?></h2>
                                                    <h3>Current Version:</h3>
                                                    <h5><strong>Version: </strong><?php echo $version_set['current']['version']; ?></h5>
                                                    <h5><strong>Path: </strong><?php echo $version_set['current']['path']; ?></h5>
                                                    <h3>Next Version:</h3>
                                                    <h5><strong>Version: </strong><?php echo $version_set['next']['version']; ?></h5>
                                                    <h5><strong>Path: </strong><?php echo $version_set['next']['path']; ?></h5>
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
                </div>
            </div>
     
            <hr />

            <p class="text-center">
                Visit www.pharaohtools.com for more
            </p>
        </div>
</div><!-- container -->
<link rel="stylesheet" href="/Assets/Modules/UserOAuthKey/css/useroauthkey.css">