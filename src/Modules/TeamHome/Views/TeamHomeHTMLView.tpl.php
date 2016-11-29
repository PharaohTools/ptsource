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
                        <a href="/index.php?control=TeamList&amp;action=show" class="hvr-bounce-in">
                            <i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Teams
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=TeamConfigure&action=show&item=<?php echo $pageVars["data"]["team"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa  fa-cog fa-fw hvr-bounce-in"></i> Configure
                        </a>
                    </li>

                <?php

                }

                ?>
                
                    <li>
                        <a href="index.php?control=FileBrowser&action=show&item=<?php echo $pageVars["data"]["team"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=TeamCharts&action=show&item=<?php echo $pageVars["data"]["team"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=TeamHistory&action=show&item=<?php echo $pageVars["data"]["team"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-history fa-fw hvr-bounce-in""></i> History <span class="badge"></span>
                        </a>
                    </li>
                    <?php
                        if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {
                    ?>

                    <li>
                        <a href="index.php?control=TeamHome&action=delete&item=<?php echo $pageVars["data"]["team"]["project-slug"] ; ?>" class="hvr-bounce-in">
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


                if (isset($pageVars["data"]["team"]["project-name"])) {
                    $slugOrName = $pageVars["data"]["team"]["project-name"] ; }
                else if (isset($pageVars["data"]["team"]["project-slug"])) {
                    $slugOrName = $pageVars["data"]["team"]["project-slug"] ; }
                else {
                    $slugOrName = "Unnamed Project" ; }

                if (isset($pageVars["data"]["team"]["project-description"])) {
                    $slugOrDescription = $pageVars["data"]["team"]["project-description"] ; }
                else {
                    $slugOrDescription = "No Description configured for Project" ; }

                if (isset($pageVars["data"]["team"]["project-owner"])) {
                    $ownerOrDescription = $pageVars["data"]["team"]["project-owner"] ; }
                else {
                    $ownerOrDescription = "No Owner configured for Project" ; }

                ?>
           
            <div class="row clearfix no-margin">
            	<h3 class="text-uppercase text-light ">Team: <strong><?php echo $slugOrName ; ?></strong> </h3>
                <p> Slug: <?php echo $pageVars["data"]["team"]["project-slug"] ; ?></p>
                <p> Description: <?php echo $slugOrDescription ; ?></p>
                <p> Owner: <?php echo $ownerOrDescription ; ?></p>
            </div>
                <?php

                $ht_string = ($pageVars["data"]["is_https"] == true) ? 'HTTPS' : 'HTTP' ;
                $ht_string_lower = strtolower($ht_string) ;
                ?>
                    
                    <?php
                    if (isset($pageVars["data"]["user"]->username)) {

                        $ownerOrPublic = (isset($pageVars["data"]["team"]["project-owner"]) &&
                            strlen($pageVars["data"]["team"]["project-owner"])>0) ?
                            $pageVars["data"]["team"]["project-owner"] : "public" ;
                        ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <hr />
                            <div class="col-sm-4">
                                <span id="select_clone" class="centered_button select_git_command btn btn-success">Clone</span>
                            </div>
                            <div class="col-sm-4">
                                <span id="select_push" class="centered_button select_git_command btn btn-warning">Push</span>
                            </div>
                            <div class="col-sm-4">
                                <span id="select_pull" class="centered_button select_git_command btn btn-warning">Pull</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <h2 class="git_command_text"><strong id="git_command_string">git clone</strong> <?php echo "{$ht_string_lower}://{$pageVars["data"]["user"]->username}:{password}@{$_SERVER["SERVER_NAME"]}/git/{$ownerOrPublic}/{$pageVars["data"]["team"]["project-slug"]} "  ; ?></h2>
                        </div>
                        <div class="col-sm-12">
                            <span class="col-sm-3 centered_button btn btn-success">Write Enabled</span>
                        </div>
                    </div>
                    <?php                        
                    }
                    else {
                    ?>

                <div class="row">
                    <div class="col-sm-12">
                        <hr />
                        <?php

                        if ($pageVars["data"]["team"]["settings"]["PublicScope"]["enabled"] == "on") {
                            if ($pageVars["data"]["team"]["settings"]["PublicScope"]["public_read"] == "on") { ?>

                        <div class="col-sm-4">
                            <span id="select_clone" class="centered_button select_git_command btn btn-success">Clone</span>
                        </div>

                        <?php

                        if (in_array($pageVars["data"]["current_user_role"], array("1", "2")) ||
                            $pageVars["data"]["team"]["settings"]["PublicScope"]["public_write"] == "on") { ?>
                            <div class="col-sm-4">
                                <span id="select_push" class="centered_button select_git_command btn btn-warning">Push</span>
                            </div>
                            <div class="col-sm-4">
                                <span id="select_pull" class="centered_button select_git_command btn btn-warning">Pull</span>
                            </div>

                        <?php } ?>
                    </div>

                    <div class="col-sm-12">
                        <h2 class="git_command_text"><strong id="git_command_string">git clone</strong> <?php echo "{$ht_string_lower}://anon:any@{$_SERVER["SERVER_NAME"]}/git/public/{$pageVars["data"]["team"]["project-slug"]} "  ; ?></h2>
                    </div>

                        <?php } ?>
                    <div class="col-sm-12">

                        <?php

                        if (in_array($pageVars["data"]["current_user_role"], array("1", "2")) ||
                            $pageVars["data"]["team"]["settings"]["PublicScope"]["public_write"] == "on") {?>
                                <span class="col-sm-3 centered_button btn btn-success">Write Enabled</span>
                        <?php } else ?>
                                <span class="col-sm-3 centered_button btn btn-danger">Write Disabled</span>
                        <?php }
                        ?>

                    </div>
                    </div>
                        <?php
                        } ?>

                <hr />
            <div class="row clearfix no-margin build-home-properties">
                <div class="fullRow">
                    <div class="pipe-features-block pipe-block">
                        <h4 class="propertyTitle">Team Features:</h4>
                        <div class="col-sm-12">
                            <?php
                            if (isset($pageVars["data"]["features"]) &&
                                count($pageVars["data"]["features"])>0 ) {
                                foreach ($pageVars["data"]["features"] as $team_feature) {
                                    if (isset($team_feature["hidden"]) && $team_feature["hidden"] != true
                                        || !isset($team_feature["hidden"]) ) {
                                        echo '<div class="team-feature">' ;
                                        echo '<a target="_blank" href="'.$team_feature["model"]["link"].'">' ;
                                        echo  '<h3>'.$team_feature["model"]["title"].'</h3>' ;
                                        echo  '<img src="'.$team_feature["model"]["image"].'" />' ;
                                        echo "</a>" ;
                                        echo '</div>' ; } } }
                            else {
                                ?>
                                <h5>No Features configured for Team</h5>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
                <div class="fullRow">
                    <div class="pipe-history-block pipe-block">
                        <h4 class="propertyTitle">Team History:</h4>
                        <?php
                        if (isset($pageVars["data"]["history"]) && count($pageVars["data"]["history"])>0 ) {
                        $i = 1;

                        foreach ($pageVars["data"]["history"]["commits"] as $commitDetails) {
                        ?>

                        <div class="commitRow" id="blRow_<?php echo $commitDetails["commit"]; ?>" >
                            <div class="blCell cellRowIndex" scope="row"><?php echo $i; ?> </div>
                            <div class="blCell cellRowMessage"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["team"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo $commitDetails["message"]; ?>  </a> </div>
                            <div class="blCell cellRowAuthor"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["team"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo $commitDetails["author"]; ?>  </a> </div>
                            <div class="blCell cellRowDate"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["team"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo $commitDetails["date"]; ?>  </a> </div>
                            <div class="blCell cellRowHash"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["team"]["project-slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo substr($commitDetails["commit"], 0, 6); ?>  </a> </div>
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
                            <h5>No Readme file available in Team</h5>
                        <?php } ?>

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
<link rel="stylesheet" type="text/css" href="/Assets/Modules/TeamHome/css/teamhome.css">
<link rel="stylesheet" type="text/css" href="/Assets/Modules/TeamHistory/css/teamhistory.css">