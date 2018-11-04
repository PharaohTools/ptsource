<div class="container" id="wrapper">

    
        <div class="col-lg-12">
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
                                <a href="/index.php?control=RepositoryConfigure&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                                    <i class="fa  fa-cog fa-fw hvr-bounce-in"></i> Configure
                                </a>
                            </li>

                            <?php

                        }

                        ?>

                        <li>
                            <a href="/index.php?control=FileBrowser&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                                <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                            </a>
                        </li>

                        <?php
                        if ($pageVars["data"]["repository"]["project-type"] === 'raw') {
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
                        if ($pageVars["data"]["repository"]["project-type"] === 'git') {
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

                        <?php
                        if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {
                            ?>

                            <li>
                                <a href="/index.php?control=RepositoryHome&action=delete&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                                    <i class="fa fa-trash fa-fw hvr-bounce-in"></i> Delete
                                </a>
                            </li>

                            <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>

            <div class="well well-lg ">
                <?php


                if (isset($pageVars["data"]["repository"]["project-name"])) {
                    $slugOrName = $pageVars["data"]["repository"]["project-name"] ; }
                else if (isset($pageVars["data"]["repository"]["project-slug"])) {
                    $slugOrName = $pageVars["data"]["repository"]["project-slug"] ; }
                else {
                    $slugOrName = "Unnamed Project" ; }

                if (isset($pageVars["data"]["repository"]["project-description"])) {
                    $slugOrDescription = $pageVars["data"]["repository"]["project-description"] ; }
                else {
                    $slugOrDescription = "No Description configured for Project" ; }

                if (isset($pageVars["data"]["repository"]["project-owner"])) {
                    $ownerOrDescription = $pageVars["data"]["repository"]["project-owner"] ; }
                else {
                    $ownerOrDescription = "No Owner configured for Project" ; }

                ?>
           
            <div class="row clearfix no-margin">
            	<h3 class="text-uppercase text-light ">Repository: <strong><?php echo $slugOrName ; ?></strong> </h3>
                <p> Slug: <?php echo $pageVars["data"]["repository"]["project-slug"] ; ?></p>
                <p> Description: <?php echo $slugOrDescription ; ?></p>
                <p> Owner: <?php echo $ownerOrDescription ; ?></p>
            </div>

                <?php


                $ht_string = ($pageVars["data"]["is_https"] == true) ? 'HTTPS' : 'HTTP' ;
                $ht_string_lower = strtolower($ht_string) ;

                $pt = (isset($pageVars["data"]["repository"]["project-type"])) ?
                    $pageVars["data"]["repository"]["project-type"] :
                    'git' ;
                if ($pt == 'git') {
                    require (__DIR__.DIRECTORY_SEPARATOR.'git_repo_home.php') ;
                }
                else if ($pt == 'raw') {
                    require (__DIR__.DIRECTORY_SEPARATOR.'raw_repo_home.php') ;
                }
                ?>

                <hr />
            <div class="row clearfix no-margin build-home-properties">
                <div class="fullRow">
                    <div class="pipe-features-block pipe-block">
                        <h4 class="propertyTitle">Repository Features:</h4>
                        <div class="col-sm-12">
                            <?php
                            if (isset($pageVars["data"]['features']) &&
                                count($pageVars["data"]['features'])>0 ) {
                                foreach ($pageVars["data"]['features'] as $repository_feature) {
                                    if ( (isset($repository_feature["hidden"]) && $repository_feature["hidden"] != true)
                                        || !isset($repository_feature["hidden"]) ) {
                                        echo '<div class="repository-feature">' ;
                                        echo ' <a target="_blank" href="'.$repository_feature["model"]["link"].'">' ;
                                        echo '  <h3>'.$repository_feature["model"]["title"].'</h3>' ;
                                        echo '  <img src="'.$repository_feature["model"]["image"].'" />' ;
                                        echo ' </a>' ;
                                        echo '</div>' ; } } }
                            else {
                                ?>
                                <h5>No Features configured for Repository</h5>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
                <div class="fullRow">
                    <div class="pipe-history-block pipe-block">
                        <h4 class="propertyTitle">Repository History:</h4>
                        <?php
                        if (isset($pageVars["data"]["history"]) && count($pageVars["data"]["history"])>0 ) {
                        $i = 1;

                        foreach ($pageVars["data"]["history"]["commits"] as $commitDetails) {
                        ?>

                        <div class="commitRow" id="blRow_<?php echo $commitDetails["commit"]; ?>" >
                            <div class="blCell cellRowIndex" scope="row"><?php echo $i; ?> </div>
                            <div class="blCell cellRowMessage"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo $commitDetails["message"]; ?>  </a> </div>
                            <div class="blCell cellRowAuthor"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo $commitDetails["author"]; ?>  </a> </div>
                            <div class="blCell cellRowDate"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo str_replace(" +0000", "", $commitDetails["date"]); ?>  </a> </div>
                            <div class="blCell cellRowHash"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo substr($commitDetails["commit"], 0, 6); ?>  </a> </div>
                        </div>
                            <?php

                            $i++ ;
                            }
                        }
                            ?>
                    </div>
                </div>
                <div class="fullRow">
                    <hr />
                    <div class="pipe-history-block pipe-block">
                        <?php

                        if ($pageVars["data"]["repository"]["project-type"] === 'git') {

                            if (isset($pageVars["data"]["readme"]["exists"]) && $pageVars["data"]["readme"]["exists"] == true) {
                                ?>

                                <h4 class="propertyTitle">Readme:</h4>
                                <div class="readme_display">
                                    <?php
                                    if (isset($pageVars["data"]["readme"]["md"])) { echo $pageVars["data"]["readme"]["md"] ; }
                                    else if (isset($pageVars["data"]["readme"]["raw"])) { echo '<pre>'.$pageVars["data"]["readme"]["raw"].'</pre>' ; }
                                    else { echo "Readme Reports that it exists but left no data." ;  }
                                    ?>
                                </div>

                            <?php } else { ?>
                                <h4 class="propertyTitle">Readme:</h4>
                                <h5>No Readme file available in Repository</h5>
                            <?php }

                        } ?>

                    </div>
                </div>

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
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryHome/css/repositoryhome.css">
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryHistory/css/repositoryhistory.css">