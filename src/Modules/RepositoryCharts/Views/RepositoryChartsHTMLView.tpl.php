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
                        <a href="index.php?control=RepositoryCharts&action=delete&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
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
                ?>
            <div class="row">
                <div class="col-sm-12">
                    <hr />
                    <div class="col-sm-6">
                        Contributors: <strong><?php echo count($pageVars["data"]["repository_charts"]["contributors"]) ; ?></strong>
                    </div>
                    <div class="col-sm-6">
<!--                        <h5>data</h5>-->
                        <?php # var_dump($pageVars["data"]) ; ?>
                        <h5>contributors</h5>
                        <?php  var_dump($pageVars["data"]["repository_charts"]["statistics"]["contributors"]) ; ?>
                        <h5>date</h5>
                        <?php  var_dump($pageVars["data"]["repository_charts"]["date"]) ; ?>
                        <h5>day</h5>
                        <?php  var_dump($pageVars["data"]["repository_charts"]["day"]) ; ?>
                        <h5>hour</h5>
                        <?php  var_dump($pageVars["data"]["repository_charts"]["hour"]) ; ?>
                    </div>
                </div>
                <div class="col-sm-12">
                    <h2 class="git_command_text"><strong id="git_command_string">git clone</strong> <?php echo "{$ht_string_lower}://{$pageVars["data"]["user"]->username}:{password}@{$_SERVER["SERVER_NAME"]}/git/{$ownerOrPublic}/{$pageVars["data"]["repository"]["project-slug"]} "  ; ?></h2>
                </div>
                <div class="col-sm-12">
                    <span class="col-sm-3 centered_button btn btn-success">Write Enabled</span>
                </div>
            </div>

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
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryCharts/css/repositoryhome.css">
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryHistory/css/repositoryhistory.css">