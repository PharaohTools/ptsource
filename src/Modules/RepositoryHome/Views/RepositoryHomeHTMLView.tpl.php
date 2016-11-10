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
                        <a href="index.php?control=RepositoryMonitor&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Monitors
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
                        <a href="index.php?control=RepositoryHome&action=delete&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
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


                if (isset($repositoryDetails["project-name"])) {
                    $slugOrName = $repositoryDetails["project-name"] ; }
                else if (isset($pageVars["data"]["repository"]["project-slug"])) {
                    $slugOrName = $pageVars["data"]["repository"]["project-slug"] ; }
                else {
                    $slugOrName = "Unnamed Project" ; }

                if (isset($pageVars["data"]["repository"]["project-description"])) {
                    $slugOrDescription = $pageVars["data"]["repository"]["project-description"] ; }
                else {
                    $slugOrDescription = "No Description configured for Project" ; }

                ?>
           
            <div class="row clearfix no-margin">
            	<h3 class="text-uppercase text-light ">Repository: <strong><?php echo $slugOrName ; ?></strong> </h3>
                <p> Project Slug: <?php echo $pageVars["data"]["repository"]["project-slug"] ; ?></p>
                <p> Project Desc: <?php echo $slugOrDescription ; ?></p>
            </div>
                <?php

                $ht_string = ($pageVars["data"]["is_https"] == true) ? 'HTTPS' : 'HTTP' ;
                $ht_string_lower = strtolower($ht_string) ;
                ?>
                <div class="row">
                    
                    <?php
                    if (isset($pageVars["data"]["user"]->username)) {
                        ?>

                        <hr />
                        <h3 class="propertyTitle">Clone, Push or Pull:</h3>
                        <div class="col-sm-10">
                            <h4><?php echo $ht_string ; ?>: <?php echo "{$ht_string_lower}://{$pageVars["data"]["user"]->username}:{password}@{$_SERVER["SERVER_NAME"]}/git/public/{$pageVars["data"]["repository"]["project-slug"]} "  ; ?></h4>
                        </div>
                        <div class="col-sm-2">
                            <span class="btn btn-success">Write Enabled</span>
                        </div>
                    
                    <?php                        
                    }
                    else {
                    ?>
                    
                </div>
                <div class="row">
                    <?php

                    if ($pageVars["data"]["repository"]["settings"]["PublicScope"]["enabled"] == "on") {
                        if ($pageVars["data"]["repository"]["settings"]["PublicScope"]["public_read"] == "on") {?>

                    <hr />
                    <h3 class="propertyTitle">Clone, Push or Pull:</h3>

                    <div class="col-sm-10">
                        <h4><?php echo $ht_string ; ?>: <?php echo "{$ht_string_lower}://anon:any@{$_SERVER["SERVER_NAME"]}/git/public/{$pageVars["data"]["repository"]["project-slug"]} "  ; ?></h4>
                    </div>

                        <?php }
                        if ($pageVars["data"]["repository"]["settings"]["PublicScope"]["public_write"] == "on") {?>
                            <div class="col-sm-3">
                                <span class="btn btn-success">Write Enabled</span>
                            </div>
                        <?php } else ?>
                            <div class="col-sm-3">
                                <span class="btn btn-danger">Write Disabled</span>
                            </div>
                        <?php
                            } }
                    ?></div>

                <hr />
            <div class="row clearfix no-margin build-home-properties">

                <div class="pipe-features-block pipe-block">
                    <h4 class="propertyTitle">Repository Features:</h4>
                    <div class="col-sm-12">
                    <?php
                    if (isset($pageVars["data"]["features"]) &&
                        count($pageVars["data"]["features"])>0 ) {
                        foreach ($pageVars["data"]["features"] as $repository_feature) {
                            if (isset($repository_feature["hidden"]) && $repository_feature["hidden"] != true
                                || !isset($repository_feature["hidden"]) ) {
                                echo '<div class="repository-feature">' ;
                                echo '<a target="_blank" href="'.$repository_feature["model"]["link"].'">' ;
                                echo  '<h3>'.$repository_feature["model"]["title"].'</h3>' ;
                                echo  '<img src="'.$repository_feature["model"]["image"].'" />' ;
                                echo "</a>" ;
                                echo '</div>' ; } } }
                    else {
                        ?>
                            <h5>No Features configured for Repository</h5>
                        <?php
                    }
                    ?>
                    </div>
                </div>
                <div class="pipe-history-block pipe-block">
                    <h4 class="propertyTitle">Repository History:</h4>
                    <?php
                    if (isset($pageVars["data"]["history"]) && count($pageVars["data"]["history"])>0 ) {
                    $i = 1;

                    foreach ($pageVars["data"]["history"]["commits"] as $commitDetails) {
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
                    }
                    ?>
                </div>
                <div class="pipe-history-block pipe-block">
                    <?php

                    if (isset($pageVars["data"]["readme"]["exists"]) && $pageVars["data"]["readme"]["exists"] == true) {
                        ?>

                        <h4 class="propertyTitle">Readme:</h4>

                        <?php
                        if (isset($pageVars["data"]["readme"]["md"])) { echo $pageVars["data"]["readme"]["md"] ; }
                        else if (isset($pageVars["data"]["readme"]["raw"])) { echo $pageVars["data"]["readme"]["raw"] ; }
                        else { echo "Readme Reports that it exists but left no data." ;  }
                        ?>

                        <?php
                    }
                    ?>
                </div>

               <hr>
                <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>
            </div>

        </div>

    </div>
</div>
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryHome/css/repositoryhome.css">
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryHistory/css/repositoryhistory.css">
<script type="text/javascript" src="/Assets/Modules/RepositoryHome/js/repositoryhome.js"></script>