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
                            <a href="index.php?control=TeamConfigure&action=show&item=<?php echo $pageVars["data"]["team"]["team_slug"] ; ?>" class="hvr-bounce-in">
                                <i class="fa  fa-cog fa-fw hvr-bounce-in"></i> Configure
                            </a>
                        </li>

                    <?php

                    }

                    ?>

                        <?php
                            if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {
                        ?>

                        <li>
                            <a href="index.php?control=TeamHome&action=delete&item=<?php echo $pageVars["data"]["team"]["team_slug"] ; ?>" class="hvr-bounce-in">
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


                if (isset($pageVars["data"]["team"]["team_name"])) {
                    $slugOrName = $pageVars["data"]["team"]["team_name"] ; }
                else if (isset($pageVars["data"]["team"]["team_slug"])) {
                    $slugOrName = $pageVars["data"]["team"]["team_slug"] ; }
                else {
                    $slugOrName = "Unnamed Team" ; }

                if (isset($pageVars["data"]["team"]["team_description"])) {
                    $slugOrDescription = $pageVars["data"]["team"]["team_description"] ; }
                else {
                    $slugOrDescription = "No Description configured for Team" ; }

                if (isset($pageVars["data"]["team"]["team_owner"])) {
                    $ownerOrDescription = $pageVars["data"]["team"]["team_owner"] ; }
                else {
                    $ownerOrDescription = "No Owner configured for Team" ; }

                ?>
           
            <div class="row clearfix no-margin">
            	<h3 class="text-uppercase text-light ">Team: <strong><?php echo $slugOrName ; ?></strong> </h3>
                <p> Slug: <?php echo $pageVars["data"]["team"]["team_slug"] ; ?></p>
                <p> Description: <?php echo $slugOrDescription ; ?></p>
                <p> Owner: <?php echo $ownerOrDescription ; ?></p>
            </div>

            <hr />

            <div class="row clearfix no-margin build-home-properties">
                <div class="fullRow">
                    <div class="pipe-features-block pipe-block">
                        <h4 class="propertyTitle">Team Features:</h4>
                        <div class="col-sm-12">
                            <?php
                            if (isset($pageVars["data"]["features"]) &&
                                count($pageVars["data"]["features"])>0 ) {
                                $i =0 ;
                                foreach ($pageVars["data"]["features"] as $team_feature) {
                                    if (isset($team_feature["hidden"]) && $team_feature["hidden"] != true
                                        || !isset($team_feature["hidden"]) ) {
                                        echo '<div class="team_feature">' ;
                                        echo ' <a target="_blank" href="'.$team_feature["model"]["link"].'">' ;
                                        echo  '  <h3>'.$team_feature["model"]["title"].'</h3>' ;
                                        echo  '  <img src="'.$team_feature["model"]["image"].'" />' ;
                                        echo " </a>" ;
                                        echo '</div>' ; }
                                        $i++ ; } }
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
                                <div class="blCell cellRowMessage"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["team"]["team_slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo $commitDetails["message"]; ?>  </a> </div>
                                <div class="blCell cellRowAuthor"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["team"]["team_slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo $commitDetails["author"]; ?>  </a> </div>
                                <div class="blCell cellRowDate"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["team"]["team_slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo $commitDetails["date"]; ?>  </a> </div>
                                <div class="blCell cellRowHash"><a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars["data"]["team"]["team_slug"]; ?>&identifier=<?php echo $pageVars["data"]["identifier"] ; ?>&commit=<?php echo $commitDetails["commit"] ; ?>" class="pipeName"><?php echo substr($commitDetails["commit"], 0, 6); ?>  </a> </div>
                                <?php

                                $i++ ; } }
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